<?php

Class Login{

    public function get($f3){

      header("Content-Type: application/json");

      $f3->scrub($_GET);
      $name = $_GET['name'];
      $pass = $_GET['pass'];

      $db = new Database($f3);

      /* DEVELOPMENT */
      // server salts and hashes given password before storing.
      //echo json_encode( $db->createAdmin($name, $pass) );
      /* DEVELOPMENT */

      $result = $db->login($name,$pass);
      if($result['success']){
        $f3->set('SESSION.admin',true);
      }else{
        $f3->set('SESSION.admin',false);
      }

      echo json_encode( $result );
    }


}
