<?php

Class SuburbModel{

  private $id;
  private $name;

  //object
  private $postcode;

  public function setId($newId){
    $this->id = $newId;
  }
  public function getId(){
    return $this->id;
  }

  public function setName($newName){
    $this->name = $newName;
  }
  public function getName(){
    return $this->name;
  }

  public function setPostcode($newPostcode){
    $this->postcode = $newPostcode;
  }
  public function getPostcode(){
    return $this->postcode;
  }


}
