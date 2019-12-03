<?php
  //Leht kui olen sisse loginud
  require("../../../config_vp2019.php");
  require("functions_user.php");
  //require("functions_main.php"); pole vaja peale Session.class.php
  $database = "if19_robin_ka_1";
  
  //sessioonihaldus
  require("classes/Session.class.php");
  SessionManager::sessionStart("vp", 0, "/~kadarob/", "greeny.cs.tlu.ee");
  
  //kontrollime kas on sisse logitud, kui kasutaja üritab ilma kasutajata sisse logida siis viskab siia
  if(!isset($_SESSION["userId"])){
	  header("Location: page.php");
	  exit();
  }
  //Logime välja, $_GET - vaatab kas URL peal olev logout on saanud väärtuse..
  if(isset($_GET["logout"])){
	  session_destroy();
	  header("Location: page.php");
	  exit();
  }
  $userName = $_SESSION["userFirstname"] ." " .$_SESSION["userLastname"];
  
  $toScript = "\t" .'<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>' ."\n";
  $toScript .= "\t" .'<script>tinymce.init({selector:"textarea#newsEditor", plugins: "link", menubar: "edit",});</script>' ."\n";
  
  require ("header.php");
  
  $notice = null;
  $error = "";
  $newsTitle = "";
  $news = "";
  $expiredate = date("Y-m-d");
  
  //kas vajutatakse uudiste salvestamise nuppu
  if(isset($_POST["newsBtn"]));{
    //var_dump($_POST);
	if(strlen($_POST["newsTitle"]) == 0) {
		$error .= "Sisesta uudise pealkiri.";
	}
	if(strlen($_POST["newsEditor"]) == 0){
		$error .= "Sisesta uudise kirjelus.";
	}
	if($_POST["expiredate"] >= $expiredate){
		$_POST["expiredate"] = $expiredate;
	}
	$newsTitle = test_input($_POST["newsTitle"]);
	$news = test_input($_POST["newsEditor"]);
	
	if($error == ""){
		/*$notice = "Uudis salvestatud!";
		$error = $notice;
		echo $_POST["expiredate"];*/
		$result = saveNews($newsTitle, $news, $expiredate);
		if($result == 1){
			$notice = "Uudis salvestatud!";
			$error = "";
			$newsTitle = "";
			$news = "";
			$expiredate = date("Y-m-d");
		}
	}
} 
?>

<?php
    echo "<h1>" .$userName ." kirjutab uudiseid.</h1>";
  ?>

<body>
<hr>
<h2>Lisa uudis</h2>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
		<label>Uudise pealkiri:</label><br><input type="text" name="newsTitle" id="newsTitle" style="width: 100%;" value="<?php echo $newsTitle; ?>"><br>
		<label>Uudise sisu:</label><br>
		<textarea name="newsEditor" id="newsEditor"><?php echo $news; ?></textarea>
		<br>
		<label>Uudis nähtav kuni (kaasaarvatud)</label>
		<input type="date" name="expiredate" required pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" value="<?php echo $expiredate; ?>">
		
		<input name="newsBtn" id="newsBtn" type="submit" value="Salvesta uudis"> <span>&nbsp;</span><span><?php echo $error; ?></span>
	</form>
	<hr>
	<p>Tagasi <a href="home.php"> avalehele</a> | <a href="?logout=1">Logi välja</a></p>
	
</body>
</html>
	
//Kui lasete uudise läbi test_input funktsiooni, siis html "<" ja ">" muudetakse koodideks. Uudise näitamisel siis tuleb need tagasi muuta ja selleks on vaja andmetabelist loetud uudis lasta läbi php funktsiooni htmlspecialchars_decode()