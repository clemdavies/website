<?php

Class Splash{

  public function get($f3){

    $f3->set('css',array('newHome'));
    $f3->set('js',array('newHome','jquery-ui-1.10.3.custom.min'));
    //$f3->set('plugins',array( Plugin::gridster() ));
    $f3->set('content','my test content about each and every skill here.');
    $f3->set('skills',array('JAVA'=>Template::instance()->render('/skills/java.html'),
                            'PHP'=>Template::instance()->render('/skills/php.html'),
                            'MYSQL'=>Template::instance()->render('/skills/java.html'),
                            'JQUERY'=>Template::instance()->render('/skills/java.html'),
                            'RUBY'=>Template::instance()->render('/skills/java.html'),
                            'OBJ C'=>Template::instance()->render('/skills/objc.html'),
                            'AJAX'=>Template::instance()->render('/skills/java.html'),
                            'XML'=>Template::instance()->render('/skills/java.html'),
                            'MVC'=>Template::instance()->render('/skills/java.html'),
                            'TDD'=>Template::instance()->render('/skills/java.html')
                            ));

    $feed = new Feed($f3);
    $f3->set('latestBlog',$feed->latest($f3));

    print Template::instance()->render('/template/newhome.html');
  }


}
