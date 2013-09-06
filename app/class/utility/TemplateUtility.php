<?php
Class TemplateUtility{

  public static function pluralize($number,$word,$plural = false){
    if ($number !== 1){
      if ($plural){
        $word = $plural;
      }else{
        $word .= 's';
      }
    }
    return $word;
  }

}
