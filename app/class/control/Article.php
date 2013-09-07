<?php

Class Article{

    public function get($f3){

      Authenticate::newArticle($f3);

      if( $f3->set('article',$this->setArticle($f3)) ){
        // article exists
        $this->setComments($f3);

        $f3->set('title',$f3->get('article')->retrieveCleanTitle());
        $f3->set('comments',$f3->get('article')->getComments());
        $f3->set('content',Template::instance()->render('/article/full.html'));
        $f3->set('css',array('article','comments'));
        $f3->set('js',array('article','plugins/justify','plugins/inputLabel'));

        if (Authenticate::ifAdmin($f3)){
          $f3->push( 'js' , 'deleteComment' );
          $f3->push( 'js' , 'adminArticle' );
          $f3->push( 'js' , 'plugins/overlay' );
          $f3->push( 'js' , 'plugins/centerElement' );
        }

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
      $commentModelArray = $factory->findByArticleId($article->getId());
      $article->setComments($commentModelArray);
    }

}
