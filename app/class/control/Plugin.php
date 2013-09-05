<?php

Class Plugin{

  public static function scrollbar(){

    $scroll = array();

    $scroll['dir'] = 'scrollbar';
    $scroll['js']  = array('jquery.mCustomScrollbar.concat.min');
    $scroll['css'] = array('jquery.mCustomScrollbar');

    return $scroll;
  }

  public static function imageUpload(){

    $upload = array();

    $upload['dir'] = 'file-upload';
    $upload['js']  = array('jquery.ui.widget',
                           'jquery.iframe-transport',
                           'jquery.fileupload');

    return $upload;
  }


}
