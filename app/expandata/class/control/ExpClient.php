<?php
Class ExpClient{

  public function get($f3){

    if ($f3->get('SESSION.error')){
       $f3->set('error',$f3->get('SESSION.error'));
       $f3->clear('SESSION.error');
    }

    $factory = new ClientFactory($f3);
    $clients = $factory->selectAll();

    if (count($clients)){
      $factory = new TypeFactory($f3);
      foreach($clients as $client){
        $factory->selectByClientId( $client );
      }
    }
    $f3->set('clients',$clients);

    $f3->set('content',Template::instance()->render('expandata/clientList.html'));
    $f3->set('title','clients');
    print Template::instance()->render('/expandata/main.html');
  }

}
