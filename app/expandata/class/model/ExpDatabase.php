<?php

Class ExpDatabase{

    public static $db;

    public function __construct($f3 = null){

      if($f3 == null){
        echo 'database constructed without valid argument';
      }

      //port = 3306
        self::$db=new DB\SQL(
              'mysql:host='.$f3->get('dbhost').';port='.$f3->get('dbport').';dbname='.$f3->get('expdbname'),
              $f3->get('dbuser'),
              $f3->get('dbpass')
          );

    }

    public static function databaseClean($item){
      return str_replace(' ','_',$item);
    }

    public static function humanClean($item){
      return str_replace('-',' ',$item);
    }
}
