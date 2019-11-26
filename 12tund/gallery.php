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
	  $page = ceil($picCount / $limit);
  } else {//kui kõik on legaalne ja töötab
	  $page = $_GET["page"];
  }
  $galleryHTML = readgalleryImages(2, $page, $limit);
  
  $toScript = "\t" .'<link rel="stylesheet" type="text/css" href="style/modal.css">' ."\n";
  $toScript .= "\t" .'<script type="text/javascript" src="javascript/modal.js" defer></script>' ."\n";
  
  
  require("header.php"); //nõuab tükki minu kasutast
  ?>
  
  
  <?php
    echo "<h1>" .$userName ." laeb pilte pildigaleriisse.</h1>";
  ?>
  
  <hr>
  <h2>Pildigalerii</h2>
  <!--Teeme piltide jaoks modaalakna W3Schools eeskujul-->
  <div id="myModal" class="modal">
	  <!--Sulgemisnupp-->
	  <span id="close" class="close">&times;</span>
	  <!--pildikoht-->
	  <img id="modalImg" class="modal-content" alt="galeriipilt">
	  <div id="caption" class="caption"></div>
	  <div id="rating" class="modalcaption">
	       <label><input id="rate1" name="rating" type="radio" value="1">1</label>
		   <label><input id="rate2" name="rating" type="radio" value="2">2</label>
		   <label><input id="rate3" name="rating" type="radio" value="3">3</label>
		   <label><input id="rate4" name="rating" type="radio" value="4">4</label>
		   <label><input id="rate5" name="rating" type="radio" value="5">5</label>
		   <input type="button" value="Salvesta hinnang" id="storeRating">
		   <br>
		   <span id="avgRating"></span>
	</div>
  </div>

  
<p>
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
  <br></br>
  <hr>
  <p>Tagasi <a href="home.php"> avalehele</a> | <a href="?logout=1">Logi välja</a></p>

</body>
</html>
  
  
  
  