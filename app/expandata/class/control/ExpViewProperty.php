<?php

Class ExpViewProperty{

  public function get($f3){

    $id = $f3->get('PARAMS.id');
    echo "display property with id: $id";
  }

}
