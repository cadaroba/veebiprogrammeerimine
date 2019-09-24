<?php
  function readAllFilms(){ //lõin funktsiooni ja panin selle sinna sisse loogeliste sulgudega
	//var_dump($GLOBALS); //väljastab massiive
	//Loeme andmebaasist filmide infot
	//Loome andmebaasiühenduse ($mysqli $conn)
	//$conn = new mysqli($serverHost, $serverUsername, $serverPassword, $database);
	$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	//valmistan ette päringu
	$stmt = $conn -> prepare("SELECT pealkiri, aasta FROM film"); //pealkiri = $filmTitles
	echo $conn -> error;
	//$filmTitle = "Tühjus";
	$filmInfoHTML = null; //tühi väärtus muutujal
	$stmt -> bind_result($filmTitle, $filmYear); //seon stmt
	$stmt -> execute();
	//sain pinu (stack) täie infot, hakkan ühekaupe võtma, kuni saab
	while ($stmt -> fetch()){ //korduva fetchi jaoks on vaja tsüklit	
		//echo " Pealkiri: " .$filmTitle; see on programmeerijale abiks/pole ilus vaadata
		$filmInfoHTML .= "<h3>" . $filmTitle ."</h3>";
		$filmInfoHTML .= "<p>" . $filmYear ."</p>";
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