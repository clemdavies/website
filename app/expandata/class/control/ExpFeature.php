<?php

Class ExpFeature{

  public function get($f3){

    $param = $f3->get('PARAMS.feature');

    echo "displays all properties with $param features";
  }

}
