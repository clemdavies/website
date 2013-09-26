<?php

Class ExpNewProperty{

  public function get($f3){

    /*
    $factory = new StyleFactory($f3);
    $f3->set( 'styles' , $factory->selectAll() );

    $factory = new TypeFactory($f3);
    $f3->set( 'types' , $factory->selectAll() );

    $factory = new ZoneFactory($f3);
    $f3->set( 'zones' , $factory->selectAll() );
    */


    /*
    $factory = new FeatureFactory($f3);
    $f3->set( 'features' , $factory->selectAll() );
    */

    $f3->set('content',Template::instance()->render('/expandata/newProperty.html'));
    $f3->set('title','new property');
    //$f3->set('js',array('expandata/newClient'));
    print Template::instance()->render('/expandata/main.html');


  }

  public function post($f3){


  }


}
