<?php

Class Dashboard{

    //get /admin/dashboard
    public function get($f3){
      Authenticate::isAdmin($f3);

      //var_dump($this->getNewComments($f3));

      $f3->set( 'articles' , $this->getNewComments($f3) );


      $f3->set('title','dashboard');
      $f3->set('content',Template::instance()->render('/admin/dashboard.html'));
      $f3->set('css',Array('dashboard','comments'));
      $f3->set('js',Array('dashboard','plugins/overlay','plugins/centerElement','deleteComment'));
      print Template::instance()->render('/template/main.html');
    }


    private function getNewComments($f3){

      $factory = new CommentFactory($f3);
      $comments = $factory->allUnseenComments();

      $articleArray = $this->nestCommentModelsUnderArticleModels($f3,$comments);

      return $articleArray;
    }

    private function nestCommentModelsUnderArticleModels($f3,$comments){


      $articleFactory = new ArticleFactory($f3);


      $articleModelArray = array();

      foreach( $comments as $commentModel ){
        $articleId = $commentModel->getArticleId();
        if (!( isset($articleModelArray[$articleId])) ){
          //create new object
          $articleModelArray[$articleId] = $articleFactory->selectTitleById($articleId);
        }
        $articleModel = $articleModelArray[$articleId];
        $articleModel->appendComments($commentModel);
      }

      return $articleModelArray;

    }

}
