<?php

Class ExpEditProperty{

  public function get($f3){
    $id = $f3->get('PARAMS.id');
    echo "editing property with id: $id";
  }
  public function post($f3){
    // submit update to database
  }

}
