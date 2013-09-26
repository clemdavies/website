<?php

Class ExpNewAttribute{

  public function get($f3){

    /*
      checkboxes for bool || short || long
      text field for name
    */
    $factory = new AttributeFactory($f3);

    $f3->set('attributes',$factory->selectAll());
    //$f3->set('boolAttributes',);
    //$f3->set('shortAttributes',);
    //$f3->set('longAttributes',);
    $f3->set('title','new attribute');

    $f3->set('content',Template::instance()->render('expandata/newAttribute.html'));
    print Template::instance()->render('/expandata/main.html');
  }

  public function post($f3){
    // insert based on whether bool || short || long

    $attribute = new AttributeModel();
    $attribute->setName( ExpDatabase::databaseClean($_POST['name']) );
    $attribute->setType($_POST['type']);
    $factory = new AttributeFactory($f3);
    $factory->save($attribute);

    $f3->reroute('/expandata/new/client/attribute');

  }

}
