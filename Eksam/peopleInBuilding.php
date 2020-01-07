<?php
  require("../../../config_vp2019.php");
  require("functions_main.php"); 
  require("functions_user.php"); 
  require("functions_peopleInBuilding.php");
  $database = "if19_robin_ka_1";
  
  require("classes/Session.class.php");
  SessionManager::sessionStart("vp", 0, "/~kadarob/", "greeny.cs.tlu.ee");

  //kui pole sisseloginud
  if(!isset($_SESSION["userId"])){
    //siis jõuga sisselogimise lehele
    header("Location: page.php");
    exit();
  }
  
  //väljalogimine
  if(isset($_GET["logout"])){
    session_destroy();
    header("Location: page.php");
    exit();
  }
  
	$peopleAmount = 0;
	$enterOrExit = null;
	$gender = null;
	$studentOrTeacher = null;
  
  $notice = "";
  
  $allPeopleInBuildingHTML = readAllPeopleInBuilding($peopleAmount);
  //$genderPeopleinBuildingHTML = readGenderPeopleInBuilding($gender);
  
  $userName = $_SESSION["userFirstname"] ." " .$_SESSION["userLastname"];

  if(isset($_POST["submitPeopleAmount"])){
    if(isset($_POST["people"]) and !empty($_POST["people"])) {
      $notice = storePeopleInfo(test_input($_POST["people"]));
    }
  }

  require("header.php");

 if(isset($_POST["submitPeopleAmount"])){
	$peopleAmount = $_POST["peopleAmount"];
    $enterOrExit = $_POST["enterOrExit"];
    $gender = $_POST["gender"];
    $studentOrTeacher = $_POST["studentOrTeacher"];
	//salvestame, kui vähemalt on inimeste kogus olemas
	if(!empty($_POST["peopleAmount"])){
	  storePeopleInfo($peopleAmount, $enterOrExit, $gender, $studentOrTeacher);
	  $peopleAmount = 0;
      $enterOrExit = null;
      $gender = null;
      $studentOrTeacher = null;
	} else {
		$notice = "Palun sisestage vähemalt inimeste kogus!";
	}
  }


?>
<?php
    echo "<h1>" .$userName ." teeb eksamit.</h1>";
  ?>
  <p>See leht on loodud koolis õppetöö raames, eksami aeg
  ja ei sisalda tõsiseltvõetavat sisu!</p>
  <p><?php echo $notice ?></p> 
  <hr>
  
  <form method="POST">
      <br>
      <label>Sisenejate/väljaminejate arv </label>
	  <br>
	  <input type="number" min="1" max="300" value="<?php echo $peopleAmount?>" name="peopleAmount">
	  <br>
	  <label>Siseneja või väljuja </label>
	  <br>
	  <input type="radio" name="enterOrExit" value="1"><label>Siseneja</label>&nbsp;
	  <br>
	  <input type="radio" name="enterOrExit" value="2"><label>Väljuja</label>&nbsp;
	  <br>
	  <label>Sugu</label>
	  <br>
	  <input type="radio" name="gender" value="1"><label>Mees</label>&nbsp;
	  <br>
	  <input type="radio" name="gender" value="2"><label>Naine</label>&nbsp;
	  <br>
	  <label>Üliõpilane/õppejõud</label>
	  <br>
	  <input type="radio" name="studentOrTeacher" value="1"><label>Üliõpilane</label>&nbsp;
	  <br>
	  <input type="radio" name="studentOrTeacher" value="2"><label>Õppejõud</label>&nbsp;
	  <br>
	  <input type="submit" value="Salvesta" name="submitPeopleAmount">
	  <p>Tagasi <a href="home.php">avalehele</a></p>
	  <br>
  </form>

   <div id="peopleInBuilding">
      <?php
	    echo $allPeopleInBuildingHTML;
		//echo $genderPeopleInBuildingHTML;
	  ?>
  </div>
 
</body>
</html>








  