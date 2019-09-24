<?php
  $userName = "Robin";
  
  $photoDir = "../photos/";
  $photoTypes = ["image/jpeg", "image/png"];
  
  $fullTimeNow = date("d.m.Y H:i:s"); #muutuja on $
  $hourNow = date ("H");
  $partOfDay = "hägune aeg";
  
  if ($hourNow < 8){
	  $partOfDay = "hommik";
	  
  }
	  //info semestri kulgemise kohta
	  $semesterStart = new DateTime("2019-9-2");
	  $semesterEnd = new DateTime("2019-12-13");
	  $semesterDuration = $semesterStart -> diff($semesterEnd);
	  $Today = new DateTime ("now");
	  $semesterElapsed = $semesterStart -> diff($Today);
	  //echo $SemesterDuration;
	  //var_dump ($semesterDuration;
	  //<p>Semester on täies hoos:
	  //<meter min="0" max = "112" value "16">13%</meter>
	  //</p>
	  $semesterInfoHTML = null;
	  if ($semesterElapsed -> format ("%r%a") >= 0){
		  $semesterInfoHTML = "<p>Semester on täies hoos:";
		  $semesterInfoHTML .= '<meter min="0" max="' .$semesterDuration -> format ("%r%a") .'" ';
		  $semesterInfoHTML .= 'value="' .$semesterElapsed -> format("%r%a") . '">';
		  $semesterInfoHTML .= round($semesterElapsed -> format ("%r%a") / $semesterDuration -> format("%r%a") * 100, 1) ."%";
		  $semesterInfoHTML .= "</meter> </p>";
	  }
	  
	  //foto näitamine lehel //scandir - loeb kataloogi sisu //var_dump - kontrollimiseks //array_slice - lõikab välja 2 kausta // foreach - kontrollib jpg faile //array_push - pane massiivi
	  $fileList = array_slice(scandir($photoDir), 2);
	  //var_dump ($fileList); 
	
	  $photoList = [];
	  foreach ($fileList as $file){
		  $fileInfo = getImagesize($photoDir .$file);
		  //var_dump ($fileInfo);
		  if (in_array($fileInfo["mime"], $photoTypes)){
			  array_push($photoList, $file);
			  
		  }
	  }
	  
	  //$photoList = ["tlu_terra_600x400_1.jpg", "tlu_terra_600x400_2.jpg", "tlu_terra_600x400_3.jpg"];//array ehk massiiv
	  //var_dump($photoList);
	  $photoCount = count($photoList);
	  //echo $photoCount; //mt_rand on kiirem ja juhuslikum
	  $photoNum = mt_rand(0, $photoCount -1);
	  //echo $photoList[$photoNum];
	  //<img src="../photos/tlu_terra_600x400_1.jpg" alt="TLÜ Terra õppehoone">
	  $randomImgHTML = '<img src="' .$photoDir .$photoList[$photoNum] .'" alt="Juhuslik foto">';
	  
	  require("header.php"); //nõuab tükki minu kasutast

  echo "<h1>" . $userName ."</h1>";
?>
  <h1>Esimene test</h1>
  <p>Veebileht on loodud õppetöö käigus, ei sisalda tõsiselt võetavat sisu!</p>
  <?php
	echo $semesterInfoHTML;
	?>
  <hr>
  <?php
    echo "<p>Lehe avamise hetkel oli aeg: " .$fullTimeNow .", ".$partOfDay.".</p>";
	echo $randomImgHTML;
	 //kodus jalus ja html teha php, indikaator kaotada kui semester läbi, fotodega see et kui pilte pole siis ütleb et fotosid pole

  ?>
 
 
</body>
</html>