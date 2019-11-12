<?php
  //Leht kui olen sisse loginud
  require("functions_main.php");//test_inputi kontrollib piltide kirjeldust
  require("../../../config_vp2019.php");
  require("functions_user.php");
  require("functions_pic.php");
 
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
  
  //piirid galerii lehel naidava piiltide arvu jaoks
  $page = 1;
  $limit = 5;
  $picCount = countPics(2);
  
  if(!isset($_GET["page"]) or $_GET["page"] < 1){
	  $page = 1;	  
  } elseif(round($_GET["page"] - 1) * $limit >= $picCount){
	  $page = round($picCount / $limit) - 1;
  } else {//kui kõik on legaalne ja töötab
	  $page = $_GET["page"];
  }
  $galleryHTML = readgalleryImages(2, $page, $limit);
  
  require("header.php"); //nõuab tükki minu kasutast
  ?>
  
  <head>
  </head>
  <body>
  
  <?php
    echo "<h1>" .$userName ." laeb pilte pildigaleriisse.</h1>";
  ?>
  
  <hr>
  <h2>Pildigalerii</h2>
  
  <!--<p><a href="?page=1"> Leht 1</a> | <a href="?page=2"> Leht 2</a></p>-->
  
  <?php
	if($page > 1){
		echo '<a href="?page=' .($page - 1) .'">Eelmine leht</a> | ';
	} else {
		echo "<span> Eelmine leht </span> | \n";
	}
	if($page * $limit < $picCount){
		echo '<a href="?page=' .($page + 1) .'">Järgmine leht</a>  ';
	} else {
		echo "<span> Järgmine leht</span>  \n";
	}
	
	echo $galleryHTML;
  ?>
  
  <hr>
</body>
<p>Tagasi <a href="home.php">avalehele</a></p>
</html>