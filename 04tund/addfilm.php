<?php
  require("../../../config_vp2019.php"); //nõuab config.php minu kaustast
  require ("functions_film.php");
  //echo $serverHost;
  $userName = "Robin";
  $database = "if19_robin_ka_1";
  
  $filmTitle = null;
  $filmYear = date("Y");
  $filmDuration = 80;
  $filmGenre = null;
  $filmStudio = null;
  $filmDirector = null;
  
  $notice = null;
  
  //var_dump($_POST);
  //nupule vajutades juhtub järgmine
  if(isset($_POST["submitFilm"])){
	$filmTitle = $_POST["filmTitle"];
    $filmYear = $_POST["filmYear"];
    $filmDuration = $_POST["filmDuration"];
    $filmGenre = $_POST["filmGenre"];
    $filmStudio = $_POST["filmStudio"];
    $filmDirector = $_POST["filmDirector"];
	//salvestame, kui vähemalt pealkiri on olemas
	if(!empty($_POST["filmTitle"])){
	  //saveFilmInfo($_POST["filmTitle"], $_POST["filmYear"], $_POST["filmDuration"], $_POST["filmGenre"], $_POST["filmStudio"], $_POST["filmDirector"]);
	  storeFilmInfo($filmTitle, $filmYear, $filmDuration, $filmGenre, $filmStudio, $filmDirector);
	  $filmTitle = null;
      $filmYear = date("Y");
      $filmDuration = 80;
      $filmGenre = null;
      $filmStudio = null;
      $filmDirector = null;
	} else {
		$notice = "Palun sisestage vähemalt filmi pealkiri!";
	}
  }
  
  require("header.php");
  echo "<h1>" . $userName ."</h1>";
  
  
?>

<body>
  <p>Veebileht on loodud õppetöö käigus, ei sisalda tõsiselt võetavat sisu!</p>
  <hr>
  <h2>Eesti filmid</h2>
  <p>Lisa uus film andmebaasi</p>
  <hr>
  <form method="POST">
    <label>Kirjuta filmi pealkiri: </label>
	<input type="text" value="<?php echo $filmTitle; ?>" name="filmTitle">
	<br>
	<label>Filmi tootmisaasta: </label>
	<input type="number" min="1912" max="2019" value="<?php echo $filmYear; ?>" name="filmYear">
	<br>
	<label>Filmi kestus: </label>
	<input type="number" min="1" max="300" value="<?php echo $filmDuration; ?>" name="filmDuration">
	<br>
	<label>Filmi žanr: </label>
	<input type="text" value="<?php echo $filmGenre; ?>" name="filmGenre">
	<br>
	<label>Filmi tootja: </label>
	<input type="text" value="<?php echo $filmStudio; ?>" name="filmStudio">
	<br>
	<label>Filmi lavastaja: </label>
	<input type="text" value="<?php echo $filmDirector; ?>" name="filmDirector">
	<br>
	<input type="submit" value="Talleta filmi info" name="submitFilm">
  </form>
	
	<?php
	echo "<p" .$notice . "</p>"
	?>
  
 
 
</body>
</html>