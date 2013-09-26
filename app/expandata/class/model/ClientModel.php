<?php

Class ClientModel{

  private $id;

  // objects  private
  private $name;
  private $contact;
  private $postalAddress;
  private $streetAddress;


  // object arrays
  private $types = array();
  private $attributes = array();

  // additional display methods
  public function getFullName(){
    return $this->name->getTitle() . ' ' . $this->name->getFirst() . ' ' . $this->name->getLast();
  }

  // append methods
  public function newType($newType){
    $this->types[] = $newType;
  }

  public function newAttribute($newAttribute){
    $this->attributes[] = $newAttribute;
  }

  // setters and getters
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

  public function setContact($newContact){
    $this->contact = $newContact;
  }
  public function getContact(){
    return $this->contact;
  }

  public function setPostalAddress($newPostalAddress){
    $this->postalAddress = $newPostalAddress;
  }
  public function getPostalAddress(){
    return $this->postalAddress;
  }

  public function setStreetAddress($newStreetAddress){
    $this->streetAddress = $newStreetAddress;
  }
  public function getStreetAddress(){
    return $this->streetAddress;
  }

  public function setTypes($newTypes){
    $this->types = $newTypes;
  }
  public function getTypes(){
    return $this->types;
  }

  public function setAttributes($newAttributes){
    $this->attributes = $newAttributes;
  }
  public function getAttributes(){
    return $this->attributes;
  }

}
