<?php
Class ExpEditClient{

  public function get($f3){

    $id = (int)$f3->get('PARAMS.id');

    if ($id <= 0){
      $f3->set('SESSION.error','invalid client id');
      $f3->reroute('/expandata/client');
    }

    $client = new ClientModel();
    $client->setId($id);

    $factory = new ClientFactory($f3);
    if(!( $factory->selectById($client) )){
      $f3->set('error','client id '.$client->getId().' not found');
      $f3->set('title','uknown client');
      $f3->set('content',Template::instance()->render('/expandata/client.html'));
    }else{
      //populate types
      $factory = new TypeFactory($f3);
      $factory->selectByClientId( $client );
      //populate attributes
      $factory = new AttributeFactory($f3);
      $factory->selectByClientId( $client );
      $f3->set('title','EDIT '.$client->getFullName());

      $factory = new ClientTypeFactory($f3);
      $otherTypes = $factory->selectRemaining($client);
      $f3->set('otherTypes',$otherTypes);

      $factory = new AttributeFactory($f3);
      $otherAttributes = $factory->selectRemaining($client);
      $f3->set('otherAttributes',$otherAttributes);

      $f3->set('js',array('expandata/newClient'));
      $f3->set('client',$client);
      $f3->set('content',Template::instance()->render('/expandata/editClient.html'));

    }
    print Template::instance()->render('/expandata/main.html');
  }

  public function post($f3){



  }

}
