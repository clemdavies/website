<?php

Class CategoryFactory extends Database{


  public function findId($name){
    $category = new DB\SQL\Mapper(self::$db,'category');
    $category->load( array('name=?', $name) );
    var_dump($category->id);
    return $category->id;
  }


  public function selectAll(){
    try{
      $categoryArray = self::$db->exec(
            array('SELECT * FROM category WHERE id != 1')
          );

      $categoryModelArray = array();

      foreach($categoryArray as $category){
        $categoryModel = new CategoryModel();
        $categoryModel->populateUsingDatabaseMap($category);
        $categoryModelArray[] = $categoryModel;
      }
      return $categoryModelArray;
    }catch(Exception $e){
      return false;
    }
  }

  public function selectNames(){
    try{
      $nameArray = self::$db->exec(
            array('SELECT name FROM category WHERE id != 1')
          );
      $result = array();
      foreach($nameArray as $name){
        $result[] = $name['name'];
      }

      return $result;
    }catch(Exception $e){
      return false;
    }
  }


}
