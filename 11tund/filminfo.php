<?php
  require("../../../config_vp2019.php"); //nõuab config.php minu kaustast
  require ("functions_film.php");
  //echo $serverHost;
  $userName = "Robin";
  $database = "if19_robin_ka_1";
	
  $filmInfoHTML = readAllFilms();
  $filmAge = 50;
  $oldFilmInfoHTML = readOldFilms($filmAge);
	
  require("header.php");
  echo "<h1>" . $userName .", veebiprogrammeerimine</h1>";
?>
  <p>Veebileht on loodud õppetöö käigus, ei sisalda tõsiselt võetavat sisu!</p>
  <hr>
  <h2>Eesti filmid</h2>
  <p>Praegu meie andmebaasis on järgmised filmid; </p>
  <?php
	echo $filmInfoHTML;
	echo "<hr>";
	echo "<h2>Filmid, mis on vanemad, kui " .$filmAge ." aastat.</h2>";
	echo $oldFilmInfoHTML;
  ?>
 
 
</body>
</html>