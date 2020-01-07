<?php
  require("../../../config_vp2019.php");
  require("functions_main.php"); 
  require("functions_user.php"); 
  require("functions_message.php"); 
  require("functions_film.php");
  $database = "if19_robin_ka_1";
  
  require("classes/Session.class.php");
  SessionManager::sessionStart("vp", 0, "/~kadarob/", "greeny.cs.tlu.ee");

  //kui pole sisseloginud
  if(!isset($_SESSION["userId"])){
    //siis jõuga sisselogimise lehele
    header("Location: page.php");
    exit();
  }
  
  //väljalogimine
  if(isset($_GET["logout"])){
    session_destroy();
    header("Location: page.php");
    exit();
  }
  
  $filmTitle = null;
  $filmYear = date("Y");
  $filmDuration = 80;
  $filmGenre = null;
  $filmStudio = null;
  $filmDirector = null;
  
  $notice = "";
  
  $userName = $_SESSION["userFirstname"] ." " .$_SESSION["userLastname"];

  if(isset($_POST["submitFilm"])){
    if(isset($_POST["film"]) and !empty($_POST["film"])) {
      $notice = storeFilmInfo(test_input($_POST["film"]));
    }
  }
  //
  //$messagesHTML = readAllMessages();
  //$messagesHTML = readMyMessages();
    $allFilmsHTML = readAllFilms();
  require("header.php");

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


?>


<body>
  <?php
    echo "<h1>" .$userName ." koolitöö leht.</h1>";
  ?>
  <p>See leht on loodud koolis õppetöö raames
  ja ei sisalda tõsiseltvõetavat sisu!</p>
  <p><?php echo $notice ?></p> 
  <hr>
  
  <form method="POST">
	  <label>Sisesta pealkiri: </label>
	  <input type="text" name="filmTitle" value="<?php echo $filmTitle?>">
	  <br>
	  <label>Filmi tootmisaasta: </label>
	  <input type="number" min="1912" max="2019" value="<?php echo $filmYear?>" name="filmYear">
	  <br>
	  <label>Filmi kestus: </label>
	  <input type="number" min="1" max="300" value="<?php echo $filmDuration?>" name="filmDuration">
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
	  <label>Filmi lühikirjeldus:</label>
	  <br> <textarea rows="5" cols="50" name="film" placeholder="Lisa siia filmi lühikirjeldus ..."></textarea>
	  <br>
	  <input type="submit" value="Salvesta film" name="submitFilm">
	  <p>Tagasi <a href="home.php">avalehele</a></p>
	  <br>
  </form>

  <hr>
  <h2>Andmebaasis olevad filmid</h2>
  <?php 
    echo $allFilmsHTML;
  ?>
 
</body>
</html>