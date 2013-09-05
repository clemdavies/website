<?php
Class ReadCategory{


  public function get($f3){
    Authenticate::isAdmin($f3);
    Authenticate::isAjax($f3);

    // returns all category image paths, ids and names to client.

    $factory = new CategoryFactory($f3);
    $objects = $factory->selectAll();

    $f3->set('categories',$objects);
    $result['category'] = Template::instance()->render('/admin/categorySelection.html');

    echo json_encode($result);
  }

}
