<?php
Class CategoryModel{

  private $id;
  private $name;
  private $image;

  public function populateUsingDatabaseMap($dbResultArray){
    $this->id            = $dbResultArray['id'];
    $this->name          = $dbResultArray['name'];
    $this->image         = $dbResultArray['image_filename'];
  }
  public function populateUsingArticleDatabaseMap($dbResultArray){
    $this->id            = $dbResultArray['category_id'];
    $this->name          = $dbResultArray['category_name'];
    $this->image         = $dbResultArray['category_image_filename'];
  }

  public function getId(){
    return $this->id;
  }
  public function setId($newId){
    $this->id = $newId;
  }

  public function getName(){
    return $this->name;
  }
  public function setName($newName){
    $this->name = $newName;
  }

  public function getImage(){
    return $this->image;
  }
  public function setImage($newImage){
    $this->image = $newImage;
  }

  /*
  public function toJson(){
    $json = ['id'=>$this->id,
             'name'=>$this->name,
             'image'=>$this->image];

    return $json;
  }
  */

}
