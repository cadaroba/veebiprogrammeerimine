<?php
  //Leht kui olen sisse loginud
  require("functions_main.php");
  require("../../../config_vp2019.php");
  require("functions_user.php");
  require("functions_message.php");
  $database = "if19_robin_ka_1";
  
  //kontrollime kas on sisse logitud, kui kasutaja üritab ilma kasutajata sisse logida siis viskab siia
  if(!isset($_SESSION["userId"])){
	  header("Location: page.php");
	  exit();
  }
  
  $notice = null;
  $myMessage = null;
  
  if(isset($_POST["submitMessage"])){
	  $myMessage = test_input($_POST["message"]);
	  if(!empty($myMessage)){
		  $notice = storeMessage($myMessage);
	  } else {
		  $notice = "tühja sõnumit ei salvestata!";
	  }
  }
  
  //$messagesHTML = readAllMessages();
  $messagesHTML = readMyMessages();
  
  
  $userName = $_SESSION["userFirstname"] . " " .$_SESSION["userLastname"];
  
  require("header.php"); //nõuab tükki minu kasutast

  echo "<h1>" . $userName .", sisestab sõnumit</h1>";
?>
  <head>
  
  </head>
  <p>Veebileht on loodud õppetöö käigus, ei sisalda tõsiselt võetavat sisu.</p>
  <hr>
  
 <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	  <label>Minu sõnum (256 märki)</label><br>
	  <textarea rows="5" cols="50" name="message" placeholder="Kirjuta siia oma sõnum..."></textarea>
	  <br>
	  <input name="submitMessage" type="submit" value="Salvesta sõnum"><span><?php echo $notice; ?></span>
 </form>
 <hr>
 <h2>Senised sõnumid</h2>
 
 <?php
	echo $messagesHTML;
 ?>

  <br>
  <p> Mine tagasi <a href="home.php">avalehele</a></p>
  
</body>
</html>