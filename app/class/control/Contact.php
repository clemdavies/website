<?php

Class Contact{

  function get($f3){

    $f3->set('title','contact');

    $f3->set('content',Template::instance()->render('/contact/contact.html'));
    $f3->set('css',array('contact'));
    $f3->set('js',array('contact'));
    print Template::instance()->render('/template/main.html');
  }

}
