<?php


$f3=require('lib/base.php');
$f3->config('config.ini');
$f3->set('FFF',$f3);
$f3->set('ESCAPE',false);

if (get_magic_quotes_gpc()) {
    $process = array(&$_GET, &$_POST, &$_COOKIE, &$_REQUEST);
    while (list($key, $val) = each($process)) {
        foreach ($val as $k => $v) {
            unset($process[$key][$k]);
            if (is_array($v)) {
                $process[$key][stripslashes($k)] = $v;
                $process[] = &$process[$key][stripslashes($k)];
            } else {
                $process[$key][stripslashes($k)] = stripslashes($v);
            }
        }
    }
    unset($process);
}


//$f3->map( '/'              , 'Splash'  );
$f3->map( '/'               , 'Home'    );
$f3->map( '/archive'        , 'Archive' );
$f3->map( '/contact'        , 'Contact' );
$f3->map( '/code'           , 'Code'    );
$f3->map( '/about'          , 'About'   );
$f3->map( '/article/@title' , 'Article' );

$f3->map( '/feed' , 'Feed' );

$f3->map( '/admin'                  , 'Admin'         );
$f3->map( '/admin/dashboard'        , 'Dashboard'     );

$f3->map( '/admin/login'            , 'Login'         );
$f3->map( '/admin/logout'           , 'Logout'        );

$f3->map( '/admin/new/article'      , 'NewArticle'    );
$f3->map( '/admin/edit/article/@id' , 'EditArticle'   );
$f3->map( '/admin/update/article'   , 'UpdateArticle' );
$f3->map( '/admin/delete/article'   , 'DeleteArticle' );

$f3->map( '/admin/new/category'  , 'NewCategory'  );
$f3->map( '/admin/read/category' , 'ReadCategory' );

$f3->map( '/admin/read/thoughts' , 'ReadThoughts' );

$f3->map( '/admin/create/admin' , 'CreateAdmin' );

$f3->run();