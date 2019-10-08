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
  <p>Veebileht on loodud õppetöö käigus, ei sisalda tõsiselt võetavat sisu.</p>
 
  <hr>
  <br>
  <p> Sisse logitud kasutajaga <?php echo $userName; ?> | Logi <a href="?logout=1"> välja</a>!</p>
  
</body>
</html>