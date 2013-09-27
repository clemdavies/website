<?php
Class TypeFactory extends ExpDatabase{



  public function selectByClientId($clientObject){
    if(!( $clientObject instanceof ClientModel )){
      //wrong object type
      return false;
    }
    try{

      $typeRecordArray = self::$db->exec(
          array(
            'SELECT t.id,t.name '.
            'FROM client_type AS ct, type AS t '.
            'WHERE ct.type_id = t.id AND ct.client_id = :client_id '
          ),
          array(
            array( ':client_id' => $clientObject->getId() )
          )
        );

      foreach($typeRecordArray as $typeRecord){
        $typeObject = new TypeModel();
        $typeObject->setId($typeRecord['id']);
        $typeObject->setName($typeRecord['name']);
        $clientObject->newType($typeObject);
      }
    }catch(Exception $e){
      echo $e;
      return false;
    }

  }

  public function selectAll(){

    try{

      $typeRecordArray = self::$db->exec(array('select * from type'));

      $typeArray = array();

      foreach($typeRecordArray as $typeRecord){
        $type = new TypeModel();
        $type->setId($typeRecord['id']);
        $type->setName($typeRecord['name']);
        $typeArray[] = $type;
      }
      if (count($typeArray)){
        return $typeArray;
      }
      return null;
    }catch(Exception $e){
      echo $e;
      return null;
    }
  }

  public function findByName($typeObject){
    if (!( $typeObject instanceof TypeModel )){
      return false;
    }
    try{
      $typeRecord = new DB\SQL\Mapper(self::$db,'type');
      $typeRecord->load(array('name=?',$typeObject->getName() ));
      $typeObject->setId($typeRecord->id);
    }catch(Exception $e){
      echo $e;
      return false;
    }
  }

  public function save($typeObject){
    if(!( $typeObject instanceof TypeModel )){
      //wrong object type
      return false;
    }
    try{
      $typeRecord = new DB\SQL\Mapper(self::$db,'type');
      $typeRecord->name = $typeObject->getName();
      if( $typeRecord->save() ){
        $typeObject->setId($typeRecord->id);
        return true;
      } else {
        return false;
      }
    }catch(Exception $e){
      return false;
    }
  }

}
