<?php

Class ExpNewZone{

  public function get($f3){
    //$factory = new ZoneFactory($f3);


    //$f3->set('zones',$factory->selectAll());
    $f3->set('zones',array());
    $f3->set('title','new zone');

    $f3->set('content',Template::instance()->render('/expandata/newZone.html'));
    print Template::instance()->render('/expandata/main.html');


  }

  public function post($f3){

    $zone = new ZoneModel();
    $zone->setName( ExpDatabase::databaseClean($_POST['name']) );

    $factory = new ZoneFactory($f3);
    $factory->save($zone);

    $f3->reroute('/expandata/new/property/zone');

  }
}
