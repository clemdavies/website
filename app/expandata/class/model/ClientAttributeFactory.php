<?php

Class ClientAttributeFactory extends ExpDatabase{

  public function save($attributeObject){
    if ( $attributeObject instanceof BoolAttributeModel ){
      $stmt = 'INSERT INTO bool_attribute (client_id,attribute_id,value) VALUES(:client_id,:attribute_id,:value)';
    }else if( $attributeObject instanceof StringAttributeModel ){
      $stmt = 'INSERT INTO string_attribute (client_id,attribute_id,value) VALUES(:client_id,:attribute_id,:value)';
    }else{
      echo 'wrong model type';
      return false;
    }
    try{
      $result = self::$db->exec(
          array( $stmt ),
          array(
            array(
                   ':client_id'    => $attributeObject->getClientId(),
                   ':attribute_id' => $attributeObject->getId(),
                   ':value'        => $attributeObject->getValue()
            )
          )
        );
      if ( $result ){
        return true;
      }else{
        return false;
      }
    }catch(Exception $e){
      echo $e;
      return false;
    }
  }
}
