<?php

Class Database{

    public static $db;

    public function __construct($f3){
      //port = 3306
        self::$db=new DB\SQL(
              'mysql:host='.$f3->get('dbhost').';port='.$f3->get('dbport').';dbname='.$f3->get('dbname'),
              $f3->get('dbuser'),
              $f3->get('dbpass')
          );

    }



    public function login($name,$pass){

        // extract userhash from DB where user = $user.
        // call validate password.
        // return result.


        try{
            $admin = new DB\SQL\Mapper(Database::$db,'admin');
            $admin->load( array('username=?',$name) );



            $result['success'] = ( PasswordHash::validate_password( $pass, $admin->password ) );

            return $result;

        }catch(Exception $e){
            return false;
        }
    }

    /**
     * NOT USED IN PROD!!
     */

    public function createAdmin($name, $pass){

        $hashPass = PasswordHash::create_hash($pass);

        $admin = new DB\SQL\Mapper(Database::$db,'admin');
        $admin->username = 'pig';
        $admin->author = 'Clem Davies';
        $admin->password = $hashPass;
        $admin->created = "NOW()";
        if( $admin->save() ){
            return true;
        } else {
            return false;
        }
    }


}
