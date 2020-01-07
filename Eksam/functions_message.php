<?php
function storeMessage($myMessage){
	$notice = null;
	$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);#andmebaasiga suhtlemine new mysqli = uus ühendus #eemaldab kasutaja inputi
	$stmt = $conn -> prepare("INSERT INTO vpmsg1 (userid, message) VALUES(?,?)");#valmistab ette/kontrollib
	echo $conn -> error;#kontrollpõhimõttega
	$stmt -> bind_param("is", $_SESSION["userId"], $myMessage);#loob seose preparega
	if ($stmt -> execute()){ #SQL käsu täitmine ehk [ENTER] vajutus
		$notice = "Sõnum salvestati";
	} else {
		$notice = "Sõnumi salvestamisel tekkis tõrge: " .$stmt->error;
	}
	$stmt -> close();
	$conn -> close();
	return $notice;
}
function readMyMessages(){
	$limit = 5;
//function readAllMessages(){	//funktsioon toob teksti messages.php lehel välja
	$messagesHTML = null;
	//saadame andmebaasile uue ühenduse, kust küsime..
	$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	//$stmt = $conn->prepare("SELECT message, created FROM vpmsg1");
	//$stmt = $conn->prepare("SELECT message, created FROM vpmsg1 WHERE deleted IS NULL");
	$stmt = $conn->prepare("SELECT message, created FROM vpmsg1 WHERE userid = ? AND deleted IS NULL ORDER BY created DESC LIMIT ?");
	echo $conn -> error;
	//nüüd hakkame asju tagasi tooma
	$stmt -> bind_param("ii", $_SESSION["userId"], $limit);
	$stmt -> bind_result($messageFromDb, $createdFromDb);
	$stmt -> execute();
	//nüüd hakkame võtma
	while($stmt -> fetch()){
		$messagesHTML .= "<li>" .$messageFromDb ." Lisatud: " .$createdFromDb ."</li> \n";
	}
	if (!empty($messagesHTML)){
		$messagesHTML = "<ul> \n" .$messagesHTML ."</ul> \n";
	} else {
		$messagesHTML = "<p>Sõnumeid pole</p> \n";
	}
	
	$stmt -> close();
	$conn -> close();
	return $messagesHTML;
}