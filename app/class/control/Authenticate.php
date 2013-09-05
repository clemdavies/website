<?php

Class Authenticate {


  public static function isAdmin($f3){
      if(!($f3->get('SESSION.admin'))){
        $f3->set('SESSION.flash.message','login first');
        $f3->set('SESSION.flash.type','error');
        $f3->set('SESSION.redirect',$f3->get('URI'));
        $f3->reroute('/admin');
      }
  }

  public static function ifAdmin($f3){
      if( $f3->get('SESSION.admin') ){
        return true;
      }else{
        return false;
      }
  }

  public static function isAjax($f3){
    if(!( $f3->get('AJAX') )){
      $f3->error(404);
    }
  }

  public static function newArticle($f3){
    if($f3->get('SESSION.admin')){
      if($f3->get('SESSION.newArticle')){
        $f3->set('adminMessage','article saved');
        $f3->clear('SESSION.newArticle');
      }
    }
  }

  public static function deleteArticle($f3){

    if ($f3->get('SESSION.admin')){
      if ($f3->get('SESSION.deleteArticle')){
        $f3->set('adminMessage','article deleted');
        $f3->clear('SESSION.deleteArticle');
      }
    }

  }

}
