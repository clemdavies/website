<?php

Class Logout{

    public function get($f3){
      $f3->clear('SESSION');
      $f3->set('SESSION.flash.message','logged out');
      $f3->set('SESSION.flash.type','success');
      $f3->reroute('/admin');
    }


}
