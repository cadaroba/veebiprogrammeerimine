<?php
  //Leht kui olen sisse loginud
  require("functions_main.php");//test_inputi kontrollib piltide kirjeldust
  require("../../../config_vp2019.php");
  require("functions_user.php");
  require("functions_pic.php");
  require("classes/Picupload.class.php");
  //require("classes/Test.class.php");
  $database = "if19_robin_ka_1";
  
  //kontrollime kas on sisse logitud, kui kasutaja üritab ilma kasutajata sisse logida siis viskab siia
  if(!isset($_SESSION["userId"])){
	  header("Location: page.php");
	  exit();
  }
  //väljalogimine
  if(isset($_GET["logout"])){
	  session_destroy();
	  header("Location: page.php");
	  exit();
  }
  
  //TEST KLASSIGA TEGELEMINE
  //$myTest = new Test(20);
  //echo $myTest->privateNumber;//test et ei saa privaatasju echoda
  //echo $myTest->tellPublicSecret();
  //unset($myTest);//tühistatakse, mälu tühjendatakse ning myTest ei eksisteeri, töö lõpp
 
  
  $notice = null;
  $maxPicW = 600;
  $maxPicH = 400;
  
  $notice = null;
  $fileSizeLimit = 2500000;
  $maxPicW = 600;
  $maxPicH = 400;
  $fileNamePrefix = "vp_";
  $waterMarkFile = "../vp_pics/vp_logo_w100_overlay.png";
  $waterMarkLocation = mt_rand(1,4); //1- ülal vasakul, 2 - ülal paremal, 3 - all paremal, 4 - all vasakul, 5 - keskel
  $waterMarkFromEdge = 10;
  $thumbW = 100;
  $thumbH = 100;
  
  //var_dump($_POST); 
  //var_dump($_FILES);
  $userName = $_SESSION["userFirstname"] . " " .$_SESSION["userLastname"];
  require("header.php"); //nõuab tükki minu kasutast
  echo "<h1>" . $userName .", laeb üles faili JPG, JPEG, PNG & GIF.</h1>";
  
  //PILDI ÜLESLAADIMISE OSA-------------------------------------------------------------------------------
	//$target_dir = "uploads/";
	//$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	
	$uploadOk = 1;
	
	// Check if image file is a actual image or fake image
 if(isset($_POST["submitPic"])) {
		//$target_file = $pic_upload_dir_orig . basename($_FILES["fileToUpload"]["name"]);
		//kasutame classi
		
		$myPic = new Picupload($_FILES["fileToUpload"], $fileSizeLimit);
		if($myPic->error == null){
			//TEEME PILDI VÄIKSEMAKS---------------------------------------------------------
			$myPic->resizeImage($maxPicW, $maxPicH);//asub picupload.class.php
			//loome failinime
			$myPic->createFileName($fileNamePrefix);
			//lisame vesimärgi
			$myPic->addWatermark($waterMarkFile, $waterMarkLocation, $waterMarkFromEdge);
			//kirjutame vähendatud pildi faili
			$notice .= $myPic->savePicFile($pic_upload_dir_w600 .$filename);
			unset($myPic);
			//salvestan originaali
			$notice .= " " .$myPic->saveOriginal($pic_upload_dir_orig .$myPic->filename);		
			//salvestan info andmebaasi
			$notice .= addPicData($myPic->filename, test_input($_POST["altText"]), $_POST["privacy"]);
		} else {
			//1 - pole pildifail, 2 - liiga suur, 3 - pole lubatud tüüp
			if($myPic->error == 1){
			$notice = "Üleslaadimiseks valitud fail pole pilt!";
			}
			if($myPic->error == 2){
			$notice = "Üleslaadimiseks valitud fail on liiga suure mahuga (suurem kui 2.5Mb)";
			}
			if($myPic->error == 3){
			$notice = "Üleslaadimiseks valitud fail pole lubatud tüüpi (Ainult JPG, JPEG, PNG & GIF failid on lubatud!";
			}
			if($myPic->error == 4){
			$notice = "Fail juba eksisteerib";
			}
		}
			unset($myPic);
	}//submitpic end
?>
  <head>
  
  </head>
  <p>Veebileht on loodud õppetöö käigus, ei sisalda tõsiselt võetavat sisu.</p>
  <hr>
  
 <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
	  <label>Vali üleslaetav pildifail:</label><br>
	  <input type="file" name="fileToUpload" id="fileToUpload">
	  <br>
	  <label>Alt tekst (pildikirjeldus): </label><input type="text" name="altText">
	  <br>
	  <br>
	  <label>Privaatsuse valik</label>
	  <br>
	  <input type="radio" name="privacy" value="1"><label>Avalik</label>&nbsp;
	  <input type="radio" name="privacy" value="2"><label>Sisseloginud kasutajatele</label>&nbsp;
	  <input type="radio" name="privacy" value="3" checked><label>Isiklik</label>
      <br>
	  <input name="submitPic" type="submit" value="Lae pilt üles"><span><?php echo $notice; ?></span>
 </form>
 <hr>
  <br>
  <p> Mine tagasi <a href="home.php">avalehele</a></p>
  
</body>
</html>