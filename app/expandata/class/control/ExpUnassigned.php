<?php

Class ExpUnassigned{


  public function get($f3){


    $factory = new ClientFactory($f3);
    $clients = $factory->selectAllUnnasigned();

    $f3->set('clients',$clients);

    $f3->set('content',Template::instance()->render('expandata/clientList.html'));
    $f3->set('title','unassigned clients');
    print Template::instance()->render('/expandata/main.html');

  }

}
