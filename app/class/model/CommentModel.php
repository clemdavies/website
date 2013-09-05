<?php
Class CommentModel{

  private $id;
  private $articleId;
  private $name;
  private $content;
  private $dateTime;
  private $seen;

  public function populateUsingDatabaseMap($dbResultArray){
    $this->id        = $dbResultArray['id'];
    $this->articleId = $dbResultArray['article_id'];
    $this->name      = $dbResultArray['name'];
    $this->content   = $dbResultArray['content'];
    $this->dateTime  = $dbResultArray['date'];
    $this->seen      = $dbResultArray['seen'];
  }
  /*
  public function populateUsingArticleDatabaseMap($dbResultArray){
    $this->id            = $dbResultArray['category_id'];
    $this->name          = $dbResultArray['category_name'];
    $this->image         = $dbResultArray['category_image_filename'];
  }
  */

  public function getId(){
    return $this->id;
  }
  public function setId($newId){
    $this->id = $newId;
  }

  public function getArticleId(){
    return $this->articleId;
  }
  public function setArticleId($newArticleId){
    $this->articleId = $newArticleId;
  }

  public function getName(){
    return $this->name;
  }
  public function setName($newName){
    $this->name = $newName;
  }

  public function getContent(){
    return $this->content;
  }
  public function setContent($newContent){
    $this->content = $newContent;
  }

  public function getDateTime(){
    return $this->dateTime;
  }
  public function setDateTime($newDateTime){
    $this->dateTime = $newDateTime;
  }

  public function getSeen(){
    return $this->seen;
  }
  public function setSeen($newSeen){
    $this->seen = $newSeen;
  }


  public function formatDate(){
    return date('jMY',strtotime($this->dateTime));
  }
  public function newDateTime(){
    $this->dateTime = date('Y-m-d H:i:s');
  }
  public function newSeen(){
    $this->seen = 0;
  }

}
