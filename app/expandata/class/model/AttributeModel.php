<?php

Class AttributeModel{

  protected $id;
  protected $name;
  protected $type;


  // getters and setters
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

  public function setType($newType){
    $this->type = $newType;
  }
  public function getType(){
    return $this->type;
  }

}
