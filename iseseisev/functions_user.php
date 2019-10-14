<?php

//Võtan kasutusele sessiooni
session_start();
//var_dump($_SESSION);

function signUp($name, $surname, $email, $gender, $birthDate, $password){
	$notice = null;
	$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $conn->prepare("INSERT INTO vpusers1 (firstname, lastname, birthdate, gender, email, password) VALUES(?,?,?,?,?,?)");
	echo $conn->error;
	$options = ["cost" => 12, "salt" => substr(sha1(rand()), 0, 22)];
	$pwdhash = password_hash($password, PASSWORD_BCRYPT, $options);
	$stmt->bind_param("sssiss", $name, $surname, $birthDate, $gender, $email, $pwdhash);
	if($stmt->execute()){
		$notice = "Kasutaja loomine õnnestus!";
	} else {
		$notice = "Kasutaja loomisel tekkis tehniline viga: " .$stmt->error;
	} 
	$stmt -> close();
	$conn -> close();
	return $notice;
}

   function signIn($email, $password){
	$notice = "";
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("SELECT password FROM vpusers1 WHERE email=?");
	echo $mysqli->error;
	$stmt->bind_param("s", $email);
	$stmt->bind_result($passwordFromDb);
	if($stmt->execute()){
		//kui päring õnnestus
	  if($stmt->fetch()){ //kontrollib kas selline kasutja on olemas
		//kasutaja on olemas
		if(password_verify($password, $passwordFromDb)){
		  //kui salasõna klapib
		  $stmt->close();
		  $stmt = $mysqli->prepare("SELECT id, firstname, lastname FROM vpusers1 WHERE email=?");
		  echo $mysqli->error;
		  $stmt->bind_param("s", $email);
		  $stmt->bind_result($idFromDb, $firstnameFromDb, $lastnameFromDb);
		  $stmt->execute();
		  $stmt->fetch(); 
		  $notice = "Sisse logis " .$firstnameFromDb ." " .$lastnameFromDb ."!";
		  
		  //annan sessioonimuutujatele väärtuse
		  $_SESSION["userId"] = $idFromDb;
		  $_SESSION["userFirstname"] = $firstnameFromDb;
		  $_SESSION["userLastname"] = $lastnameFromDb;
		  loadColor();
		  
		  
		  //kuna siirdume teisele lehele, sulgeme andmebaasi ühendused
          $stmt->close();
	      $mysqli->close();
          //siirduma teisele lehele
		  header("Location: home.php");
		  //katkestame edasise tegevuse siin
		  exit();
		  
		} else {
		  $notice = "Vale salasõna!";
		}
	  } else {
		$notice = "Sellist kasutajat (" .$email .") ei leitud!";  
	  }
	} else {
	  $notice = "Sisselogimisel tekkis tehniline viga!" .$stmt->error;
	}
	
	$stmt->close();
	$mysqli->close();
	return $notice;
  }//sisselogimine lõppes
  
  function saveProfile($mydescription, $mybgcolor, $mytxtcolor){
	  //KASUTAJA SALVESTAMINE ALGAB
	  $notice = "";
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("INSERT INTO vpuserprofiles (userid, description, bgcolor, txtcolor) VALUES (?, ?, ?, ?)");
	$stmt->bind_param("isss", $idFromDb, $mydescription, $mybgcolor, $mytxtcolor);
	
	  $idFromDb = $_SESSION["userId"];
	  
	if($stmt->execute()){//kui päring õnnesub
	  $notice = "Profiili salvestamine õnnestus";
	} else {
		$notice = "Profiili salvestamisel tekkis probleem";
		$stmt->error;
	}
	$stmt->close();
	$mysqli->close();
	return $notice;
	//KASUTAJA SALVESTAMINE LÕPPEB
  }
  
  function loadColor(){
  	$notice = "";
		$mysqli = new mysqli($GLOBALS['serverHost'], $GLOBALS['serverUsername'], $GLOBALS['serverPassword'], $GLOBALS['database']);
		//$stmt = $mysqli->prepare("SELECT idea, color FROM vpuserideas");
		$stmt = $mysqli->prepare("SELECT description, bgcolor, txtcolor FROM vpuserprofiles WHERE userid = ? ORDER BY id DESC");
		
		$stmt->bind_param("i", $_SESSION["userId"]);
		
		$stmt->bind_result($description, $bgcolor,$txtcolor);
		$stmt->execute();
		$stmt->fetch();
		$_SESSION["description"] = $description;
		$_SESSION["bgColor"] = $bgcolor;
		$_SESSION["txtColor"] = $txtcolor;
		
		$stmt->close();
		$mysqli->close();
		
	}