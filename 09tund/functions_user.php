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
	$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $conn->prepare("SELECT password FROM vpusers1 WHERE email=?");
	echo $conn->error;
	$stmt->bind_param("s", $email);
	$stmt->bind_result($passwordFromDb);
	if($stmt->execute()){
		//kui päring õnnestus
	  if($stmt->fetch()){ //kontrollib kas selline kasutja on olemas
		//kasutaja on olemas
		if(password_verify($password, $passwordFromDb)){
		  //kui salasõna klapib
		  $stmt->close();
		  $stmt = $conn->prepare("SELECT id, firstname, lastname FROM vpusers1 WHERE email=?");
		  echo $conn->error;
		  $stmt->bind_param("s", $email);
		  $stmt->bind_result($idFromDb, $firstnameFromDb, $lastnameFromDb);
		  $stmt->execute();
		  $stmt->fetch(); 
		  $notice = "Sisse logis " .$firstnameFromDb ." " .$lastnameFromDb ."!";
		  
		  //annan sessioonimuutujatele väärtuse
		  $_SESSION["userId"] = $idFromDb;
		  $_SESSION["userFirstname"] = $firstnameFromDb;
		  $_SESSION["userLastname"] = $lastnameFromDb;
		  
		   //loeme kasutajaprofiili
		  $stmt->close();
		  $stmt = $conn->prepare("SELECT bgcolor, txtcolor FROM vpuserprofiles WHERE userid=?");
		  echo $conn->error;
		  $stmt->bind_param("i", $_SESSION["userId"]);
		  $stmt->bind_result($bgColorFromDb, $txtColorFromDb);
		  $stmt->execute();
		  if($stmt->fetch()){
			$_SESSION["bgColor"] = $bgColorFromDb;
	        $_SESSION["txtColor"] = $txtColorFromDb;
		  } else {
		    $_SESSION["bgColor"] = "#FFFFFF";
	        $_SESSION["txtColor"] = "#000000";
		  }
		  
		  
		  //kuna siirdume teisele lehele, sulgeme andmebaasi ühendused
          $stmt->close();
	      $conn->close();
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
	$conn->close();
	return $notice;
  }//sisselogimine lõppeb
  
  
	  //KASUTAJA SALVESTAMINE ALGAB
  function saveProfile($description, $bgColor, $txtColor){
	$notice = "";
	$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
    $stmt = $conn->prepare("SELECT id FROM vpuserprofiles WHERE userid=?");
	echo $conn->error;
	$stmt->bind_param("i", $_SESSION["userId"]);
	$stmt->bind_result($idFromDb);
	$stmt->execute();
	if($stmt->fetch()){
		//profiil juba olemas, uuendame
		$stmt->close();
		$stmt = $conn->prepare("UPDATE vpuserprofiles SET description = ?, bgcolor = ?, txtcolor = ? WHERE userid = ?");
		echo $conn->error;
		$stmt->bind_param("sssi", $description, $bgColor, $txtColor, $_SESSION["userId"]);
		if($stmt->execute()){
			$notice = "Profiil edukalt uuendatud!";
			$_SESSION["bgColor"] = $bgColor;
	        $_SESSION["txtColor"] = $txtColor;
		} else {
			$notice = "Profiili salvestamisel tekkis tõrge! " .$stmt->error;
		}
		//$notice = "Profiil olemas, ei salvestanud midagi!";
	} else {
		//profiili pole, salvestame
		$stmt->close();
		$stmt = $conn->prepare("INSERT INTO vpuserprofiles (description, bgcolor, txtcolor, userid) VALUES(?,?,?,?)");
		echo $conn->error;
		$stmt->bind_param("sssi", $description, $bgColor, $txtColor, $_SESSION["userId"]);
		if($stmt->execute()){
			$notice = "Profiil edukalt salvestatud!";
		} else {
			$notice = "Profiili salvestamisel tekkis tõrge! " .$stmt->error;
		}
	}
	$stmt->close();
	$conn->close();
	return $notice;
  }
	//KASUTAJA SALVESTAMINE LÕPPEB
  
	function showMyDesc(){
		$notice = null;
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("SELECT description FROM vpuserprofiles WHERE userid=?");
		echo $conn->error;
		$stmt->bind_param("i", $_SESSION["userId"]);
		$stmt->bind_result($descriptionFromDb);
		$stmt->execute();
    if($stmt->fetch()){
	  $notice = $descriptionFromDb;
	}
		$stmt->close();
		$conn->close();
	return $notice;
  }
  
  function changePassword($oldPassword, $newPassword){//esimeses pooles kontrollitakse parooli
	$notice = null;
	$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $conn -> prepare("SELECT password FROM vpusers1 WHERE id = ?");
	echo $conn -> error;
	$stmt -> bind_param("i", $_SESSION["userId"]);
	$stmt -> bind_result($oldPasswordFromDb);
	if($stmt -> execute()){//kui päring õnnestub
		if($stmt -> fetch()){//kontrollime kas kasutaja olemas
			if(password_verify($oldPassword, $oldPasswordFromDb)){//kui salasõna klapib
			  $stmt -> close();
			  //algab passwordi ülekirjutamise funktsioon
			  $stmt = $conn -> prepare("UPDATE vpusers1 SET password = ? WHERE id = ?");
			  echo $conn -> error;
			  $options = ["cost" => 12, "salt" => substr(sha1(rand()), 0, 22)];
			  $newpwdhash = password_hash($newPassword, PASSWORD_BCRYPT, $options);
			  $stmt -> bind_param("si", $newpwdhash, $_SESSION["userId"]);
				if($stmt -> execute()){
				session_destroy();
				$notice = "Kasutaja andmed edukalt uuendatud";
				} else {
				$notice = "Kasutaja salvestamisel tekkis tehniline tõrge.. " .$stmt -> error;
				}
				$conn -> close();
			} else {
				$notice =  "Salasõnad ei klapi";
			}
		} else {
			$notice = "Kasutajat ei eksisteeri (fetch)";
		}
	} else {
		$notice = "Päring ei õnnestu (execute)";
	}
	return $notice;
	}
	