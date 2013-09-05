<?php

Class EditArticle{

  public function get($f3){
    Authenticate::isAdmin($f3);
    $f3->set('title','edit article');
    $f3->set('article',$this->getArticle($f3));
    $f3->set('content',Template::instance()->render('/admin/editArticleForm.html'));
    $f3->set('css',Array('newarticle'));
    $f3->set('js',Array('editarticle'));
    $f3->set('plugins',array( Plugin::scrollbar(),Plugin::imageUpload() ));
    print Template::instance()->render('/template/main.html');
  }

  private function getArticle($f3){
    $id = $f3->get('PARAMS.id');
    $factory = new ArticleFactory($f3);
    $articleModel = $factory->selectById($id);
    return $articleModel;
  }
}
