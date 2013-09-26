<?php

Class ContactModel{
  private $id;
  private $home;
  private $work;
  private $mobile;
  private $fax;
  private $email;


  // setters and getters
  public function setId($newId){
    $this->id = $newId;
  }
  public function getId(){
    return $this->id;
  }

  public function setHome($newHome){
    $this->home = $newHome;
  }
  public function getHome(){
    return $this->home;
  }

  public function setWork($newWork){
    $this->work = $newWork;
  }
  public function getWork(){
    return $this->work;
  }

  public function setMobile($newMobile){
    $this->mobile = $newMobile;
  }
  public function getMobile(){
    return $this->mobile;
  }

  public function setFax($newFax){
    $this->fax = $newFax;
  }
  public function getFax(){
    return $this->fax;
  }

  public function setEmail($newEmail){
    $this->email = $newEmail;
  }
  public function getEmail(){
    return $this->email;
  }


}
