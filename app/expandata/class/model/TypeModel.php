<?php

Class TypeModel{

  private $id;
  private $name;

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

}
