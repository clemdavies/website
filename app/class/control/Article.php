<?php

Class Article{

    public function get($f3){

      Authenticate::newArticle($f3);

      if( $f3->set('article',$this->setArticle($f3)) ){
        // article exists
        $f3->set('title',$f3->get('article')->retrieveCleanTitle());
        $f3->set('comments',$this->setComments($f3));
        $f3->set('content',Template::instance()->render('/article/full.html'));
        $f3->set('css',array('article'));
        $f3->set('js',array('article','plugins/justify','plugins/inputLabel'));

      }else{
        // invalid article title
        $f3->set('content',Template::instance()->render('/article/missing.html'));
      }

      print Template::instance()->render('/template/main.html');
    }

    private function setArticle($f3){
      $articleName = $f3->get('PARAMS.title');
      $factory = new ArticleFactory($f3);
      $articleModel = $factory->selectByTitle($articleName);

      if ($articleModel instanceof ArticleModel){
        return $articleModel;
      }
    }

    private function setComments($f3){
      $article = $f3->get('article');
      $factory = new CommentFactory($f3);
      $commentModel = $factory->findByArticleId($article->getId());
      return $commentModel;
    }

}
