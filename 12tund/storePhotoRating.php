<?php
	//saame saadetud väärtuse(d)
	$rating = $_REQUEST["rating"];
	$photoId = $_REQUEST["photoid"];
	require("../../../config_vp2019.php");
	require("functions_user.php");
	$database = "if19_robin_ka_1";
	
	$conn = new mysqli($serverHost, $serverUsername, $serverPassword, $database);
	$stmt = $conn->prepare("INSERT INTO vpphotoratings1 (photoid, userid, rating) VALUES (?, ?, ?)");
	$stmt->bind_param("iii", $photoId, $_SESSION["userId"], $rating);
	$stmt->execute();
	$stmt->close();
	//küsime uue keskmise hinde
	$stmt=$conn->prepare("SELECT AVG(rating)FROM vpphotoratings1 WHERE photoid=?");
	$stmt->bind_param("i", $photoId);
	$stmt->bind_result($score);
	$stmt->execute();
	$stmt->fetch();
	$stmt->close();
	$conn->close();
	//ümardan keskmise hinde kaks kohta pärast koma ja tagastan
	echo round($score, 2);