<?php

Class NameModel{

  private $id;
  private $title;
  private $first;
  private $last;


  // setters and getters
  public function setId($newId){
    $this->id = $newId;
  }
  public function getId(){
    return $this->id;
  }

  public function setTitle($newTitle){
    $this->title = $newTitle;
  }
  public function getTitle(){
    return $this->title;
  }

  public function setFirst($newFirst){
    $this->first = $newFirst;
  }
  public function getFirst(){
    return $this->first;
  }

  public function setLast($newLast){
    $this->last = $newLast;
  }
  public function getLast(){
    return $this->last;
  }

}
