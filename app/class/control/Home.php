<?php

Class Home{
  public function get($f3){

    Authenticate::deleteArticle($f3);

    $f3->set('css',array('feed'));

    $feed = new Feed();
    $f3->set('content',$feed->latest($f3));


    print Template::instance()->render('/template/main.html');
  }
}
