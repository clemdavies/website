<?php

Class CommentFactory extends Database{


  private $maxComments = 500;

  public function findByArticleId($articleId){
    try{
      $commentArray = Database::$db->exec(
          array('SELECT id,article_id,name,content,date,seen '.
                'FROM comment '.
                'WHERE article_id = :id '.
                'ORDER BY date DESC LIMIT :count'),
          array(  array(':id'=>$articleId,':count'=>500 )  )
        );

      $commentModelArray = array();
      foreach($commentArray as $commentMap){

        $comment = new CommentModel();
        $comment->populateUsingDatabaseMap($commentMap);
        $commentModelArray[] = $comment;
      }
      return $commentModelArray;
    }catch(Exception $e){
      return false;
    }
  }

  public function allUnseenComments(){
    try{
      $commentArray = Database::$db->exec(
          array('SELECT id,article_id,name,content,date,seen '.
                'FROM comment WHERE seen = :seen ORDER BY date DESC'),
          array( array( ':seen'=>'0' ))
      );

      $commentModelArray = array();
      foreach($commentArray as $commentMap){
        $comment = new CommentModel();
        $comment->populateUsingDatabaseMap($commentMap);
        $commentModelArray[] = $comment;
      }
      return $commentModelArray;
    }catch(Exception $e){
      return false;
    }
  }


  public function markAsSeen($commentObject){
    if(!( $commentObject instanceof CommentModel )){
      //wrong object type
      return false;
    }
    try{

      $comment = new DB\SQL\Mapper(Database::$db,'comment');
      $comment->load( array('id=?',$commentObject->getId()) );
      $comment->seen = 1;
      $comment->save();

      if ($comment->seen == 0){
        return false;
      }
      return true;
    } catch(Exception $e) {
      return false;
    }

  }


  public function selectById($id){
    try{
      $comment = new DB\SQL\Mapper(Database::$db,'comment');
      $comment->load( array('id=?',$id) );
      if ($comment->dry() ){
        return false;
      }
      return true;
    } catch(Exception $e) {
      return false;
    }
  }


  public function delete($commentObject){
    if(!( $commentObject instanceof CommentModel )){
      //wrong object type
      return false;
    }
    try{
      $comment = new DB\SQL\Mapper(Database::$db,'comment');
      $comment->load(array('id=?',$commentObject->getId()));

      $comment->erase();

      if ( $this->selectById($commentObject->getId()) ){
        return false;
      }
      return true;
    }catch(Exception $e){
      return false;
    }
  }


  /* CommentModel $commentObject - comment to save.

     Saves commentObject to database.
     Returns true on success, false otherwise.
  */
  public function save($commentObject){
    if(!( $commentObject instanceof CommentModel )){
      //wrong object type
      return false;
    }

    $comment = new DB\SQL\Mapper(Database::$db,'comment');
    $comment->article_id  = $commentObject->getArticleId();
    $comment->name        = $commentObject->getName();
    $comment->content     = $commentObject->getContent();
    $comment->date        = $commentObject->getDateTime();
    $comment->seen        = $commentObject->getSeen();
    if( $comment->save() ){
      $commentObject->setId($comment->id);
      return true;
    } else {
        return false;
    }
  }


}
