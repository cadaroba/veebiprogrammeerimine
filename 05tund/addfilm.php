<?php
  require("../../../config_vp2019.php"); //nõuab config.php minu kaustast
  require ("functions_film.php");
  //echo $serverHost;
  $userName = "Robin";
  $database = "if19_robin_ka_1";
  
  //Kui on nuppu vajutatud
	$pealkiriWarning = null;
	if(isset($_POST["submitFilm"])){
		//Salvestame kui on pealkiri
		if(!empty($_POST["filmTitle"])){
			saveFilmInfo($_POST["filmTitle"], $_POST["filmYear"], $_POST["filmDuration"], $_POST["filmGenre"], $_POST["filmCompany"], $_POST["filmDirector"]);
		} else {
			$pealkiriWarning = "Vähemalt pealkirja lahter peab olema täidetud!";
		}
	}
  
  }
  
  //var_dump($_POST;)
  if(isset($_POST["submitFilm"])){ //kui vajutatakse nuppu siis alles talletatakse
  storeFilmInfo($_POST["filmTitle"], $_POST["filmYear"], $_POST["filmDuration"], $_POST["filmGenre"], $_POST["filmStudio"], $_POST["filmDirector"]);
  //$filmInfoHTML = readAllFilms();
  
  
	
  require("header.php");
  echo "<h1>" . $userName ."</h1>";
?>
  <p>Veebileht on loodud õppetöö käigus, ei sisalda tõsiselt võetavat sisu!</p>
  <hr>
  <h2>Eesti filmid</h2>
  <p>Lisa uus film andmebaasi</p>
  <hr>
  <form method="POST">
    <label>Kirjuta filmi pealkiri: </label>
	<input type="text" name="filmTitle">
	<br>
	<label>Filmi tootmisaasta: </label>
	<input type="number" min="1912" max="2019" value="2019" name="filmYear">
	<br>
	<label>Filmi kestus: </label>
	<input type="number" min="1" max="300" value="80" name="filmDuration">
	<br>
	<label>Filmi žanr: </label>
	<input type="text" name="filmGenre">
	<br>
	<label>Filmi tootja: </label>
	<input type="text" name="filmStudio">
	<br>
	<label>Filmi lavastaja: </label>
	<input type="text" name="filmDirector">
	<br>
	<input type="submit" value="Talleta filmi info" name="submitFilm">
	<?php
	echo "<p" .$pealkiriWarning. "</p>"
	?>
  </form>
 
 
</body>
</html>