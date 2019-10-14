<?php
  //Leht kui olen sisse loginud
  require("functions_main.php");
  require("../../../config_vp2019.php");
  require("functions_user.php");
  $database = "if19_robin_ka_1";
  
  //kontrollime kas on sisse logitud, kui kasutaja üritab ilma kasutajata sisse logida siis viskab siia
  if(!isset($_SESSION["userId"])){
	  header("Location: page.php");
	  exit();
  }
  
  $notice = "";
  $mydescription = "";
  $mybgcolor = "#FFFFFF";
  $mytxtcolor = "#000000";
  $mydescriptionError = null;
  $mybgcolorError = null;
  $mytxtcolorError = null;
  $idFromDb = $_SESSION["userId"];
  
  if(isset($_POST["submitProfile"])){
	  
	  if(isset($_POST["description"]) and !empty($_POST["description"])){
	    $mydescription = ($_POST["description"]);
	  } else {
		$mydescriptionError = "Palun sisesta enda kirjeldus!";
	  }
	  
	  if(isset($_POST["bgcolor"]) and !empty($_POST["bgcolor"])){
	  $mybgcolor = ($_POST["bgcolor"]);
	  } else {
		  $mybgcolorError =" Palun vali värv!";
	  }
	  
	  if(isset($_POST["txtcolor"]) and !empty($_POST["txtcolor"])){
	  $mytxtcolor = ($_POST["txtcolor"]);
	  } else {
		  $mytxtcolorError = "Palun värvi texti värvus";
	  }
	  
      if(empty($mydescriptionError) and empty($mybgcolorError) and empty($mytxtcolorError)){
		  $notice = saveProfile($mydescription, $mybgcolor, $mytxtcolor);
		  
	  }
	  
  }

  
  
  $userName = $_SESSION["userFirstname"] . " " .$_SESSION["userLastname"];
  
  require("header.php"); //nõuab tükki minu kasutast

  echo "<h1>" . $userName .", muudab profiili välimust</h1>";
?>
  <head>
  
  </head>
  <p>Veebileht on loodud õppetöö käigus, ei sisalda tõsiselt võetavat sisu.</p>
  <hr>
  
 <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	  <label>Minu kirjeldus</label><br>
	  <textarea rows="10" cols="80" name="description"><?php echo $mydescription; ?></textarea> <br><span><?php echo $mydescriptionError; ?></span><br>
	  <label>Minu valitud taustavärv: </label><input name="bgcolor" type="color" value="<?php echo $mybgcolor; ?>"><br>
	  <label>Minu valitud tekstivärv: </label><input name="txtcolor" type="color" value="<?php echo $mytxtcolor; ?>"><br>
	  <input name="submitProfile" type="submit" value="Salvesta profiil"><span><?php echo $notice; ?></span>
 </form>

  <br>
  <p> Mine tagasi <a href="home.php">avalehele</a></p>
  
</body>
</html>