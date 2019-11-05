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
		//$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		$imageFileType = strtolower(pathinfo($_FILES["fileToUpload"]["name"],PATHINFO_EXTENSION));
		
		//pilt saab uue nime
		$filename = "vp_";
		$timeStamp = microtime(1) * 10000;
		$filename .= $timeStamp ."." .$imageFileType;
		$target_file = $pic_upload_dir_orig . $filename;
		
		$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		if($check !== false) {
			echo "Fail on pilt - " . $check["mime"] . ". ";
			$uploadOk = 1;
		} else {
			echo "Fail ei ole pilt. ";
			$uploadOk = 0;
		}
	
		// Check if file already exists
		if (file_exists($target_file)) {
			echo "Fail on juba olemas! ";
			$uploadOk = 0;
		}
		// Check file size
		if ($_FILES["fileToUpload"]["size"] > 2500000) {//2500000->~2.5MB 
			echo "Fail on liiga suur!";
			$uploadOk = 0;
		}
		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
			echo "Ainult JPG, JPEG, PNG & GIF failid on lubatud! ";
			$uploadOk = 0;
		}
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
			echo "Faili ei laetud üles..";
		// if everything is ok, try to upload file
		} else {
			
			//kasutame classi
			$myPic = new Picupload($_FILES["fileToUpload"]["tmp_name"], $imageFileType);
			//TEEME PILDI VÄIKSEMAKS---------------------------------------------------------
			$myPic->resizeImage($maxPicW, $maxPicH);//asub picupload.class.php
			//lisame vesimärgi
			$myPic->addWatermark("../vp_pics/vp_logo_w100_overlay.png");
			//kirjutame vähendatud pildi faili
			$notice .= $myPic->savePicFile($pic_upload_dir_w600 .$filename);
			unset($myPic);
				
			if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
				echo "The file ". basename($_FILES["fileToUpload"]["name"]). " on üles laetud";
			} else {
				echo "Tekkis viga faili üleslaadimisel.";
			}
			//salvestan info andmebaasi
			$notice .= addPicData($filename, test_input($_POST["altText"]), $_POST["privacy"]);
		}
	}//submitpic end
			
  
  //----------------------------------------------------------------------------------------------------
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