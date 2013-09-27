<?php
Class ExpNewClient{

  public function get($f3){
    //retrieve form

    $factory = new TypeFactory($f3);
    $f3->set( 'types' , $factory->selectAll() );

    // stores arrays of AtrributeModel
    $factory = new AttributeFactory($f3);
    $f3->set( 'boolAttributes'   , $factory->selectAllOfType( 'bool_attribute'   ) );
    $f3->set( 'stringAttributes' , $factory->selectAllOfType( 'string_attribute' ) );

    $f3->set('content',Template::instance()->render('/expandata/newClient.html'));
    $f3->set('title','new client');
    $f3->set('js',array('expandata/newClient'));
    print Template::instance()->render('/expandata/main.html');
  }

  public function post($f3){
    //process form

    $client = new ClientModel();

    $name = new NameModel();
    $name->setTitle($_POST['title']);
    $name->setFirst($_POST['first_name']);
    $name->setLast($_POST['last_name']);

    $client->setName($name);

    $contact = new ContactModel();
    $contact->setHome($_POST['home']);
    $contact->setWork($_POST['work']);
    $contact->setMobile($_POST['mobile']);
    $contact->setFax($_POST['fax']);
    $contact->setEmail($_POST['email']);

    $client->setContact($contact);

    $streetAddress  = new AddressModel();
    $streetPostcode = new PostcodeModel();
    $streetSuburb   = new SuburbModel();
    $this->populateAddressModel($streetAddress,$streetPostcode,$streetSuburb,'street_');

    $postalAddress  = new AddressModel();
    $postalPostcode = new PostcodeModel();
    $postalSuburb   = new SuburbModel();
    $this->populateAddressModel($postalAddress,$postalPostcode,$postalSuburb,'postal_');

    // compares attributes and values
    if ($postalAddress == $streetAddress){
      // assign same reference to both objects to ensure identical mysql storage + free memory
      $postalAddress = $streetAddress;
    }

    $client->setStreetAddress($streetAddress);
    $client->setPostalAddress($postalAddress);

    // ClientModel object is populated



    $factory = new ClientFactory($f3);
    $result = $factory->save($client);

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
