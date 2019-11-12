<?php
  function addPicData($fileName, $altText, $privacy){
		$notice = null;
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("INSERT INTO vpphotos1 (userid, filename, alttext, privacy) VALUES (?, ?, ?, ?)");
		echo $conn->error;
		$stmt->bind_param("issi", $_SESSION["userId"], $fileName, $altText, $privacy);
		if($stmt->execute()){
			$notice = " Pildi andmed salvestati andmebaasi!";
		} else {
			$notice = " Pildi andmete salvestamine ebaönnestus tehnilistel põhjustel! " .$stmt->error;
		}
		$stmt->close();
		$conn->close();
		return $notice;
	}

	function readgalleryImages($privacy, $page, $limit){
		$html = null;
		$skip = ($page - 1) * $limit;
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("SELECT filename, alttext FROM vpphotos1 WHERE privacy<=? AND deleted IS NULL ORDER BY id DESC LIMIT ?, ?");
		echo $conn->error;
		$stmt->bind_param("iii", $privacy, $page, $limit);
		$stmt->bind_result($fileNameFromDb, $altTextFromDb);
		$stmt->execute();
		while($stmt->fetch()){
			//<img src="thumbs_kataloog/pilt" alt="tekst"> \n
			$html .= '<img src="' .$GLOBALS["pic_upload_dir_thumb"] .$fileNameFromDb .'" alt="';
			if ($altTextFromDb == null){
				$html .= "Foto";
			} else {
				$html .= $altTextFromDb;
			}
			$html .= '">' ."\n";
		}
		if($html == null){
			$html = "<p>Kahjuks avalikke pilte pole!</p>";
		}
		$stmt->close();
		$conn->close();
		return $html;
	}
	
	function readAllPublicPicsPage($privacy, $page, $limit){
		$picHTML = null;
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("SELECT filename, alttext FROM vpphotos1 WHERE privacy<=? AND deleted IS NULL ORDER BY id DESC LIMIT ?,?");
		echo $conn->error;
		$skip = ($page - 1) * $limit;
		$stmt->bind_param("iii", $privacy, $skip, $limit);
		$stmt->bind_result($fileNameFromDb, $altTextFromDb);
		$stmt->execute();
		while($stmt->fetch()){
			//<img src="thumbs_kataloog/pilt" alt=""> \n
			$picHTML .= '<img src="' .$GLOBALS["pic_upload_dir_thumb"] .$fileNameFromDb .'" alt="' .$altTextFromDb .'">' ."\n";
		}
		if($picHTML == null){
			$picHTML = "<p>Kahjuks avalikke pilte pole!</p> \n";
		}
		$stmt->close();
		$conn->close();
		return $picHTML;
	}
	
	function countPics($privacy){
		$notice = null;
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS[ "database"]);
		$stmt = $conn->prepare("SELECT COUNT(id) FROM vpphotos1 WHERE privacy <= ? AND  deleted IS NULL");
		echo $conn->error;
		$stmt->bind_param("i", $privacy);
		$stmt->bind_result($count);
		$stmt->execute();
		$notice = $count;

		
		$stmt->close();
		$conn->close();
		return $notice;
	}
	
	function latestPicture($privacy){
	$html = "<p>Pole pilti, mida näidata!";
	$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $conn->prepare("SELECT filename, alttext FROM vpphotos1 WHERE id=(SELECT MAX(id) FROM vpphotos1 WHERE privacy=? AND deleted IS NULL)");
	echo $conn->error;
	$stmt->bind_param("i", $privacy);
	$stmt->bind_result($filenameFromDb, $altFromDb);
	$stmt->execute();
	if($stmt->fetch()){
		$html = '<img src="' .$GLOBALS["pic_upload_dir_w600"] .$filenameFromDb .'" alt="'.$altFromDb .'">';
	} else {
		$html = "<p>Kahjuks avalikke pilte pole!</p>";
	}
	$stmt->close();
	$conn->close();
	return $html;
}
?>