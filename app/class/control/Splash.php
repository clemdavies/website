<?php

Class Splash{

  public function get($f3){

    $f3->set('css',array('splash'));
    $f3->set('js',array('splash','jquery-ui-1.10.3.custom.min'));

    print Template::instance()->render('/template/splash.html');
  }


}
