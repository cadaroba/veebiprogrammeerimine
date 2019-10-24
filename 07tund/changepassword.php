<?php
  require("functions_main.php");
  require("../../../config_vp2019.php");
  require("functions_user.php");
  $database = "if19_robin_ka_1";
  $userName = $_SESSION["userFirstname"] . " " .$_SESSION["userLastname"];
  require("header.php");
 
  
  //kontrollime kas on sisse logitud, kui kasutaja üritab ilma kasutajata sisse logida siis viskab siia
  if(!isset($_SESSION["userId"])){
	  header("Location: page.php");
	  exit();
  }
 
  
  if (!isset($_POST["submit"])){
	  $oldPassword = $_POST["oldPassword"];
      $newPassword = $_POST["newPassword"];
	  $confirmPassword = $_POST["confirmPassword"];
      }
	
?>
 
<!DOCTYPE html>
<html lang="et">
  <head>
    <meta charset="utf-8">
		<h1>Siin muudate kasutaja <?php echo $userName ?> parooli </h1>
  </head>
  
   <form method="POST">
   <label>Vana salasõna:</label><br>
   <input name="oldPassword" type="password"><br>
   <label>Uus salasõna:</label><br>
   <input name="newPassword" type="password"><br>
   <label>Korda salasõna:</label><br>
   <input name="confirmPassword" type="password"><br>
   <input name="changePassword" type="submit" value="Vaheta parool"><br>
   </form>
  </html>