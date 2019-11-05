<?php
  class Test{
	  //muutujad ehk properties
	  private $privateNumber;
	  public $publicNumber;
	  
	  //funktsioonid ehk methods
	  //constructor, see on funktsioon, mis käivitub üks kord klassi kasutusele võtmisel
	  function __construct($sentNumber){
		  $this->publicNumber = $sentNumber;
		  $this->privateNumber = 72;
		  echo "Salajase ja avaliku arvu korrutis on: " . $this->publicNumber * $this->privateNumber;
		  $this->tellSecret();
	  }//construct end
	  //destructor, käivitatakse kui klass eemaldatakse, enam ei kasutata, töö lõppeb
	  
	  function __destruct(){
		  echo  "Klass lõpetas tegevuse!";
	  }//destruct end
	  
	  private function tellSecret(){
		  echo " Salajane number on: " .$this->privateNumber;
	  }//private end
	  
	  public function tellPublicSecret(){
		  echo " Salajane number on tõesti: " .$this->privateNumber;
	  }//public end
	  
	  
  }//class end