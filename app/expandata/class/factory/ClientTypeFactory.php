<?php

/*
  for inserts into database
  for relating client to a type/group
*/

Class ClientTypeFactory extends ExpDatabase{


  public function selectRemaining($clientObject){
    if(!( $clientObject instanceof ClientModel )){
      //wrong object type
      return null;
    }
    try{
      // array of type ids
      $clientTypeIds = self::$db->exec(
        array(
          'SELECT type_id FROM client_type WHERE client_id = :id'
        ),
        array(
          array(
          ':id'=>$clientObject->getId()
          )
        )
      );
      if (!( $clientTypeIds )){
        $stmt = 'SELECT * FROM type';
      }else{
        $stmt = 'SELECT * FROM type WHERE ';
        foreach ($clientTypeIds as $index => $clientTypeId){
          $stmt .= ' id != ';
          $stmt .= $clientTypeId['type_id'];
          if (isset($clientTypeIds[$index + 1])){
            $stmt.= ' AND ';
          }
        }
      }

      $otherTypeRecords = self::$db->exec(array($stmt));

      $otherTypes = array();
      foreach($otherTypeRecords as $otherTypeRecord){
        $type = new TypeModel();
        $type->setId($otherTypeRecord['id']);
        $type->setName($otherTypeRecord['name']);
        $otherTypes[] = $type;
      }
      return $otherTypes;
    }catch(Exception $e){
      echo $e;
      return null;
    }
  }

  public function save($clientTypeObject){
    if(!( $clientTypeObject instanceof ClientTypeModel )){
      //wrong object type
      $result['success'] = false;
      return $result;
    }
    try{
      $clientTypeRecord = new DB\SQL\Mapper(self::$db,'client_type');
      $clientTypeRecord->client_id = $clientTypeObject->getClientId();
      $clientTypeRecord->type_id = $clientTypeObject->getTypeId();
      if( $clientTypeRecord->save() ){
          $result['success'] = true;
          //$result['clientId'] = $clientTypeRecord->id;
      } else {
          $result['success'] = false;
      }
      return $result;
    }catch(Exception $e){
      echo $e;
      return false;
    }

  }

}
