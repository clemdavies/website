<?php
Class ExpNewTypeAjax{

  public function post($f3){

    //Authenticate::isAjax($f3);

    $type = new TypeModel();
    $type->setName( ExpDatabase::databaseClean( $_POST['new_type_name']) );

    $factory = new TypeFactory($f3);
    if ( $factory->save($type) ){
      //saved to db, TypeObject populated
      $result['success'] = true;
      $f3->set('type',$type);
      $result['html'] = Template::instance()->render('/expandata/typeForm.html');
    }else{
      $result['success'] = false;
    }
    header("Content-Type: application/json");
    echo json_encode($result);
  }

}
