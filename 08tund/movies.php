<?php
  require("../../../config_vp2019.php");
  require("functions_main.php"); 
  require("functions_user.php"); 
  require("functions_message.php"); 
  require("functions_film.php");
  $database = "if19_robin_ka_1";

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
  
  $userName = $_SESSION["userFirstname"] ." " .$_SESSION["userLastname"];
  
  $notice = null;
  $messagesHTML = null;


  
  if(isset($_POST["submitMessage"])){
    if(isset($_POST["message"]) and !empty($_POST["message"])) {
      $notice = storeMessage(test_input($_POST["message"]));
    }
  }
  //
  //$messagesHTML = readAllMessages();
  //$messagesHTML = readMyMessages();
    $moviesHTML = readMyMovies();
  require("header.php");

  $title = $filmDescription = $company = $maker = $pealkiri = "";
  $year = '2019';
  $time = '80';
  //var_dump($_POST);
  //kui on nuppu vajutatud
  if(isset($_POST["submitFilm"])) {
  //salvestame, kui vähemalt pealkiri on olemas
    
    if(!empty($_POST["filmTitle"])){  
      storeFilmInfo($_POST["filmTitle"],$_POST["filmYear"], $_POST["filmDuration"], $_POST["filmDescription"]);
    }
    else {
      
      $year = $_POST["filmYear"];
      $time = $_POST["filmDuration"];
      $filmDescription = $_POST["filmDescription"];

      $pealkiri = '<h2 style="color:red;">Palun sisesta pealkiri!</h2>';
    }

  }


?>


<body>
  <?php
    echo "<h1>" .$userName ." koolitöö leht.</h1>";
  ?>
  <p>See leht on loodud koolis õppetöö raames
  ja ei sisalda tõsiseltvõetavat sisu!</p>
  <hr>
  
  <form method="POST">
  <label>Sisesta pealkiri: </label><input type="text" name="filmTitle" value="<?php echo $title?>">
  <br>
  <label>Filmi tootmisaasta: </label><input type="number" min="1912" max="2019"
  value="<?php echo $year?>" name="filmYear">
  <br>
  <label>Filmi kestus (min): </label><input type="number" min="1" max="300" value="<?php echo $time?>" name="filmDuration">
  <br>
  <label>Filmi Lühikirjeldus: </label><input type="text" name="filmDescription" value="<?php echo $filmDescription?>">
  <br>
  <input type="submit" value="Salvesta film" name="submitFilm">
  <p>Tagasi <a href="home.php">avalehele</a></p>
  <br>


  </form>

  <hr>
  <h2>Filmide info</h2>
  <?php 
    echo $moviesHTML;
  ?>
  
</body>
</html>