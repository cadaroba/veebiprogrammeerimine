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
		$filmHour = round($filmDuration / 60);
		if ($filmHour == 1){
			$filmHour .= " tund ";
		}
		else if ($filmHour == 0){
			$filmHour = null;
		}
		else{
			$filmHour .= " tundi ";
		}
		
		//FILMIMINUTID
		$filmMinute = $filmDuration % 60;
		if($filmMinute == 1){
			$filmMinute .= "ja". $filmMinute." minut ";
		}
		else if ($filmMinute == 0){
			$filmMinute = null;
		}
		else if($filmMinute > 0  and $filmHour == 0){
			$filmMinute = $filmMinute . "minutit";
		}
		else{
			$filmMinute = " ja " .$filmMinute. " minutit";
		}
		
		$filmInfoHTML .= "<h3>" . $filmTitle ."</h3>";
		$filmInfoHTML .= "<p>Zanr: " . $filmGenre . ", lavastaja: " . $filmDirector . ". Kestus: ".$filmHour.$filmMinute.". Tootnud: " . $filmStudio . " aastal: " . $filmYear . " </p>";
	}
		//KODUS TEHTUD//KODUS TEHTUD//KODUS TEHTUD//
		
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