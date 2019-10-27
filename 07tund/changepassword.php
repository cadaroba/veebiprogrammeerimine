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
  
  $notice = "";
  $oldPassword = "";
  $newPassword = "";
  $confirmPassword = "";
  $oldPasswordError = null;
  $newPasswordError = null;
  $confirmPasswordError = null;
 
  
  if (isset($_POST["submitpasswordChange"])){
	  if (!empty($_POST["oldPassword"]) and (isset($_POST["oldPassword"]) == $_SESSION["oldPassword"])){
		$oldPassword = $_POST["oldPassword"];
		} else {
		$oldPasswordError = " Parool ei klapi vana parooliga";
	  }
	  if (!empty($_POST["newPassword"]) and (isset($_POST["newPassword"]))){
		$newPassword = $_POST["newPassword"];
		} else {
		$newPasswordError = " Sisesta uus parool";
	  }
	  if (!empty($_POST["confirmPassword"]) and (isset($_POST["confirmPassword"]) == (isset($_POST["newPassword"])))){
		$confirmPassword = $_POST["confirmPassword"];
		} else {
		$confirmPasswordError = " Uus parool ei ole identne";
	  }
	  if(empty($oldPasswordError) and empty($newPasswordError) and empty($confirmPasswordError)){
	  $notice = changePassword($oldPassword, $newPassword);
	  echo $notice;
	  }
  }

?>
 
<!DOCTYPE html>
<html lang="et">
  <head>
    <meta charset="utf-8">
		<h1>Siin muudate kasutaja <?php echo $userName ?> parooli </h1>
  </head>
  
   <form method = "POST" action = '<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>'>
		<label>Vana salasõna:</label><br>
		<input name = "oldPassword" type = "text" value = "<?php echo $oldPassword;?>"><?php echo $oldPasswordError;?><br>
		<label>Uus salasõna:</label><br>
		<input name = "newPassword" type = "text" value = "<?php echo $newPassword;?>"><span><?php echo $newPasswordError; ?></span><br>
		<label>Korda salasõna:</label><br>
		<input name = "confirmPassword" type = "password"><span><?php echo $confirmPasswordError; ?></span><br>
		<input name = "submitpasswordChange" type = "submit" value = "Vaheta parool"><?php echo $notice; ?> <br>
   </form>
  </html>