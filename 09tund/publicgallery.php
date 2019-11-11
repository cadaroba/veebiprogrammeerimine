<?php
  //Leht kui olen sisse loginud
  require("functions_main.php");//test_inputi kontrollib piltide kirjeldust
  require("../../../config_vp2019.php");
  require("functions_user.php");
  require("functions_pic.php");
  require("classes/Picupload.class.php");
  require("header.php"); //nõuab tükki minu kasutast
  //require("classes/Test.class.php");
  $database = "if19_robin_ka_1";
  
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
  
  $userName = $_SESSION["userFirstname"] . " " .$_SESSION["userLastname"];
  
  
  $notice = null;
  
  // piirid galerii lehel naidava piiltide arvu jaoks
  $page = 1;
  $limit = 5;
  $totalPics = countPublicImages(2);
  
  if(!isset($_GET["page"]) or $_GET["page"] < 1){
	  $page = 1;	  
  } elseif(round($_GET["page"] - 1) * $limit > $totalPics){
	  $page = round($totalPics / $limit) - 1;
  } else {
	  $page = $_GET["page"];
  }
  $publicThumbsHTML = readAllPublicPicsPage(2, $page, $limit);
  require("header.php");
?>
  
  <head>
  </head>
  <body>
  <?php
    echo "<h1>" .$userName ." laeb pilte pildigaleriisse.</h1>";
  ?>
  
  <hr>
  <h2>Avalike piltide galerii</h2>
  <p>
  <!--<a href="?page=1"> Leht 1</a> | <a href="?page=2"> Leht 2</a>-->
  <?php
	if($page > 1){
		echo '<a href="?page=' .($page - 1) .'">Eelmine leht</a> | ';
	} else {
		echo "<span> Eelmine leht</span> | \n";
	}
	if($page * $limit < $totalPics){
		echo '<a href="?page=' .($page + 1) .'">Järgmine leht</a>  ';
	} else{
		echo "<span> Järgmine leht</span>  \n";
	}
	<p>Tagasi <a href="home.php">avalehele</a></p>
  ?>
  
  </p>
  
  <?php
	echo $publicThumbsHTML;
  ?>
  <hr>
</body>
</html>
?>