<?php
  require("functions_pic.php");
  require("functions_main.php");
  require("../../../config_vp2019.php");
  require("functions_user.php");
  $database = "if19_robin_ka_1";
  
  require("classes/Session.class.php");
  SessionManager::sessionStart("vp", 0, "/~kadarob/", "greeny.cs.tlu.ee");
  
  //kui pole sisse loginud
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
  
  $page = 1;
  $total = totalPrivateImages(3);
  $limit = 5;
  $picCount = countPics(2);
  
  if(!isset($_GET["page"]) or $_GET["page"] < 1){
	  $page = 1;
  } elseif (round(($_GET["page"] - 1) * $limit) > $total){
	  $page = round($total / $limit) -1;
  } else {
	  $page = $_GET["page"];
  }
  
  $galleryHTML = allPrivatePictureThumbsPage(3, $page, $limit);
  //lehe päise laadimine
  $pageTitle = "Privaatsed pildid";
  require("header.php");
?>


<?php
    echo "<h1>" .$userName ." laeb privaatseid pilte galeriisse.</h1>";
?>

  <hr>
  <h2>Privaatne pildigalerii</h2>

<?php
	if($page > 1){
		echo '<a href="?page=' .($page - 1) .'">Eelmine leht</a> | ';
	} else {
		echo "<span> Eelmine leht </span> | \n";
	}
	if($page * $limit <= $picCount){
		echo '<a href="?page=' .($page + 1) .'">Järgmine leht</a>';
	} else {
		echo "<span> Järgmine leht</span>  \n";
	}
?>
    <!--<p><a href="?page=1"> Leht 1</a> | <a href="?page=2"> Leht 2</a></p>-->
  </p>
  <div id="gallery">
    <?php
	echo $galleryHTML;
	?>
  </div>
  
  <hr>
  <p>Tagasi <a href="home.php"> avalehele</a> | <a href="?logout=1">Logi välja</a></p>

</body>
</html>