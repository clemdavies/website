<?php

Class StringAttributeModel extends AttributeModel{


  // move to another class, extend this one
  private $value;
  private $clientId;

  public function toStringValue(){
    return $this->value;
  }

  public function setValue($newValue){
    $this->value = $newValue;
  }
  public function getValue(){
    return $this->value;
  }

  public function setClientId($newClientId){
    $this->clientId = $newClientId;
  }
  public function getClientId(){
    return $this->clientId;
  }



}
