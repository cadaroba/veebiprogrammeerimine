<?php
  function readAllFilms(){ //lõin funktsiooni ja panin selle sinna sisse loogeliste sulgudega
	//var_dump($GLOBALS); //väljastab massiive
	//Loeme andmebaasist filmide infot
	//Loome andmebaasiühenduse ($mysqli $conn)
	//$conn = new mysqli($serverHost, $serverUsername, $serverPassword, $database);
	$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	//valmistan ette päringu
	$stmt = $conn -> prepare("SELECT pealkiri, zanr, lavastaja, kestus, tootja, aasta FROM film"); //pealkiri = $filmTitles
	echo $conn -> error;
	//$filmTitle = "Tühjus";
	$filmInfoHTML = null; //tühi väärtus muutujal
	$stmt -> bind_result($filmTitle, $filmGenre, $filmDirector, $filmDuration, $filmStudio, $filmYear); //seon stmt
	$stmt -> execute();
	//sain pinu (stack) täie infot, hakkan ühekaupe võtma, kuni saab
	while ($stmt -> fetch()){ //korduva fetchi jaoks on vaja tsüklit	
		//echo " Pealkiri: " .$filmTitle; see on programmeerijale abiks/pole ilus vaadata
		
		//KODUS TEHTUD//KODUS TEHTUD//KODUS TEHTUD//
		//FILMITUNNID
		$filmInfoHTML .= "<h3>" . $filmTitle ."</h3>";
		$filmHours = round($filmDuration / 60);
		$filmMinutes = $filmDuration % 60;
		$filmDurationDesc = null;
		if ($filmHours > 0){
			if($filmHours == 1){
				$filmDurationDesc .= $filmHours ." tund ja ";
			} else {
				$filmDurationDesc .= $filmHours ." tundi ja ";
			}
			if($filmMinutes == 1){
				$filmDurationDesc .= $filmMinutes ." minut";
			} else {
				$filmDurationDesc .= $filmMinutes ." minutit";
			}
		}
		$filmInfoHTML .= "<p>Žanr: " .$filmGenre .", lavastaja: " .$filmDirector .". Kestus: " .$filmDurationDesc .". Tootnud: " .$filmStudio ." aastal: " .$filmYear .".</p>";
		//KODUS TEHTUD//KODUS TEHTUD//KODUS TEHTUD//
	}
		
	//sulgen ühenduse
	$stmt -> close();
	$conn -> close();
	return $filmInfoHTML;
 }

  function storeFilmInfo($filmTitle, $filmYear, $filmDuration, $filmGenre, $filmStudio, $filmDirector){
	  $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	  $stmt = $conn -> prepare("INSERT INTO film (pealkiri, aasta, kestus, zanr, tootja, lavastaja) VALUES(?,?,?,?,?,?)");
	  //andmetüübid: s-string, i-integer, d-decimal
	  $stmt -> bind_param("siisss", $filmTitle, $filmYear, $filmDuration, $filmGenre, $filmStudio, $filmDirector);
	  $stmt -> execute();
	  
	  $stmt -> close();
	  $conn -> close();
	  
  }
  
  function readOldFilms($filmAge){
	  $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	  $maxYear = date("Y") - $filmAge;
	  $stmt = $conn->prepare("SELECT pealkiri, aasta FROM film WHERE aasta < ?");
	  $stmt->bind_param("i", $maxYear);
	  $stmt->bind_result($filmTitle, $filmYear);
	  $stmt->execute();
	  $filmInfoHTML = "";
	  while($stmt->fetch()){
		$filmInfoHTML .= "<h3>" .$filmTitle ."</h3>";
		$filmInfoHTML .= "<p>Tootmisaasta: " .$filmYear .".</p>";
	  }
	  
	  $stmt->close();
	  $conn->close();
	  return $filmInfoHTML;
 }