<?php

Class About{

    public function get($f3){
      $f3->set('content','normal About me page from setContent()');
      print Template::instance()->render('/template/main.html');

    }


}
