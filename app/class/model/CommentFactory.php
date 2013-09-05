<?php

Class CommentFactory extends Database{


  private $maxComments = 5;

  public function findByArticleId($articleId){

    $commentArray = self::$db->exec(
        array('SELECT c.id,c.article_id,c.name,c.content,c.date,c.seen '.
              'FROM comment as c,article as a '.
              'WHERE c.article_id = a.id '.
              'ORDER BY c.date DESC LIMIT :count'),
        array(  array(':date'=>$date, ':id'=>$id,':count'=>$maxComments )  )
      );

    $commentModelArray = array();
    foreach($commentArray as $commentMap){

      $comment = new CommentModel();
      $comment->populateUsingDatabaseMap($commentMap);
      $commentArray[] = $comment;
    }
    return $commentModelArray;
  }



  public function deleteComment($id){
    try{
      $comment = new DB\SQL\Mapper(self::$db,'comment');
      $comment->load(array('id=?',$id));

      $comment->erase();

      if (!( $this->selectById($id) )){
        return true;
      }
      return false;
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

    $comment = new DB\SQL\Mapper(self::$db,'comment');
    $comment->article_id  = $commentObject->getArticleId();
    $comment->name        = $commentObject->getName();
    $comment->content     = $commentObject->getContent();
    $comment->date        = $commentObject->getDate();
    $comment->seen        = $commentObject->getSeen();
    if( $comment->save() ){
        return true;
    } else {
        return false;
    }
  }


}
