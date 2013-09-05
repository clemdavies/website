<?php

Class NewCategory{

  public function get($f3){

    Authenticate::isAdmin($f3);
    //Authenticate::isAjax($f3);

    // returns all category image paths, ids and names to client.

    $factory = new CategoryFactory($f3);
    $data['existingNames'] = $factory->selectNames();
    $data['form'] = Template::instance()->render('/admin/categoryOverlay.html');


    if ( $data['existingNames'] && $data['form'] ){
      $data['success'] = true;
    }

    echo json_encode($data);
  }

  public function post($f3){

    //Authenticate::isAdmin($f3);
    //Authenticate::isAjax($f3);

    error_reporting(E_ALL | E_STRICT);
    new UploadHandler();
  }


}
