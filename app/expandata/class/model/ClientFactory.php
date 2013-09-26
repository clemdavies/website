<?php
Class ClientFactory extends ExpDatabase{


  public function selectById($client){
    if(!( $client instanceof ClientModel )){
      //wrong object type
      $result['success'] = false;
      return $result;
    }
    try{
      /*
        SELECT client.id AS 'client_id',
               client.name_id AS 'client_name_id',
               client.contact_id AS 'client_contact_id',
               client.street_address_id AS 'client_street_address_id',
               client.postal_address_id AS 'client_postal_address_id',
               name.id AS 'name_id',
               name.title AS 'name_title',
               name.first AS 'name_first',
               name.last AS 'name_last',

               contact.id AS 'contact_',
               contact.home AS 'contact_home',
               contact.work AS 'contact_work',
               contact.mobile AS 'contact_mobile',
               contact.fax AS 'contact_fax',
               contact.email AS 'contact_email',

               pa.id AS 'postal_address_id',

               papo.id AS 'postal_address_postcode_number',
               pasu.id AS 'postal_address_suburb_name',

               pa.unit_number AS 'postal_address_unit_number',
               pa.street_number AS 'postal_address_street_number',
               pa.street_name AS 'postal_address_street_name',
               pa.city AS 'postal_address_city',
               pa.state AS 'postal_address_state',

               sa.id AS 'street_address_id',

               sapo.id AS 'street_address_postcode_number',
               sasu.id AS 'street_address_suburb_name',

               sa.unit_number AS 'street_address_unit_number',
               sa.street_number AS 'street_address_street_number',
               sa.street_name AS 'street_address_street_name',
               sa.city AS 'street_address_city',
               sa.state AS 'street_address_state'

               FROM client, name, contact, address AS pa, postcode AS papo, suburb AS pasu, address AS sa, postcode AS sapo, suburb AS sasu
               WHERE client.name_id = name.id AND
                     client.contact_id = contact.id AND
                     client.postal_address_id = pa.id AND
                     pa.postcode_id = papo.id AND
                     pa.suburb_id = pasu.id AND
                     client.street_address_id = sa.id AND
                     sa.postcode_id = sapo.id AND
                     sa.suburb_id = sasu.id AND
                     client.id = :clientId;


      */

      $clientRecordArray = self::$db->exec(array(
        "SELECT client.id AS 'client_id',
               client.name_id AS 'client_name_id',
               client.contact_id AS 'client_contact_id',
               client.street_address_id AS 'client_street_address_id',
               client.postal_address_id AS 'client_postal_address_id',

               name.id AS 'name_id',
               name.title AS 'name_title',
               name.first AS 'name_first',
               name.last AS 'name_last',

               contact.id AS 'contact_id',
               contact.home AS 'contact_home',
               contact.work AS 'contact_work',
               contact.mobile AS 'contact_mobile',
               contact.fax AS 'contact_fax',
               contact.email AS 'contact_email',

               pa.id AS 'postal_address_id',

               papo.id AS 'postal_address_postcode_id',
               papo.number AS 'postal_address_postcode_number',

               pasu.id AS 'postal_address_suburb_id',
               pasu.name AS 'postal_address_suburb_name',

               pa.unit_number AS 'postal_address_unit_number',
               pa.street_number AS 'postal_address_street_number',
               pa.street_name AS 'postal_address_street_name',
               pa.city AS 'postal_address_city',
               pa.state AS 'postal_address_state',

               sa.id AS 'street_address_id',

               sapo.id AS 'street_address_postcode_id',
               sapo.number AS 'street_address_postcode_number',

               sasu.id AS 'street_address_suburb_id',
               sasu.name AS 'street_address_suburb_name',

               sa.unit_number AS 'street_address_unit_number',
               sa.street_number AS 'street_address_street_number',
               sa.street_name AS 'street_address_street_name',
               sa.city AS 'street_address_city',
               sa.state AS 'street_address_state'

               FROM client, name, contact, address AS pa, postcode AS papo, suburb AS pasu, address AS sa, postcode AS sapo, suburb AS sasu
               WHERE client.name_id = name.id AND
                     client.contact_id = contact.id AND
                     client.postal_address_id = pa.id AND
                     pa.postcode_id = papo.id AND
                     pa.suburb_id = pasu.id AND
                     client.street_address_id = sa.id AND
                     sa.postcode_id = sapo.id AND
                     sa.suburb_id = sasu.id AND
                     client.id = :clientId;")
        ,array(array(':clientId'=>$client->getId() )));

      if (!( count($clientRecordArray) )){
        return false;
      }
      $clientRecord = $clientRecordArray[0];

      // Name Object
      $name = new NameModel();
      $name->setId($clientRecord['name_id']);
      $name->setTitle($clientRecord['name_title']);
      $name->setFirst($clientRecord['name_first']);
      $name->setLast($clientRecord['name_last']);

      // Contact Object
      $contact = new ContactModel();
      $contact->setId($clientRecord['contact_id']);
      $contact->setHome($clientRecord['contact_home']);
      $contact->setWork($clientRecord['contact_work']);
      $contact->setMobile($clientRecord['contact_mobile']);
      $contact->setFax($clientRecord['contact_fax']);
      $contact->setEmail($clientRecord['contact_email']);

      // Postcode Objects
      $postalPostcode = new PostcodeModel();
      $postalPostcode->setId($clientRecord['postal_address_postcode_id']);
      $postalPostcode->setNumber($clientRecord['postal_address_postcode_number']);

      $streetPostcode = new PostcodeModel();
      $streetPostcode->setId($clientRecord['street_address_postcode_id']);
      $streetPostcode->setNumber($clientRecord['street_address_postcode_number']);

      if ($postalPostcode == $streetPostcode){
        // :. 1 object exists of postcode
          $postalPostcode = $streetPostcode;
      }
      //else both fully populated :. continue

      // Suburb Objects
      $postalSuburb = new SuburbModel();
      $postalSuburb->setId($clientRecord['postal_address_suburb_id']);
      $postalSuburb->setName($clientRecord['postal_address_suburb_name']);
      $postalSuburb->setPostcode($postalPostcode);

      $streetSuburb = new SuburbModel();
      $streetSuburb->setId($clientRecord['street_address_suburb_id']);
      $streetSuburb->setName($clientRecord['street_address_suburb_name']);
      $streetSuburb->setPostcode($streetPostcode);

      if ($postalSuburb == $streetSuburb){
        // :. 1 object exists of suburb
        $postalSuburb = $streetSuburb;
      }
      //else both fully populated :. continue

      // Addres Objects
      $postalAddress = new AddressModel();
      $postalAddress->setId($clientRecord['postal_address_id']);
      $postalAddress->setUnitNumber($clientRecord['postal_address_unit_number']);
      $postalAddress->setStreetNumber($clientRecord['postal_address_street_number']);
      $postalAddress->setStreetName($clientRecord['postal_address_street_name']);
      $postalAddress->setCity($clientRecord['postal_address_city']);
      $postalAddress->setState($clientRecord['postal_address_state']);
      $postalAddress->setPostcode($postalPostcode);
      $postalAddress->setSuburb($postalSuburb);

      $streetAddress = new AddressModel();
      $streetAddress->setId($clientRecord['street_address_id']);
      $streetAddress->setUnitNumber($clientRecord['street_address_unit_number']);
      $streetAddress->setStreetNumber($clientRecord['street_address_street_number']);
      $streetAddress->setStreetName($clientRecord['street_address_street_name']);
      $streetAddress->setCity($clientRecord['street_address_city']);
      $streetAddress->setState($clientRecord['street_address_state']);
      $streetAddress->setPostcode($streetPostcode);
      $streetAddress->setSuburb($streetSuburb);

      if ($postalAddress == $streetAddress){
        // :. 1 object exists of Address
        $postalAddress = $streetAddress;
      }
      //else both fully populated :. continue


      // Client Object
      $client->setName($name);
      $client->setContact($contact);
      $client->setPostalAddress($postalAddress);
      $client->setStreetAddress($streetAddress);

      return $client;
    }catch(Exception $e){
      echo $e;
      return false;
    }

  }

  public function selectAll(){

    try{

      /*

      $clientRecordArray = self::$db->exec(array(
        'SELECT * FROM client as c, name as n WHERE n.id = c.name_id'
        ));
      $clientArray = array();

      foreach($clientRecordArray as $clientRecord){
        $client = new ClientModel();
        $client->setId($clientRecord['id']);

        $name = new NameModel();
        $name->setTitle($clientRecord['title']);
        $name->setFirst($clientRecord['first']);
        $name->setLast($clientRecord['last']);

        $client->setName($name);

        $clientArray[] = $client;
      }
      if (count($clientArray)){
        return $clientArray;
      }
      */
      $clientRecordArray = self::$db->exec(array(
        "SELECT client.id AS 'client_id',
               client.name_id AS 'client_name_id',
               client.contact_id AS 'client_contact_id',
               client.street_address_id AS 'client_street_address_id',
               client.postal_address_id AS 'client_postal_address_id',

               name.id AS 'name_id',
               name.title AS 'name_title',
               name.first AS 'name_first',
               name.last AS 'name_last',

               contact.id AS 'contact_id',
               contact.home AS 'contact_home',
               contact.work AS 'contact_work',
               contact.mobile AS 'contact_mobile',
               contact.fax AS 'contact_fax',
               contact.email AS 'contact_email',

               pa.id AS 'postal_address_id',

               papo.id AS 'postal_address_postcode_id',
               papo.number AS 'postal_address_postcode_number',

               pasu.id AS 'postal_address_suburb_id',
               pasu.name AS 'postal_address_suburb_name',

               pa.unit_number AS 'postal_address_unit_number',
               pa.street_number AS 'postal_address_street_number',
               pa.street_name AS 'postal_address_street_name',
               pa.city AS 'postal_address_city',
               pa.state AS 'postal_address_state',

               sa.id AS 'street_address_id',

               sapo.id AS 'street_address_postcode_id',
               sapo.number AS 'street_address_postcode_number',

               sasu.id AS 'street_address_suburb_id',
               sasu.name AS 'street_address_suburb_name',

               sa.unit_number AS 'street_address_unit_number',
               sa.street_number AS 'street_address_street_number',
               sa.street_name AS 'street_address_street_name',
               sa.city AS 'street_address_city',
               sa.state AS 'street_address_state'

               FROM client, name, contact, address AS pa, postcode AS papo, suburb AS pasu, address AS sa, postcode AS sapo, suburb AS sasu
               WHERE client.name_id = name.id AND
                     client.contact_id = contact.id AND
                     client.postal_address_id = pa.id AND
                     pa.postcode_id = papo.id AND
                     pa.suburb_id = pasu.id AND
                     client.street_address_id = sa.id AND
                     sa.postcode_id = sapo.id AND
                     sa.suburb_id = sasu.id"));


      if (!( count($clientRecordArray) )){
        return null;
      }


      $clientArray = array();

      foreach($clientRecordArray as $clientRecord){

        // Name Object
        $name = new NameModel();
        $name->setId($clientRecord['name_id']);
        $name->setTitle($clientRecord['name_title']);
        $name->setFirst($clientRecord['name_first']);
        $name->setLast($clientRecord['name_last']);

        // Contact Object
        $contact = new ContactModel();
        $contact->setId($clientRecord['contact_id']);
        $contact->setHome($clientRecord['contact_home']);
        $contact->setWork($clientRecord['contact_work']);
        $contact->setMobile($clientRecord['contact_mobile']);
        $contact->setFax($clientRecord['contact_fax']);
        $contact->setEmail($clientRecord['contact_email']);

        // Postcode Objects
        $postalPostcode = new PostcodeModel();
        $postalPostcode->setId($clientRecord['postal_address_postcode_id']);
        $postalPostcode->setNumber($clientRecord['postal_address_postcode_number']);

        $streetPostcode = new PostcodeModel();
        $streetPostcode->setId($clientRecord['street_address_postcode_id']);
        $streetPostcode->setNumber($clientRecord['street_address_postcode_number']);

        if ($postalPostcode == $streetPostcode){
          // :. 1 object exists of postcode
            $postalPostcode = $streetPostcode;
        }
        //else both fully populated :. continue

        // Suburb Objects
        $postalSuburb = new SuburbModel();
        $postalSuburb->setId($clientRecord['postal_address_suburb_id']);
        $postalSuburb->setName($clientRecord['postal_address_suburb_name']);
        $postalSuburb->setPostcode($postalPostcode);

        $streetSuburb = new SuburbModel();
        $streetSuburb->setId($clientRecord['street_address_suburb_id']);
        $streetSuburb->setName($clientRecord['street_address_suburb_name']);
        $streetSuburb->setPostcode($streetPostcode);

        if ($postalSuburb == $streetSuburb){
          // :. 1 object exists of suburb
          $postalSuburb = $streetSuburb;
        }
        //else both fully populated :. continue

        // Addres Objects
        $postalAddress = new AddressModel();
        $postalAddress->setId($clientRecord['postal_address_id']);
        $postalAddress->setUnitNumber($clientRecord['postal_address_unit_number']);
        $postalAddress->setStreetNumber($clientRecord['postal_address_street_number']);
        $postalAddress->setStreetName($clientRecord['postal_address_street_name']);
        $postalAddress->setCity($clientRecord['postal_address_city']);
        $postalAddress->setState($clientRecord['postal_address_state']);
        $postalAddress->setPostcode($postalPostcode);
        $postalAddress->setSuburb($postalSuburb);

        $streetAddress = new AddressModel();
        $streetAddress->setId($clientRecord['street_address_id']);
        $streetAddress->setUnitNumber($clientRecord['street_address_unit_number']);
        $streetAddress->setStreetNumber($clientRecord['street_address_street_number']);
        $streetAddress->setStreetName($clientRecord['street_address_street_name']);
        $streetAddress->setCity($clientRecord['street_address_city']);
        $streetAddress->setState($clientRecord['street_address_state']);
        $streetAddress->setPostcode($streetPostcode);
        $streetAddress->setSuburb($streetSuburb);

        if ($postalAddress == $streetAddress){
          // :. 1 object exists of Address
          $postalAddress = $streetAddress;
        }
        //else both fully populated :. continue


        // Client Object
        $client = new ClientModel();
        $client->setId($clientRecord['client_id']);
        $client->setName($name);
        $client->setContact($contact);
        $client->setPostalAddress($postalAddress);
        $client->setStreetAddress($streetAddress);

        $clientArray[] = $client;
      }

      if (!( $clientArray )){
        return null;
      }

      return $clientArray;

    }catch(Exception $e){
      echo $e;
      return null;
    }
  }

  public function selectAllByType($typeObject){
    if(!( $typeObject instanceof TypeModel )){
      //wrong object type
      $result['success'] = false;
      return $result;
    }

    try{

      $clientRecordArray = self::$db->exec(
          array(
            'SELECT c.id,n.first,n.last,t.id as type_id, t.name as type_name '.
            'FROM client AS c, name AS n, client_type AS ct, type AS t '.
            'WHERE c.id = ct.client_id AND c.name_id = n.id AND ct.type_id = t.id AND t.id = :type_id'
          ),
          array(
            array( ':type_id'=>$typeObject->getId() )
          )
        );
      $clientArray = array();

      foreach($clientRecordArray as $clientRecord){
        $client = new ClientModel();
        $client->setId($clientRecord['id']);
        $name = new NameModel();
        $name->setFirst($clientRecord['first']);
        $name->setLast($clientRecord['last']);
        $client->setName($name);
        $clientArray[] = $client;
      }
      if (count($clientArray)){
        return $clientArray;
      }
      return null;
    }catch(Exception $e){
      echo 'selectAllByType';
      echo $e;
      return null;
    }

  }

  public function selectAllUnnasigned(){

    try{

      $clientRecordArray = self::$db->exec(
          array(
            'SELECT * FROM client WHERE NOT EXISTS ('.
                'SELECT * FROM client_type '.
                'WHERE client.id = client_type.client_id'.
              ')'

          )
        );
      $clientArray = array();

      foreach($clientRecordArray as $clientRecord){
        $client = new ClientModel();
        $client->setId($clientRecord['id']);
        $client->setFirstName($clientRecord['first_name']);
        $client->setLastName($clientRecord['last_name']);
        $clientArray[] = $client;
      }
      if (count($clientArray)){
        return $clientArray;
      }
      return null;
    }catch(Exception $e){
      echo 'selectAllByType';
      echo $e;
      return null;
    }

  }


  public function save($clientObject) {
    if(!( $clientObject instanceof ClientModel ) ||
       !( $clientObject->getName() instanceof NameModel ) ||
       !( $clientObject->getContact() instanceof ContactModel ) ||
       !( $clientObject->getPostalAddress() instanceof AddressModel ) ||
       !( $clientObject->getStreetAddress() instanceof AddressModel ) ){
      //wrong object types
      $result['success'] = false;
      return $result;
    }
    try{
      /*
        NAME
        CONTACT
        POSTCODE  ( postal and street )
        -SUBURB   ( postal and street )
        --ADDRESS ( postal and street )
        ---POSTAL_ADDRESS
        ---STREET_ADDRESS
        ----CLIENT
      */

      $nameRecord = new DB\SQL\Mapper(self::$db,'name');
      $nameRecord->title = $clientObject->getName()->getTitle();
      $nameRecord->first = $clientObject->getName()->getFirst();
      $nameRecord->last  = $clientObject->getName()->getLast();
      $nameRecord->save();
      $clientObject->getName()->setId($nameRecord->id);


      $contactRecord = new DB\SQL\Mapper(self::$db,'contact');
      $contactRecord->home   = $clientObject->getContact()->getHome();
      $contactRecord->work   = $clientObject->getContact()->getWork();
      $contactRecord->mobile = $clientObject->getContact()->getMobile();
      $contactRecord->fax    = $clientObject->getContact()->getFax();
      $contactRecord->email  = $clientObject->getContact()->getEmail();
      $contactRecord->save();
      $clientObject->getContact()->setId($contactRecord->id);


      $postcodeRecord = new DB\SQL\Mapper(self::$db,'postcode');
      if (!( $postcodeRecord->load(array( 'number=?',$clientObject->getPostalAddress()->getPostcode()->getNumber() )) )){
        $postcodeRecord->number = $clientObject->getPostalAddress()->getPostcode()->getNumber();
        $postcodeRecord->save();
      }
      $clientObject->getPostalAddress()->getPostcode()->setId($postcodeRecord->id);

      // dehydrate mapper object
      $postcodeRecord->reset();

      if (!( $postcodeRecord->load(array( 'number=?',$clientObject->getStreetAddress()->getPostcode()->getNumber() )) )){
        $postcodeRecord->number = $clientObject->getStreetAddress()->getPostcode()->getNumber();
        $postcodeRecord->save();
      }
      $clientObject->getStreetAddress()->getPostcode()->setId($postcodeRecord->id);


      //postal postcode goes with postal suburb

      $suburbRecord = new DB\SQL\Mapper(self::$db,'suburb');
      if (!( $suburbRecord->load(array( 'name=?',$clientObject->getPostalAddress()->getSuburb()->getName() ))   )){
        // suburb name doesn't exist :. insert using postcode id
        $suburbRecord->name = $clientObject->getPostalAddress()->getSuburb()->getName();
        $suburbRecord->postcode_id = $clientObject->getPostalAddress()->getPostcode()->getId();
        $suburbRecord->save();
      }
      // suburb exists :. update object with id
      $clientObject->getPostalAddress()->getSuburb()->setId($suburbRecord->id);
      $clientObject->getPostalAddress()->getSuburb()->setPostcode($clientObject->getPostalAddress()->getPostcode());

      // dehydrate mapper object
      $suburbRecord->reset();

      if (!( $suburbRecord->load(array( 'name=?',$clientObject->getStreetAddress()->getSuburb()->getName() )) )){
        $suburbRecord->name = $clientObject->getStreetAddress()->getSuburb()->getName();
        $suburbRecord->postcode_id = $clientObject->getStreetAddress()->getPostcode()->getId();
        $suburbRecord->save();
      }
      $clientObject->getStreetAddress()->getSuburb()->setId($suburbRecord->id);
      $clientObject->getStreetAddress()->getSuburb()->setPostcode($clientObject->getStreetAddress()->getPostcode());

      $addressRecord = new DB\SQL\Mapper(self::$db,'address');

      $addressRecord->postcode_id   = $clientObject->getPostalAddress()->getPostcode()->getId();
      $addressRecord->suburb_id     = $clientObject->getPostalAddress()->getSuburb()->getId();
      $addressRecord->unit_number   = $clientObject->getPostalAddress()->getUnitNumber();
      $addressRecord->street_number = $clientObject->getPostalAddress()->getStreetNumber();
      $addressRecord->street_name   = $clientObject->getPostalAddress()->getStreetName();
      $addressRecord->city          = $clientObject->getPostalAddress()->getCity();
      $addressRecord->state         = $clientObject->getPostalAddress()->getState();
      $addressRecord->save();
      $clientObject->getPostalAddress()->setId($addressRecord->id);

      // dehydrate mapper object
      $addressRecord->reset();

      $addressRecord->postcode_id   = $clientObject->getStreetAddress()->getPostcode()->getId();
      $addressRecord->suburb_id     = $clientObject->getStreetAddress()->getSuburb()->getId();
      $addressRecord->unit_number   = $clientObject->getStreetAddress()->getUnitNumber();
      $addressRecord->street_number = $clientObject->getStreetAddress()->getStreetNumber();
      $addressRecord->street_name   = $clientObject->getStreetAddress()->getStreetName();
      $addressRecord->city          = $clientObject->getStreetAddress()->getCity();
      $addressRecord->state         = $clientObject->getStreetAddress()->getState();
      $addressRecord->save();
      $clientObject->getStreetAddress()->setId($addressRecord->id);

      $clientRecord = new DB\SQL\Mapper(self::$db,'client');
      $clientRecord->name_id    = $clientObject->getName()->getId();
      $clientRecord->contact_id = $clientObject->getContact()->getId();
      $clientRecord->postal_address_id = $clientObject->getPostalAddress()->getId();
      $clientRecord->street_address_id = $clientObject->getStreetAddress()->getId();
      if( $clientRecord->save() ){
          $result['success'] = true;
          $clientObject->setId($clientRecord->id);
      } else {
          $result['success'] = false;
      }
      return $result;
    }catch(Exception $e){
      echo $e;
      return false;
    }
  }

}

