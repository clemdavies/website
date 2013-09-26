<?php

Class AttributeFactory extends ExpDatabase{

  public function selectAll(){
    try{

      $attributeRecordArray = self::$db->exec(array('SELECT * FROM attribute'));

      $attributeArray = array();
      foreach($attributeRecordArray as $attributeRecord){
        if ($attributeRecord['type'] == 'bool_attribute'){
          $attribute = new BoolAttributeModel();
        }else{
          $attribute = new StringAttributeModel();
        }
        $attribute->setId($attributeRecord['id']);
        $attribute->setName($attributeRecord['name']);
        $attribute->setType($attributeRecord['type']);
        $attributeArray[] = $attribute;
      }
      return $attributeArray;
    }catch(Exception $e){
      echo $e;
      return false;
    }
  }

  public function selectAllOfType($type){
    try{
      $attributeRecordArray = self::$db->exec(
          array('SELECT * FROM attribute WHERE type = :type'),
          array(
            array( ':type' => $type )
          )
      );

      $attributeArray = array();
      foreach($attributeRecordArray as $attributeRecord){
        $attribute = new AttributeModel();
        $attribute->setId($attributeRecord['id']);
        $attribute->setName($attributeRecord['name']);
        $attribute->setType($attributeRecord['type']);
        $attributeArray[] = $attribute;
      }
      return $attributeArray;
    }catch(Exception $e){
      echo $e;
      return false;
    }
  }

  public function selectRemaining($clientObject){
    if(!( $clientObject instanceof ClientModel )){
      //wrong object type
      return null;
    }
    try{
      // BOOL
      $boolRecords = self::$db->exec(
          array(
            'SELECT attribute_id FROM bool_attribute WHERE client_id = :client_id'
          ),
          array(
            array( ':client_id' => $clientObject->getId() )
          )
        );
      // STRING
      $stringRecords = self::$db->exec(
          array(
            'SELECT attribute_id FROM string_attribute WHERE client_id = :client_id'
          ),
          array(
            array( ':client_id' => $clientObject->getId() )
          )
        );
      $stringBoolRecords = array_merge($boolRecords,$stringRecords);


      $stmt = 'SELECT * FROM attribute WHERE ';

      foreach($stringBoolRecords as $index => $stringBoolRecord){
        $stmt .= ' id != ' . $stringBoolRecord['attribute_id'];

        if ( isset($stringBoolRecords[$index + 1]) ){
          $stmt.= ' AND ';
        }
      }
      $attributeRecords = self::$db->exec(array($stmt));

      $attributes = array();
      foreach($attributeRecords as $attributeRecord){
        $attribute = new AttributeModel();
        $attribute->setId($attributeRecord['id']);
        $attribute->setName($attributeRecord['name']);
        $attribute->setType($attributeRecord['type']);
        $attributes[] = $attribute;

      }
      return $attributes;
    }catch(Exception $e){
      echo $e;
      return null;
    }
  }



  public function selectByClientId($clientObject){
    if (!( $clientObject instanceof ClientModel )){
      return false;
    }
    try{
      // BOOL
      $boolRecords = self::$db->exec(
          array(
            'SELECT b.client_id, b.value, a.name, a.type '.
            'FROM client as c, bool_attribute as b, attribute as a '.
            'WHERE c.id = b.client_id AND b.attribute_id = a.id AND c.id = :client_id'
          ),
          array(
            array( ':client_id' => $clientObject->getId() )
          )
        );
      // STRING
      $stringRecords = self::$db->exec(
          array(
            'SELECT s.client_id, s.value, a.name, a.type '.
            'FROM client as c, string_attribute as s, attribute as a '.
            'WHERE c.id = s.client_id AND s.attribute_id = a.id AND c.id = :client_id'
          ),
          array(
            array( ':client_id' => $clientObject->getId() )
          )
        );
      //var_dump($attributeRecords);
      //$attributeRecords = array_merge($boolRecords,$stringRecords);

      foreach($boolRecords as $boolRecord){
        $boolAttributeObject = new BoolAttributeModel();
        $boolAttributeObject->setClientId($boolRecord['client_id']);
        $boolAttributeObject->setName($boolRecord['name']);
        $boolAttributeObject->setValue($boolRecord['value']);
        $boolAttributeObject->setType($boolRecord['type']);


        $clientObject->newAttribute($boolAttributeObject);
      }

      foreach($stringRecords as $stringRecord){
        $stringAttributeObject = new StringAttributeModel();
        $stringAttributeObject->setClientId($stringRecord['client_id']);
        $stringAttributeObject->setName($stringRecord['name']);
        $stringAttributeObject->setValue($stringRecord['value']);
        $stringAttributeObject->setType($stringRecord['type']);
        $clientObject->newAttribute($stringAttributeObject);
      }

    }catch(Exception $e){

    }
  }

  public function findByNameAndType($attributeObject){
    if (!( $attributeObject instanceof AttributeModel )){
      return false;
    }
    try{

      $attributeRecord = new DB\SQL\Mapper(self::$db,'attribute');
      $attributeRecord->load(array('name=? AND type=?',$attributeObject->getName(), $attributeObject->getType() ));
      $attributeObject->setId($attributeRecord->id);
      return true;
    }catch(Exception $e){
      return false;
    }
  }


  public function save($attributeObject){
    if (!( $attributeObject instanceof AttributeModel )){
      return false;
    }
    try{
      /*
        enum column doesn't play with mapper object :. db->exec
      */
      $result = self::$db->exec(
          array(
            'INSERT INTO attribute (name,type) VALUES (:name,:type)'
          ),
          array(
            array( ':name' => $attributeObject->getName(),
                   ':type' => $attributeObject->getType()
            )
          )
        );

      if ( $this->findByNameAndType($attributeObject) ){
        return true;
      }else{
        return false;
      }
    }catch(Exception $e){
      return false;
    }
  }

}
