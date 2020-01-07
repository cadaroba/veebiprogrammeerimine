<?php
//Loon andmebaasi ühenduse
  function storePeopleInfo($peopleAmount, $enterOrExit, $gender, $studentOrTeacher){
	  $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	  $stmt = $conn -> prepare("INSERT INTO peopleInBuilding (peopleAmount, enterOrExit, gender, studentOrTeacher) VALUES(?,?,?,?)");
	  //andmetüübid: s-string, i-integer, d-decimal
	  $stmt -> bind_param("iiii", $peopleAmount, $enterOrExit, $gender, $studentOrTeacher);
	  $stmt -> execute();
	  
	  $stmt -> close();
	  $conn -> close();
	  
  }
  //Loendame inimesi
  function readAllPeopleInBuilding($peopleAmount){
		$html = null;
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		//$stmt = $conn->prepare("SELECT filename, alttext FROM vpphotos1 WHERE privacy<=? AND deleted IS NULL ORDER BY id DESC LIMIT ?, ?");
		$stmt = $conn->prepare("SELECT SUM(peopleAmount) FROM peopleInBuilding");
		echo $conn->error;
		$stmt->bind_param("i", $peopleAmount);
		$stmt->bind_result($sumFromDb);
		$stmt->execute();
		$stmt->fetch();
			if($sumFromDb == 0){
				$html .="Hoones pole inimesi..";
			} else {
				$html .= "Hoones on inimesi: " .($sumFromDb);
			}
			$html .= "</p> \n";
			$html .= "</div>";
			
		$stmt->close();
		$conn->close();
		return $html;
		}
		
  function readGenderPeopleInBuilding($gender){
		$html = null;
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		//$stmt = $conn->prepare("SELECT filename, alttext FROM vpphotos1 WHERE privacy<=? AND deleted IS NULL ORDER BY id DESC LIMIT ?, ?");
		$stmt = $conn->prepare("SELECT COUNT (gender) FROM peopleInBuilding");
		echo $conn->error;
		$stmt->bind_param("i", $gender);
		$stmt->bind_result($countFromDb);
		$stmt->execute();
		$stmt->fetch();
			if($countFromDb == 2){
				$html .="Hoones on" .($countFromDb) ."naissoost isikut";
			} else {
				$html .= "Hoones on" .($countFromDb) ."meessoost isikut";
			}
			$html .= "</p> \n";
			$html .= "</div>";
			
		$stmt->close();
		$conn->close();
		return $html;
		}