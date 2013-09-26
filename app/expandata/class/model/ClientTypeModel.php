<?php

/*
  for inserts into database
  for relating client to a type/group
*/
Class ClientTypeModel{

  private $id;
  private $clientId;
  private $typeId;

  public function setId($newId){
    $this->id = $newId;
  }
  public function getId(){
    return $this->id;
  }

  public function setClientId($newClientId) {
    $this->clientId = $newClientId;
  }
  public function getClientId(){
    return $this->clientId;
  }

  public function setTypeId($newTypeId) {
    $this->typeId = $newTypeId;
  }
  public function getTypeId(){
    return $this->typeId;
  }

}
