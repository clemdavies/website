<?php

Class AddressModel{

  private $id;
  private $unitNumber;
  private $streetNumber;
  private $streetName;
  private $city;
  private $state;

  //objects
  private $postcode;
  private $suburb;

  //additional output

  public function getSelectedState($state){
    if ($state == $this->state){
      return 'selected';
    }else{
      return null;
    }
  }


  // setters and getters
  public function setId($newId){
    $this->id = $newId;
  }
  public function getId(){
    return $this->id;
  }

  public function setUnitNumber($newUnitNumber){
    $this->unitNumber = $newUnitNumber;
  }
  public function getUnitNumber(){
    return $this->unitNumber;
  }

  public function setStreetNumber($newStreetNumber){
    $this->streetNumber = $newStreetNumber;
  }
  public function getStreetNumber(){
    return $this->streetNumber;
  }

  public function setStreetName($newStreetName){
    $this->streetName = $newStreetName;
  }
  public function getStreetName(){
    return $this->streetName;
  }

  public function setCity($newCity){
    $this->city = $newCity;
  }
  public function getCity(){
    return $this->city;
  }

  public function setState($newState){
    $this->state = $newState;
  }
  public function getState(){
    return $this->state;
  }

  public function setPostcode($newPostcode){
    $this->postcode = $newPostcode;
  }
  public function getPostcode(){
    return $this->postcode;
  }

  public function setSuburb($newSuburb){
    $this->suburb = $newSuburb;
  }
  public function getSuburb(){
    return $this->suburb;
  }




}
