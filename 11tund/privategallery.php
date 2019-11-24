<?php
  require("functions_pic.php");
  require("functions_main.php");
  require("../../../config_vp2019.php");
  require("functions_user.php");
  $database = "if19_robin_ka_1";
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
  $page = 1;
  $total = totalPrivateImages(3);
  $limit = 5;
  if(!isset($_GET["page"]) or $_GET["page"] < 1){
	  $page = 1;
  } elseif (round(($_GET["page"] - 1) * $limit) > $total){
	  $page = round($total / $limit) -1;
  } else {
	  $page = $_GET["page"];
  }
    $thumbs = allPrivatePictureThumbsPage(3, $page, $limit);
  //lehe päise laadimine
  $pageTitle = "Privaatsed pildid";
  require("header.php");
?>


	<p>Privaatgalerii</p>
	<hr>
	<ul>
	  <li><a href="?logout=1">Logi välja</a></p></li>
	  <li><a href="home.php">Tagasi pealehele</a></li>
	</ul>
	<hr>
	<?php
		echo "<p>";
		if ($page > 1){
			echo '<a href="?page=' .($page - 1) .'">Eelmised pildid</a> ';
		} else {
			echo "<span>Eelmised pildid</span> ";
		}
		if ($page * $limit < $total){
			echo '| <a href="?page=' .($page + 1) .'">Järgmised pildid</a>';
		} else {
			echo "| <span>Järgmised pildid</span>";
		}
		echo "</p> \n";
		echo $thumbs;

    ?>
	
  </body>
</html>