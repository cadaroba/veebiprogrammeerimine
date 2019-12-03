<?php
  //Leht kui olen sisse loginud
  require("functions_main.php");
  require("../../../config_vp2019.php");
  require("functions_user.php");
  $database = "if19_robin_ka_1";
  
  require("classes/Session.class.php");
  SessionManager::sessionStart("vp", 0, "/~kadarob/", "greeny.cs.tlu.ee");
  
  //kontrollime kas on sisse logitud, kui kasutaja üritab ilma kasutajata sisse logida siis viskab siia
  if(!isset($_SESSION["userId"])){
	  header("Location: page.php");
	  exit();
  }
  
  //väljalogimine
  if(isset($_GET["logout"])){
	  session_destroy();
	  header("Location: page.php");
	  exit();
  }
  
  $notice = null;
  $myDescription = null;
 
 

 if(isset($_POST["submitProfile"])){
	$notice = saveProfile($_POST["description"], $_POST["bgcolor"], $_POST["txtcolor"]);
	if(!empty($_POST["description"])){
	  $myDescription = $_POST["description"];
	}
	$_SESSION["bgColor"] = $_POST["bgcolor"];
	$_SESSION["txtColor"] = $_POST["txtcolor"];
  } else {
	$myProfileDesc = showMyDesc();
	if($myProfileDesc != ""){
	  $myDescription = $myProfileDesc;
    }
  }
  
  
  $userName = $_SESSION["userFirstname"] . " " .$_SESSION["userLastname"];
  
  require("header.php"); //nõuab tükki minu kasutast

  
?>
<head>
  <h1> <?php echo $userName ?>, muudab profiili.</h1>
  </head>

<body>
  
  <p>Veebileht on loodud õppetöö käigus, ei sisalda tõsiselt võetavat sisu.</p>
  <hr>
  
 <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	  <label>Minu kirjeldus</label><br>
	  <textarea rows="10" cols="80" name="description" placeholder="Lisage siia tutvustus..."><?php echo $myDescription; ?></textarea>
	  <br>
	  <label>Minu valitud taustavärv: </label><input name="bgcolor" type="color" value="<?php echo $_SESSION["bgColor"]; ?>"><br>
	  <label>Minu valitud tekstivärv: </label><input name="txtcolor" type="color" value="<?php echo $_SESSION["txtColor"]; ?>"><br>
	  <input name="submitProfile" type="submit" value="Salvesta profiil"><span><?php echo $notice; ?></span>
 </form>
 
   <h2>Profiili kirjeldus</h2>
  
  <?php
	echo $myDescription
  ?>
  <br>
  <hr>
  <p>Muuda <a href="changepassword.php"> parooli</a></p>
  <p>Tagasi <a href="home.php"> avalehele</a> | <a href="?logout=1">Logi välja</a></p>
  
</body>
</html>