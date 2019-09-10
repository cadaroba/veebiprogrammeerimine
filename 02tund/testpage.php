<?php
  $userName = "Robin";
  $fullTimeNow = date("d.m.Y H:i:s"); #muutuja on $
  $hourNow = date ("H");
  $partOfDay = "hägune aeg";
  
  if ($hourNow < 8){
	  $partOfDay = "hommik";
  }
?>
<!DOCTYPE HTML>
<html lang="et">
<head>
  <meta charset="utf-8">
  <title>
  <?php
	echo $userName;
  ?>
  Esimene test</title>

</head>
<body>
<?php
  echo "<h1>" . $userName;
?>
  <h1>Esimene test</h1>
  <p>Veebileht on loodud õppetöö käigus, ei sisalda tõsiselt võetavat sisu!</p>
  <hr>
  <?php
    echo "<p>Lehe avamise hetkel oli aeg: " .$fullTimeNow .", ".$partOfDay."</p>";
  ?>
</body>
</html>