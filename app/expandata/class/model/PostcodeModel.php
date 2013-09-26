<?php

Class PostcodeModel{

  private $id;
  private $number;

  public function setId($newId){
    $this->id = $newId;
  }
  public function getId(){
    return $this->id;
  }

  public function setNumber($newNumber){
    $this->number = $newNumber;
  }
  public function getNumber(){
    return $this->number;
  }
}
?>
