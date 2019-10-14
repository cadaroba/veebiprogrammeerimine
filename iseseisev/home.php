
<style>
	body{background-color: #e8eaf9; 
	color: #000000} 
 </style>

<?php
  //Leht kui olen sisse loginud
  require("../../../config_vp2019.php");
  require("functions_user.php");
  $database = "if19_robin_ka_1";
  
  //kontrollime kas on sisse logitud, kui kasutaja üritab ilma kasutajata sisse logida siis viskab siia
  if(!isset($_SESSION["userId"])){
	  header("Location: page.php");
	  exit();
  }
  //Logime välja, $_GET - vaatab kas URL peal olev logout on saanud väärtuse..
  if(isset($_GET["logout"])){
	  session_destroy();
	  header("Location: page.php");
	  exit();
  }
  
  $userName = $_SESSION["userFirstname"] . " " .$_SESSION["userLastname"];
  
  require("header.php"); //nõuab tükki minu kasutast

  echo "<h1>" . $userName .", veebiprogrammeerimine</h1>";
?>

<!DOCTYPE html>
<head>
  
  </head>
<html>
    <meta charset="utf-8">
	<style>
	  <?php
        echo "body{background-color: " .$_SESSION["bgColor"] ."; \n";
		echo "color: " .$_SESSION["txtColor"] ."} \n";
	  ?>
	</style>
  
  <body>
  <div align ="center" > <?php    echo $_SESSION["description"] ?> </div>
  </body>
  <p>Veebileht on loodud õppetöö käigus, ei sisalda tõsiselt võetavat sisu.</p>
  <p>Kliki <a href="userprofile.php"> siia</a>, et muuta oma profiili.</p>
  <hr>
  <br>
  <p> Sisse logitud kasutajaga <?php echo $userName; ?> | Logi <a href="?logout=1"> välja</a>!</p>
  
</body>
</html>