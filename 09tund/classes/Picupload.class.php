<?php
  class Picupload {
	  private $imageFileType;
	  private $tmpPic;
	  private $myTempImage;
	  private $myNewImage;
	  
	  function __construct($tmpPic, $imageFileType){
		  $this->imageFileType = $imageFileType;
		  $this->tmpPic = $tmpPic;
		  $this->createImageFromFile();
	  }//construct end
	  
	  function __destruct(){
		  imagedestroy($this->myTempImage);
	  }//destruct end
	  
	  public function addWatermark($wmFile){//wmFile = watermark file
		  $waterMark = imagecreatefrompng($wmFile);
		  $waterMarkW = imagesx($waterMark);
		  $waterMarkH = imagesy($waterMark);
		  $waterMarkX = imagesx($this->myNewImage) - $waterMarkW - 10;
		  $waterMarkY = imagesy($this->myNewImage) - $waterMarkH - 10;
		  imagecopy($this->myNewImage, $waterMark, $waterMarkX, $waterMarkY, 0, 0, $waterMarkW, $waterMarkH);
	  }//addWatermark end
	  
	  private function createImageFromFile(){
		  if($this->imageFileType == "jpg" or $this->imageFileType == "jpeg"){
			 $this->myTempImage = imagecreatefromjpeg($this->tmpPic);
		  }
		  if($this->imageFileType == "png"){
			  $this->myTempImage = imagecreatefromjpeg($this->tmpPic);
		  }
		  if($this->imageFileType == "gif"){
			  $this->myTempImage = imagecreatefromjpeg($this->tmpPic);
		  }
	  }//createImageFromFile end
	  
	  public function resizeImage($maxPicW, $maxPicH){
		$imageW = imagesx($this->myTempImage);
		$imageH = imagesy($this->myTempImage);
		
		if($imageW > $maxPicW or $imageH > $maxPicH){
			if($imageW / $maxPicW > $imageH /$maxPicH){
				$picSizeRatio = $imageW / $maxPicW;
			} else {
				$picSizeRatio = $imageH / $maxPicH;
			}
			$imageNewW = round($imageW / $picSizeRatio, 0);
			$imageNewH = round($imageH / $picSizeRatio, 0);
			$this->myNewImage = $this->setPicSize($this->myTempImage, $imageW, $imageH, $imageNewW, $imageNewH);  
	   }//resizeImage if statement lõppeb
	 }//resizeImage lõppeb
	 
	 private function setPicSize($myTempImage, $imageW, $imageH, $imageNewW, $imageNewH){//läbipaistvus kaob PNG ja GIF
	  //funkts teeb väiksema pikslikogumi//imagecreatetruecolor=24bitine
	  $myNewImage = imagecreatetruecolor($imageNewW, $imageNewH);
	  //pannakse uus image kokku pikslikogumist väiksema resolutsiooniga
	  imagecopyresampled($myNewImage, $myTempImage, 0, 0, 0, 0, $imageNewW, $imageNewH, $imageW, $imageH);
	  return $myNewImage;
     }//setPicSize end
  
	 public function savePicFile($filename){
		if($this->imageFileType == "jpg" or $this->imageFileType == "jpeg"){
			if(imagejpeg($this->myNewImage, $filename, 90)){
				$notice = "Vähendatud faili salvestamine õnnestus.";
			} else {
				$notice = "Vähendatud faili salvestamine ei õnnestunud.";
			}
		}
		if($this->imageFileType == "png"){
			if(imagepng($this->myNewImage, $filename, 6)){
				$notice = "Vähendatud faili salvestamine õnnestus.";
			} else {
				$notice = "Vähendatud faili salvestamine ei õnnestunud.";
			}
		}
		if($this->imageFileType == "gif"){
			if(imagepng($this->myNewImage, $filename)){
				$notice = "Vähendatud faili salvestamine õnnestus.";
			} else {
				$notice = "Vähendatud faili salvestamine ei õnnestunud.";
			}
		}
		imagedestroy($this->myNewImage);
		return $notice;
    }//savePicFile end        
	  
  }//class end