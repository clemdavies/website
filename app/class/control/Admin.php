<?php

Class Admin{

  /*
    js script does a client side hash of entered password.
    server recieves this hashed password.
    server retrieves stored hash,salt,password from database.
    server uses validation method to validate stored value with given password hash.
  */


    public function get($f3){
      $f3->set('title','admin');
      if  ($f3->get('SESSION.admin')){
        $f3->reroute('/admin/dashboard');
      }
      $f3->set('flash',$f3->get('SESSION.flash'));
      $f3->set('redirect',$f3->get('SESSION.redirect'));

      $f3->clear('SESSION');
      $f3->set('content',Template::instance()->render('/admin/loginForm.html'));
      $f3->set('js',Array('login','sha2','plugins/inputLabel'));
      $f3->set('css',Array('login'));
      print Template::instance()->render('/template/main.html');
    }

    public function logout($f3){
      $f3->clear('SESSION');
      $f3->reroute('/admin');
    }

}
