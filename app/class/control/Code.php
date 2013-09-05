<?php

Class Code{

  function get($f3){

    $f3->set('title','code');

    $f3->set('content',Template::instance()->render('/static/code.html'));

    $f3->set('css',array('code'));

    print Template::instance()->render('/template/main.html');
  }

}
