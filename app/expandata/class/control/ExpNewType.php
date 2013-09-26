<?php
Class ExpNewType{

  public function get($f3){
    $factory = new TypeFactory($f3);

    $f3->set('types',$factory->selectAll());
    $f3->set('title','new type');

    $f3->set('content',Template::instance()->render('/expandata/newType.html'));
    print Template::instance()->render('/expandata/main.html');


  }

  public function post($f3){

    $type = new TypeModel();
    $type->setName( ExpDatabase::databaseClean($_POST['name']) );

    $factory = new TypeFactory($f3);
    $factory->save($type);

    $f3->reroute('/expandata/new/type');

  }

}
