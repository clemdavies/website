<?php
Class Comment{

  public function post($f3){
    Authenticate::isAjax($f3);

    $f3->scrub($_POST);

    $comment = new CommentModel();
    $comment->setArticleId($_POST['article_id']);
    $comment->setName($_POST['comment_name']);
    $comment->setContent($_POST['comment_content']);
    $comment->newDateTime();
    $comment->newSeen();

    $factory = new CommentFactory($f3);
    $result['success'] = $factory->save($comment);

    if ($result['success']){
      $f3->set('comment',$comment);
      $result['comment'] = Template::instance()->render('/comment/single.html');
    }
    header("Content-Type: application/json");
    echo json_encode($result);
  }


}
