<?php
  //Leht kui olen sisse loginud
  require("../../../config_vp2019.php");
  require("functions_user.php");
  require("functions_main.php");
  require("functions_news.php");
  $database = "if19_robin_ka_1";
  
  //sessioonihaldus
  require("classes/Session.class.php");
  SessionManager::sessionStart("vp", 0, "/~kadarob/", "greeny.cs.tlu.ee");
  
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
  
  //cookie ehk küpsis, kustutad - margiga // nimi, väärtus, aegumisaeg, path e. kataloogid, domeen, kas https, kas üle http e. üle veebi
  setcookie("vpusername", $_SESSION["userFirstname"] . " " .$_SESSION["userLastname"], time() + (86400 * 31), "/~kadarob/", "greeny.cs.tlu.ee", isset($_SERVER["HTTPS"]), true);
  //cookie küsimine, test
  if(isset($_COOKIE["vpusername"])){
	  echo "Leiti küpsis: " .$_COOKIE["vpusername"];
  } else {
	  echo "Küpsist ei leitud.";
  }
  //count($_COOKIE)
  
  $myDescription = showMyDesc(); 
  $userName = $_SESSION["userFirstname"] . " " .$_SESSION["userLastname"];
  $newsHTML = latestNews(5);
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
	  <li>Lisa <a href="addnews.php"> uudis</a></li>
  </ul>
  <hr>
  <?php
   echo $newsHTML;
  ?>
  <hr>
  <p>Sisse logitud kasutajaga <a href= "userprofile.php"> <?php echo $userName; ?></a> | <a href="?logout=1">Logi välja</a></p>
  
</body>
</html>