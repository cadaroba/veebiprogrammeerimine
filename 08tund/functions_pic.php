<?php
  function setPicSize($myTempImage, $imageW, $imageH, $imageNewW, $imageNewH){//läbipaistvus kaob PNG ja GIF
	  //funkts teeb väiksema pikslikogumi//imagecreatetruecolor=24bitine
	  $myNewImage = imagecreatetruecolor($imageNewW, $imageNewH);
	  //pannakse uus image kokku pikslikogumist väiksema resolutsiooniga
	  imagecopyresampled($myNewImage, $myTempImage, 0, 0, 0, 0, $imageNewW, $imageNewH, $imageW, $imageH);
	  return $myNewImage;
  }



?>