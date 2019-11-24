<?php
  //Leht kui olen sisse loginud
  require("../../../config_vp2019.php");
  require("functions_user.php");
  require("functions_main.php");
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
  
  $myDescription = showMyDesc();
	  
  $userName = $_SESSION["userFirstname"] . " " .$_SESSION["userLastname"];
  
  require("header.php"); //nõuab tükki minu kasutast

  echo "<h1>" . $userName .", veebiprogrammeerimine.</h1>";
  
?>
  <p>Veebileht on loodud õppetöö käigus, ei sisalda tõsiselt võetavat sisu.</p>
  <hr>
  <ul>
  <li>Minu <a href="messages.php"> sõnumid</a></li>
  <li>Minu <a href="movies.php"> filmid</a></li>
  <li>Muuda <a href="userprofile.php"> profiili</a></li>
  <li>Piltide <a href="picupload.php"> üleslaadimine</a></li>
  <li>Piltide <a href="gallery.php"> galerii</a></li>
  <li>Avalike piltide <a href="publicgallery.php"> galerii</a></li>
  <li>Privaatsete piltide <a href="privategallery.php"> galerii</a></li>
  </ul>
  <h2>Profiili kirjeldus</h2>
  
  <?php
	echo $myDescription
  ?>
  
  <hr>
  <br>
  <p>Sisse logitud kasutajaga <?php echo $userName; ?> | <a href="?logout=1">Logi välja</a></p>
  
</body>
</html>