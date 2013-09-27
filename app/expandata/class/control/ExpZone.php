<?php

Class ExpZone{

  public function get($f3){
    $zone = $f3->get('PARAMS.zone');
    echo "lists all properties with $zone zone";
  }


}
