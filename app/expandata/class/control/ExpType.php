<?php

Class ExpType{

  public function get($f3){

    $param = $f3->get('PARAMS.type');
    $factory = new TypeFactory($f3);
    $type = new TypeModel();
    $type->setName($param);
    $factory->findByName($type);

    $factory = new ClientFactory($f3);

    if (!( $type->getId() )){
    // invalid params.type
      $f3->set( 'SESSION.error','invalid type' );
      $f3->reroute( '/expandata/clients' );
    }
    $clients = $factory->selectAllByType( $type );
    if ($clients){
    // clients created :. find their types
      $factory = new TypeFactory($f3);
      foreach($clients as $client){
        $factory->selectByClientId( $client );
      }
    }

    $f3->set('clients',$clients);

    $f3->set('content',Template::instance()->render('expandata/clientList.html'));
    $f3->set('title',$param);
    print Template::instance()->render('/expandata/main.html');
  }



}
