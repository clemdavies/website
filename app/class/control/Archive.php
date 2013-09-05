<?php

Class Archive{

  function get($f3){

    $f3->set('title','archive');

    $f3->set('content',Template::instance()->render('/template/beta.html'));

    print Template::instance()->render('/template/main.html');
  }

}
