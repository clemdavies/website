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
    //process form



    $client = new ClientModel();
    $client->setId($f3->get('PARAMS.id'));
    $factory = new ClientFactory($f3);

    $factory->selectById($client);

    var_dump($client);

    $name = $client->getName();
    $name->setTitle($_POST['title']);
    $name->setFirst($_POST['first_name']);
    $name->setLast($_POST['last_name']);

    $contact = $client->getContact();
    $contact->setHome($_POST['home']);
    $contact->setWork($_POST['work']);
    $contact->setMobile($_POST['mobile']);
    $contact->setFax($_POST['fax']);
    $contact->setEmail($_POST['email']);


    $newStreetAddress  = new AddressModel();
    $newStreetPostcode = new PostcodeModel();
    $newStreetSuburb   = new SuburbModel();
    $this->populateAddressModel($newStreetAddress,$newStreetPostcode,$newStreetSuburb,'street_');

    $newPostalAddress  = new AddressModel();
    $newPostalPostcode = new PostcodeModel();
    $newPostalSuburb   = new SuburbModel();
    $this->populateAddressModel($newPostalAddress,$newPostalPostcode,$newPostalSuburb,'postal_');


    if ($client->getPostalAddress()->getPostcode() ){

    }












    if ($client->getPostalAddress() === $client->getStreetAddress()){
      // same object :. same record
      if ($newPostalAddress == $newStreetAddress){
        // i can safely update the current client postalAddress object once as it will also update the streetAddress.
        $newPostalAddress->setId($client->getPostalAddress()->getId());
        $client->setPostalAddress($newPostalAddress);
        $client->setStreetAddress($newPostalAddress);
      }else{
        // destroy client streetaddress and recreate
        $client->setStreetAddress($newStreetAddress); // no id
      }
    }else{
      // NOT same object :. two separate records

      if ($newPostalAddress == $newStreetAddress){
        // delete a record, they are now the same
        // use postal address id && delete street address id record
        $newPostalAddress->setId($client->getPostalAddress()->getId());
        $newStreetAddress->setId($client->getPostalAddress()->getId());

        $client->setPostalAddress($newPostalAddress);
        $client->setStreetAddress($newStreetAddress);

      }else{
        // update both records

        $newPostalAddress->setId($client->getPostalAddress()->getId());
        $client->setPostalAddress($newPostalAddress);

        $newStreetAddress->setId($client->getStreetAddress()->getId());
        $client->setStreetAddress($newStreetAddress);
      }

    }

    var_dump($client);
    exit;

    // ClientModel object is populated



    $factory = new ClientFactory($f3);
    $result = $factory->update($client);

    if (!( $result['success'] )){
      //$f3->reroute('/expandata/new/client');
      var_dump($result);
      var_dump(ExpDatabase::$db->log());
      exit;
    }

    //client is saved
    // are there any types for this client?

    // not as process intensive, but must be better way... maybe
    // use post to query available types????

    $factory = new TypeFactory($f3);
    $types = $factory->selectAll();
    $factory = new ClientTypeFactory($f3);
    foreach($types as $type){
      if ( isset( $_POST[$type->getName()] ) ){
        //type found for client

        $clientType = new ClientTypeModel();
        $clientType->setClientId($client->getId());
        $clientType->setTypeId($type->getId());
        $factory->save($clientType);
      }
    }
    //client types are saved

    // are there any attributes?
    // selects ALL attributes
    // loops over every attribute
    // matches attribute name to post['name']

    // very ugly, process intensive : must be a better way!
    // use post to query available attributes????

    $factory = new AttributeFactory($f3);
    $attributes = $factory->selectAll();



    $factory = new ClientAttributeFactory($f3);
    $result = array();
    foreach($attributes as $attribute){

      if (isset($_POST[$attribute->getName()])){
        $attribute->setClientId($client->getId());
        $attribute->setValue($_POST[$attribute->getName().'_value']);
        $result[] = $factory->save($attribute);
      }
    }
    //attributes are saved

    // reroute to view this client
    $f3->reroute('/expandata/client/' . $client->getId());
  }

  private function populateAddressModel($address,$postcode,$suburb,$type){
      if (!( $address instanceof AddressModel   ) ||
          !( $postcode instanceof PostcodeModel ) ||
          !( $suburb instanceof SuburbModel     ) ||
          !( is_string($type)                   ) ) {
        return false;
      }

      $postcode->setNumber($_POST[$type.'postcode']);
      $address->setPostcode($postcode);

      $suburb->setName($_POST[$type.'suburb']);
      $suburb->setPostcode($postcode);
      $address->setSuburb($suburb);

      $address->setUnitNumber($_POST[$type.'unit_number']);
      $address->setStreetNumber($_POST[$type.'street_number']);
      $address->setStreetName($_POST[$type.'street_name']);
      $address->setCity($_POST[$type.'city']);
      $address->setState($_POST[$type.'state']);
    }

}
