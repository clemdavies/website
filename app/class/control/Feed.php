<?php

Class Feed{

  // renders 5 snippets of articles
  // parameters taken: ( date || category ) && article number && ascending/descending


  private $f3;
  private $amount = 5;


  public function get($f3){
    Authenticate::isAjax($f3);

    $date = $_GET['date'];
    $id = $_GET['id'];

    $factory = new ArticleFactory($f3);
    $articles = $factory->selectFromDate($date,$this->amount,$id);

    $result['articles'] = '';
    foreach($articles as $article){
      $f3->set('article',$article);
      $result['articles'] .= Template::instance()->render('/feed/article.html');
    }
    $result['more'] = $this->articlesAvailableTWO($articles,$date,$f3);

    echo json_encode($result);
  }

  public function setup($f3){
    if($f3->exists('js')){
      $f3->push('js','feed');
    }else{
      $f3->set('js',array('feed'));
    }
  }

  public function latest($f3){

    $this->setup($f3);

    $now = date('Y-m-d H:i:s',strtotime('+1 day'));

    $factory  = new ArticleFactory($f3);
    $articles = $factory->selectFromDate($now, $this->amount);
    $more     = $this->articlesAvailable($articles,$now,$f3);

    $f3->set('more',$more);
    $f3->set('articles',$articles);


    return Template::instance()->render('/feed/feed.html');

  }

  public function articlesAvailable($articles,$date,$f3){

    $factory = new ArticleFactory($f3);
    if($factory->countByDate($date) > count($articles)){
      return true;
    }else{
      return false;
    }

  }

  public function articlesAvailableTWO($articles,$date,$f3){

    $factory = new ArticleFactory($f3);
    if($factory->countExcludingDate($date) > count($articles)){
      return true;
    }else{
      return false;
    }
  }

}
