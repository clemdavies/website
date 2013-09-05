<?php

Class Dashboard{

    //get /admin/dashboard
    public function get($f3){
      Authenticate::isAdmin($f3);
      $f3->set('title','dashboard');
      $f3->set('content',Template::instance()->render('/admin/dashboard.html'));
      $f3->set('css',Array('dashboard'));
      $f3->set('js',Array('dashboard'));
      print Template::instance()->render('/template/main.html');
    }
}
