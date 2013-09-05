<?php

Class NewCode{

    public function get($f3){

      Authenticate::isAdmin($f3);
      print 'NewCode';

    }


}
