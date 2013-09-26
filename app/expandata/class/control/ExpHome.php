<?php
Class ExpHome{
  /*
    on creation of type/attribute store a datetime value
    after 1 month check if type or attribute is being used
    if not being used alert user/admin/authorized that these are not being used
    request deletion of type/attribute
    if not deleted reset datetime value, recheck in 1 month

    figure out dropbox-like update solution
    for when internet connection is unavailable to update main server
    what if multi user based, on information mismatch.
    ID value resolution mainly, but any field is at risk of mismatching.

    if (no connection){
      create view client side. with update ability
      create sql command to run when connection is resolved
    }

    perhaps no creation of attributes can  be done?
    one could create an attribute, UNLESS same name is used for different attribute type.

    client stores list of available attributes and types.

    updates and insertions are fine. but what about selects?
    user would need full version client side of database for selection at X-datetime stamp.

    :/ hmmm

    bool_attribute form is not correct.
    values are stored only if true......
    do i need to store false though?

  */


  public function get($f3){


    $factory = new TypeFactory($f3);
    $f3->set('types',$factory->selectAll());
    $f3->set('content',Template::instance()->render('/expandata/home.html'));
    print Template::instance()->render('/expandata/main.html');
  }

}
