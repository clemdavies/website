<?php


Class CreateAdmin{


  public function get($f3){

      $name = "pig";
      $pass = "c7955db453321a1176e0c5c7afde82f98f525b4bacc9f901537fe7e3694d0c36";

      $db = new Database();

      $result = $db->login($name,$pass);

      if (!( $result['success'] )){
        //didnt login :. no admin created
        $db->createAdmin($name, $pass);
      }

      $f3->error(404);

  }
}
