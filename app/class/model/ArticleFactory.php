<?php
Class ArticleFactory extends Database{


  protected function _count($condition){
    try{
        $article = new DB\SQL\Mapper(self::$db,'article');
        return $article->count( $condition );

    }catch(Exception $e){
        return false;
    }
  }


  /*
  public function countYear($year){
    // count articles where year = $year
    return $this->_count(array('date=?',$year));
  }

  public function countMonthYear($monthYear){
    // count articles where yearmonth = $yearmonth
    return $this->_count(array('date=?',$yearmonth));
  }

  public function countDayMonthYear($dayMonthYear){
    // count articles where yearmonthday = $yearmonthday
    return $this->_count(array('date=?',$yearmonthday));
  }
  */

  public function countByDate($date){
    return $this->_count( array('date<=?',$date) );
  }


  public function countExcludingDate($date){
    return $this->_count( array('date<?',$date) );
  }


  public function countCategory($category){
    // count articles where category = $category
    return $this->_count(array('category=?',$category));
  }

  public function countTitle($title){
    return $this->_count(array('title=?',$title));
  }

  public function countTitleWithNumber($title){
    return $this->_count(array('title REGEXP ?', '^'.$title.'[0-9]*$' ));
  }

  public function appendNumberToTitle($title){
    //either appends a 1 or next number in database

    $title = $title.'-';

    if(!( $this->countTitleWithNumber($title) )){
      $nextTitleNumber = 2;
    }else{
      $length = strlen($title) + 1;


      $regexp = '^'.$title.'[0-9]*$';


      $titleResultArray = self::$db->exec(
              array('SELECT substring(title,:length) as number FROM article WHERE title REGEXP \''.$regexp.'\''),
              array(  array(':length'=>$length)  )
            );

      $maxTitleNumber = 0;
      foreach($titleResultArray as $titleResult){

        $titleResultNumber = (int)$titleResult['number'];

        if( $titleResultNumber > $maxTitleNumber ){
          $maxTitleNumber = $titleResultNumber;
        }

      }
      $nextTitleNumber = $maxTitleNumber + 1;
    }
    $titleWithNumber = $title.$nextTitleNumber;

    return $titleWithNumber;
  }



  public function cleanTitle($title){
    $cleanTitle = $this->removeWhitespace($title);
    if($this->countTitle($cleanTitle) > 0){
      // title exists
      $cleanTitle = $this->appendNumberToTitle($cleanTitle);
    }

    return $cleanTitle;
  }

  public function removeWhitespace($string){
    $newString = preg_replace("/\s+/", "-", trim($string));
    return $newString;
  }


  /* int $date - DDMMYYY
     int $count
     int $startId

     queries database for articles given a date and count.
     returns an array of ArticleModel objects or false.
     always traverses forward in ID number, backward in time.
  */
  public function selectFromDate($date, $count, $id = 0){

    /*
       SELECT id,category_id,title,date FROM article WHERE DATE(date) <= '20130629' ORDER BY date DESC LIMIT 5;

       SELECT * FROM article as a,category as c WHERE a.date<='2013-06-27 22:54:28' AND a.category_id = c.id ORDER BY a.date DESC LIMIT 5;

    */

    try{

      //$article = new DB\SQL\Mapper(self::$db,'article');




      /*
        DO I EVER USE THE CATEGORY ID WHICH IS PART OF THE MODEL OBJECT BUT NOT PULLED FROM THE DB OR USED IN PHP PROCESSING.!!!!!!!!!!!!!!!!!!!!!!!!!!
      */

      if ($id > 0){

        $articlesArray = self::$db->exec(
            array('SELECT a.id,a.category_id,a.title,a.content,a.date,c.name as category_name,c.image_filename as category_image_filename '.
                  'FROM article as a,category as c '.
                  'WHERE a.date<:date AND a.id < :id AND a.category_id = c.id '.
                  'ORDER BY a.date DESC LIMIT :count'),
            array(  array(':date'=>$date, ':id'=>$id,':count'=>$count )  )
          );


        $articleModelArray = array();
        foreach($articlesArray as $articleMap){

          $object = new ArticleModel();
          $object->populateUsingDatabaseMap($articleMap);
          $articleModelArray[] = $object;
        }
        return $articleModelArray;
      } else {
        //traversing forward from date

        $articlesArray = self::$db->exec(
            array('SELECT a.id,a.category_id,a.title,a.content,a.date,c.name as category_name,c.image_filename as category_image_filename '.
                  'FROM article as a,category as c '.
                  'WHERE a.date<=:date AND a.category_id = c.id '.
                  'ORDER BY a.date DESC LIMIT :count'),
            array(  array(':date'=>$date,':count'=>$count)  )
          );

        $articleModelArray = array();
        foreach($articlesArray as $articleMap){

          $object = new ArticleModel();
          $object->populateUsingDatabaseMap($articleMap);
          $articleModelArray[] = $object;
        }
        return $articleModelArray;

      }


    }catch(Exception $e){
      return $e;
    }
  }

  /* int $date - DDMMYYY
     int $count
     int $startId

     queries database for articles given a date and count.
     returns an array of ArticleModel objects or false.
     always traverses forward in ID number, backward in time.
  */
  public function selectByDate($date, $count, $startId = -1){

    try{
        $article = new DB\SQL\Mapper(self::$db,'article');
      if ($startId > -1){
        //traversing forward
        $article->exec(array('date=? and id >= ?',$date,$startId));
      }else{
        //traversing forward from latest
        $article->exec(array('date=?',$date));

        // select * from article where date = date limit

      }
    }catch(Exception $e){
        return false;
    }
  }

  /* int $date - DDMMYYY
     int $count
     int $startId

     queries database for articles given a date and count.
     returns an array of ArticleModel objects or false.
     always traverses forward in ID number, backward in time.
  */
  public function selectByTitle($title){

    try{

      $article = self::$db->exec(
            array('SELECT a.id,a.category_id,a.title,a.content,a.date,c.name as category_name,c.image_filename as category_image_filename '.
                  'FROM article as a,category as c '.
                  'WHERE a.title=:title AND a.category_id = c.id '),
            array(  array(':title'=>$title)  )
          );
      $articleModel = new ArticleModel();
      $articleModel->populateUsingDatabaseMap($article[0]);
      return $articleModel;
    }catch(Exception $e){
      return false;
    }
  }


  /*
  */
  public function selectById($id){
    try{

      $article = self::$db->exec(
            array('SELECT a.id,a.category_id,a.title,a.content,a.date,c.name as category_name,c.image_filename as category_image_filename '.
                  'FROM article as a,category as c '.
                  'WHERE a.id = :id AND a.category_id = c.id '),
            array(  array(':id'=>$id)  )
          );
      $articleModel = new ArticleModel();
      $articleModel->populateUsingDatabaseMap($article[0]);
      return $articleModel;
    }catch(Exception $e){
      return false;
    }
  }

  public function selectTitleById($id){
    try{
      $article = self::$db->exec(
            array('SELECT a.id,a.category_id,a.title,a.content,a.date,c.name as category_name,c.image_filename as category_image_filename '.
                  'FROM article as a,category as c '.
                  'WHERE a.id = :id  AND a.category_id = c.id '),
            array(  array(':id'=>$id)  )
          );
      $articleModel = new ArticleModel();
      $articleModel->populateUsingDatabaseMap($article[0]);
      return $articleModel;
    }catch(Exception $e){
      echo $e;
      return false;
    }
  }


  /* string $category
     int $count       - Number of article objects to return.
     int $startId

     queries database for articles given a date and count.
     returns an array of ArticleModel objects or false.
     always traverses forward in ID number, backward in time.
  */
  public function selectByCategory($category, $count, $startId = -1){

    if ($startId > -1){
      //traversing forward

    }else{
      //traversing forward from latest

    }
  }


  public function updateArticle($id,$categoryId,$title,$content){
    $article = new DB\SQL\Mapper(self::$db,'article');
    $article->load(array('id=?',$id));
    $article->id=$id;
    $article->category_id=$categoryId;
    $article->title=$title;
    $article->content=$content;
    if( $article->save() ){
        return true;
    } else {
        return false;
    }
  }


  public function deleteArticle($id){
    try{
      $article = new DB\SQL\Mapper(self::$db,'article');
      $article->load(array('id=?',$id));

      $article->erase();

      if (!( $this->selectById($id) )){
        return true;
      }
      return false;
    }catch(Exception $e){
      return false;
    }
  }


  /* ArticleModel $articleObject - article to save.

     Saves articleObject to database.
     Returns true on success, false otherwise.
  */
  public function save($articleObject){
    if(!( $articleObject instanceof ArticleModel )){
      //wrong object type
      return false;
    }

    $article = new DB\SQL\Mapper(self::$db,'article');
    $article->title       = $articleObject->getTitle();
    $article->category_id = $articleObject->retrieveCategoryId();
    $article->content     = $articleObject->getContent();
    $article->date        = $articleObject->getDateTime();
    if( $article->save() ){
        return true;
    } else {
        return false;
    }
  }



}
