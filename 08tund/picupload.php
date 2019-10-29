<?php
  //Leht kui olen sisse loginud
  require("functions_main.php");//test_inputi kontrollib piltide kirjeldust
  require("../../../config_vp2019.php");
  require("functions_user.php");
  require("functions_pic.php");
  $database = "if19_robin_ka_1";
  
  //kontrollime kas on sisse logitud, kui kasutaja üritab ilma kasutajata sisse logida siis viskab siia
  if(!isset($_SESSION["userId"])){
	  header("Location: page.php");
	  exit();
  }
  
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
			
			//TEEME PILDI VÄIKSEMAKS---------------------------------------------------------
				//loeme pildifaili sisu pikslikogumiks
				if($imageFileType == "jpg" or $imageFileType == "jpeg"){
					$myTempImage = imagecreatefromjpeg($_FILES["fileToUpload"]["tmp_name"]);
				}
				
				if($imageFileType == "png"){
					$myTempImage = imagecreatefromjpeg($_FILES["fileToUpload"]["tmp_name"]);
				}
				
				if($imageFileType == "gif"){
					$myTempImage = imagecreatefromjpeg($_FILES["fileToUpload"]["tmp_name"]);
				}
				
				//kontroll kas pilt vajab resolutsiooni muutust
				$imageW = imagesx($myTempImage);
				$imageH = imagesy($myTempImage);
				if($imageW > $maxPicW or $imageH > $maxPicH){
					if($imageW / $maxPicW > $imageH /$maxPicH){
						$picSizeRatio = $imageW / $maxPicW;
					} else {
						$picSizeRatio = $imageH / $maxPicH;
					}
					$imageNewW = round($imageW / $picSizeRatio, 0);
					$imageNewH = round($imageH / $picSizeRatio, 0);
					$myNewImage = setPicSize($myTempImage, $imageW, $imageH, $imageNewW, $imageNewH);
					
					//kirjutame vähendatud pildi faili
					if($imageFileType == "jpg" or $imageFileType == "jpeg"){
						if(imagejpeg($myNewImage, $pic_upload_dir_w600 .$filename, 90)){
							$notice = "Vähendatud faili salvestamine õnnestus.";
						} else {
							$notice = "Vähendatud faili salvestamine ei õnnestunud.";
						}
					}
					
					if($imageFileType == "png"){
						if(imagepng($myNewImage, $pic_upload_dir_w600 .$filename, 6)){
							$notice = "Vähendatud faili salvestamine õnnestus.";
						} else {
							$notice = "Vähendatud faili salvestamine ei õnnestunud.";
						}
					}
					
					if($imageFileType == "gif"){
						if(imagepng($myNewImage, $pic_upload_dir_w600 .$filename)){
							$notice = "Vähendatud faili salvestamine õnnestus.";
						} else {
							$notice = "Vähendatud faili salvestamine ei õnnestunud.";
						}
					}
					
					imagedestroy($myTempImage);
					imagedestroy($myNewImage);
				}//kas on liiga suur pilt
			
			if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
				echo "The file ". basename($_FILES["fileToUpload"]["name"]). " on üles laetud";
			} else {
				
				
				
				echo "Tekkis viga faili üleslaadimisel.";
			}
		}
	}

  
  
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
	  <input name="submitPic" type="submit" value="Lae pilt üles"><span><?php echo $notice; ?></span>
 </form>
 <hr>
  <br>
  <p> Mine tagasi <a href="home.php">avalehele</a></p>
  
</body>
</html>