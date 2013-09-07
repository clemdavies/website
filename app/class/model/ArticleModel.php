<?php
Class ArticleModel{

  private $id;
  private $title;
  private $dateTime;
  private $content;

  // CategoryModel object
  private $category;

  // CommentModel object array
  private $comments;

  public function populateUsingDatabaseMap($dbResultArray){
    $this->id            = $dbResultArray['id'];
    $this->title         = $dbResultArray['title'];
    $this->dateTime      = $dbResultArray['date'];
    $this->content       = $dbResultArray['content'];

    $this->category      = new CategoryModel();
    $this->category->populateUsingArticleDatabaseMap($dbResultArray);
  }

  public function getComments(){
    return $this->comments;
  }
  public function setComments($newComments){
    $this->comments = $newComments;
  }
  public function appendComments($newComment){
    $this->comments[] = $newComment;
  }

  public function getId(){
    return $this->id;
  }
  public function setId($newId){
    $this->id = $newId;
  }

  public function getTitle(){
    return $this->title;
  }
  public function setTitle($newTitle){
    $this->title = $newTitle;
  }

  public function getDateTime(){
    return $this->dateTime;
  }
  public function setDateTime($newDateTime){
    $this->dateTime = $newDateTime;
  }

  public function getContent(){
    return $this->content;
  }
  public function setContent($newContent){
    $this->content = $newContent;
  }

  public function getCategory(){
    return $this->category;
  }
  public function setCategory($newCategory){
    $this->category = $newCategory;
  }

  public function formatDate(){
    return date('jS M Y',strtotime($this->dateTime));
  }
  public function newDateTime(){
    $this->dateTime = date('Y-m-d H:i:s');
  }

  public function retrieveCategoryId(){
    return $this->category->getId();
  }
  public function retrieveCategoryName(){
    return $this->category->getName();
  }
  public function retrieveCategoryImage(){
    return $this->category->getImage();
  }

  public function retrieveContentSnippet(){
    if ( strlen($this->content) > 200 ){
      return trim(substr($this->content,0,200)) . '...';
    }else{
      return $this->content;
    }
  }
  public function retrieveCleanTitle(){
    $cleanTitle = str_replace('-',' ',$this->title);
    return  $cleanTitle;
  }

  public function retrieveTextAreaContent(){
    return str_replace('<br />','&#013;',$this->content);
  }

}
