<?php

Class ExpNewAttributeAjax{

  public function post($f3){

    //Authorize::isAuthorized();

    // insert based on whether bool || short || long

    $attribute = new AttributeModel();
    $attribute->setName( ExpDatabase::databaseClean($_POST['new_attribute_name']) );
    $attribute->setType( $_POST['new_attribute_type'] );
    $factory = new AttributeFactory($f3);
    if( $factory->save( $attribute ) ){
      $result['success'] = true;
      $f3->set('attribute',$attribute);
      $result['dataType'] = $attribute->getType();
      $result['html'] = Template::instance()->render('/expandata/attributeForm.html');
    }else{
      $result['success'] = false;
    }

    header('Content-Type: application/json');
    echo json_encode($result);
  }

}
