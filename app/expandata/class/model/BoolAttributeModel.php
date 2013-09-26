<?php

Class BoolAttributeModel extends AttributeModel{


  // move to another class, extend this one
  private $value;
  private $clientId;

  private $boolArray   = Array(true=>true,false=>false,'true'=>true,'false'=>false);
  private $stringArray = Array('true'=>'true','false'=>'false',true=>'true',false=>'false');

  public function toStringValue(){
    return $this->stringArray[$this->value];
  }

  public function setValue($newValue){
    $this->value = $this->boolArray[$newValue];
  }
  public function getValue(){
    return (int)$this->value;
  }

  public function setClientId($newClientId){
    $this->clientId = $newClientId;
  }
  public function getClientId(){
    return $this->clientId;
  }


}
