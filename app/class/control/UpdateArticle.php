<?php

Class UpdateArticle{

  public function post($f3){
    Authenticate::isAdmin($f3);
    Authenticate::isAjax($f3);

    header("Content-Type: application/json");


    $f3->scrub($_POST['title']);
    $f3->scrub($_POST,'br; a; h3');

    $articleFactory = new ArticleFactory($f3);
    $id         = $_POST['article_id'];
    $categoryId = $_POST['category_id'];
    $title      = $articleFactory->removeWhitespace($_POST['title']);
    $content    = $_POST['content'];

    $result['success'] = $articleFactory->updateArticle($id,$categoryId,$title,$content);

    if ($result['success']){
      $result['articleTitle'] = $title;
      $f3->set('SESSION.newArticle',true);
    }

    echo json_encode($result);

  }

}
