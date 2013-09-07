<?php

Class DeleteComment{

  public function get($f3){
    Authenticate::isAdmin($f3);
    Authenticate::isAjax($f3);

    $f3->scrub($_GET);

    $comment = new CommentModel();
    $comment->setId($_GET['comment_id']);

    $factory = new CommentFactory($f3);
    $result['success'] = $factory->delete($comment);

    header("Content-Type: application/json");
    echo json_encode($result);
  }

}
