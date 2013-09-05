<?php


Class NewArticle{

  public function get($f3){
    Authenticate::isAdmin($f3);
    $f3->set('title','new article');
    $f3->set('content',Template::instance()->render('/admin/articleForm.html'));
    $f3->set('css',Array('newarticle'));
    $f3->set('js',Array('newarticle','plugins/inputLabel'));
    $f3->set('plugins',array( Plugin::scrollbar(),Plugin::imageUpload() ));
    print Template::instance()->render('/template/main.html');
  }


  public function post($f3){
    Authenticate::isAdmin($f3);
    Authenticate::isAjax($f3);
    header("Content-Type: application/json");

    $f3->scrub($_POST['title']);
    $f3->scrub($_POST,'br; a; h3');

    $articleFactory = new ArticleFactory($f3);

    $title      = $articleFactory->cleanTitle($_POST['title']);
    $categoryId = $_POST['category_id'];
    $content    = $_POST['content'];

    $categoryModel = new CategoryModel();
    $categoryModel->setId($categoryId);

    $articleModel = new ArticleModel();
    $articleModel->setTitle($title);
    $articleModel->setCategory($categoryModel);
    $articleModel->setContent($content);
    $articleModel->newDateTime();

    $result['success'] = $articleFactory->save($articleModel);

    if ($result['success']){
      $result['articleTitle'] = $title;
      $f3->set('SESSION.newArticle',true);
    }

    echo json_encode($result);
  }

}
