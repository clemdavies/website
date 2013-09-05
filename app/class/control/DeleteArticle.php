<?php

Class DeleteArticle{

  public function post($f3){
    Authenticate::isAdmin($f3);
    Authenticate::isAjax($f3);
    header("Content-Type: application/json");

    $f3->scrub($_POST);

    $articleFactory = new ArticleFactory($f3);
    $articleId = $_POST['article_id'];

    $result['success'] = $articleFactory->deleteArticle($articleId);

    if ($result['success']){
      $f3->set('SESSION.deleteArticle',true);
    }

    echo json_encode($result);
  }



}
