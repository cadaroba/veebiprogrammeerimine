<?php
  $userName = "Robin";
  
  $photoDir = "../photos/";
  $photoTypes = ["image/jpeg", "image/png"];
  
  $fullTimeNow = date("d.m.Y H:i:s"); #muutuja on $
  $hourNow = date ("H");
  $partOfDay = "hägune aeg";
  
  require("../../../config_vp2019.php");
  require("functions_main.php");
  require("functions_user.php");
  $database = "if19_robin_ka_1";
  $userName = "Sisselogimata kasutaja";
  
  $notice = "";
  $email = "";
  $emailError = "";
  $passwordError = "";
  
  $photoDir = "../photos/";
  $photoTypes = ["image/jpeg", "image/png"];
  
  $weekdayNamesET = ["esmaspäev", "teisipäev", "kolmapäev", "neljapäev", "reede", "laupäev", "pühapäev"];
  $monthNamesET = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];
  $weekdayNow = date("N");
  $dateNow = date("d");
  $monthNow = date("m");
  $yearNow = date("Y");
  $timeNow = date("H:i:s");
  $fullTimeNow = date("d.m.Y H:i:s");
  $hourNow = date("H");
  $partOfDay = "hägune aeg";
  
  if($hourNow < 8){
	$partOfDay = "hommik";
  }
  if($hourNow >= 8 and $hourNow < 16){
		$partOfDay = "Sobiv aeg akadeemiliseks aktiivsuseks.";
	}
	if($hourNow >= 16 and $hourNow < 22){
		$partOfDay = "Vaba aeg.";
	}
	if($hourNow > 22){
		$partOfDay = "Uneaeg.";
	}
	  //info semestri kulgemise kohta
	  $semesterStart = new DateTime("2019-9-2");
	  $semesterEnd = new DateTime("2019-12-13");
	  $semesterDuration = $semesterStart -> diff($semesterEnd);
	  $Today = new DateTime ("now");
	  $semesterElapsed = $semesterStart -> diff($Today);
	  //echo $SemesterDuration;
	  //var_dump ($semesterDuration;
	  //<p>Semester on täies hoos:
	  //<meter min="0" max = "112" value "16">13%</meter>
	  //</p>
	  $semesterInfoHTML = null;
	  if ($semesterElapsed -> format ("%r%a") >= 0){
		  $semesterInfoHTML = "<p>Semester on täies hoos:";
		  $semesterInfoHTML .= '<meter min="0" max="' .$semesterDuration -> format ("%r%a") .'" ';
		  $semesterInfoHTML .= 'value="' .$semesterElapsed -> format("%r%a") . '">';
		  $semesterInfoHTML .= round($semesterElapsed -> format ("%r%a") / $semesterDuration -> format("%r%a") * 100, 1) ."%";
		  $semesterInfoHTML .= "</meter> </p>";
	  }
	  
	  //foto näitamine lehel //scandir - loeb kataloogi sisu //var_dump - kontrollimiseks //array_slice - lõikab välja 2 kausta // foreach - kontrollib jpg faile //array_push - pane massiivi
	  $fileList = array_slice(scandir($photoDir), 2);
	  //var_dump ($fileList); 
	
	  $photoList = [];
	  foreach ($fileList as $file){
		  $fileInfo = getImagesize($photoDir .$file);
		  //var_dump ($fileInfo);
		  if (in_array($fileInfo["mime"], $photoTypes)){
			  array_push($photoList, $file);
			  
		  }
	  }
	  
	  //$photoList = ["tlu_terra_600x400_1.jpg", "tlu_terra_600x400_2.jpg", "tlu_terra_600x400_3.jpg"];//array ehk massiiv
	  //var_dump($photoList);
	  $photoCount = count($photoList);
	  //echo $photoCount; //mt_rand on kiirem ja juhuslikum
	  $photoNum = mt_rand(0, $photoCount -1);
	  //echo $photoList[$photoNum];
	  //<img src="../photos/tlu_terra_600x400_1.jpg" alt="TLÜ Terra õppehoone">
	  $randomImgHTML = '<img src="' .$photoDir .$photoList[$photoNum] .'" alt="Juhuslik foto">';
	  
	  //sisselogimine
	  if(isset($_POST["login"])){
		if (isset($_POST["email"]) and !empty($_POST["email"])){
		  $email = test_input($_POST["email"]);
		} else {
		  $emailError = "Palun sisesta kasutajatunnusena e-posti aadress!";
		}
	  
		if (!isset($_POST["password"]) or strlen($_POST["password"]) < 8){
		  $passwordError = "Palun sisesta parool, vähemalt 8 märki!";
		}
	  
		if(empty($emailError) and empty($passwordError)){
		   $notice = signIn($email, $_POST["password"]);
		} else {
			$notice = "Ei saa sisse logida!";
		}
	  }
?>

<!DOCTYPE html>
<html lang="et">
  <head>
    <meta charset="utf-8">
		<title>Veebiprogrammeerimine, 2019, Robin</title>
  </head>
  <body>
    <h1>Veebiprogrammeerimine</h1>
	
  <p>Veebileht on loodud õppetöö käigus, ei sisalda tõsiselt võetavat sisu!</p>
  <?php
	echo $semesterInfoHTML;
	?>
  <hr>
  <?php
    echo "<p>Lehe avamise hetkel oli aeg: " .$fullTimeNow .", ".$partOfDay.".</p>";
	 //kodus jalus ja html teha php, indikaator kaotada kui semester läbi, fotodega see et kui pilte pole siis ütleb et fotosid pole
	 
  ?>
	 <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	  <label>E-mail (kasutajatunnus):</label><br>
	  <input type="email" name="email" value="<?php echo $email; ?>">&nbsp;<span><?php echo $emailError; ?></span><br>
	  
	  <label>Salasõna:</label><br>
	  <input name="password" type="password">&nbsp;<span><?php echo $passwordError; ?></span><br>
	  
	  <input name="login" type="submit" value="Logi sisse">&nbsp;<span><?php echo $notice; ?>
	</form>
	<br>
	<h2>Kui pole kasutajakontot</h2>
	<p>Loo <a href="newuser.php"> kasutajakonto</a>!</p>
  
  <?php
	echo $randomImgHTML;
  ?>
 
 
</body>
</html>