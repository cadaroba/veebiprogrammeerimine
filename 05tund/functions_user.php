<?php
 function signUp($name, $surname, $email, $gender, $birthDate, $password){
	 $notice = null;
	 $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	 $stmt = $conn->prepare("INSERT INTO vpusers1 (firstname, lastname, birthdate, gender, email, password) VALUES(?,?,?,?,?,?) ");
	 echo $conn->error;
	 $options = ["cost" => 12, "salt" => substr(sha1(rand()), 0, 22)];
	 $pwdhash = password = password_hash($password, PASSWORD_BCRYPT, $options);
	 $stmt->bind_param("sssiss", $name, $surname, $birthDate, $gender, $email, $password, $pwdhash);
	 if ($stmt->execute()){
		 $notice = "Kasutaja loomine õnnestus!";
	 } else {
		 $notice = "Kasutaja loomisel tekkis tehniline viga: " .$stmt->error;
	 }
	 
	 
	 $stmt -> close();
	 $conn -> close();
	 return $notice;
	 
 }
 ?>