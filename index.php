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

/* START EXPANDATA DATABASE APP START */

$f3->map( '/expandata' , 'ExpHome' );


/* client */
$f3->map( '/expandata/clients'            , 'ExpClient'     );
$f3->map( '/expandata/clients/unassigned' , 'ExpUnassigned' );
$f3->map( '/expandata/clients/@type'      , 'ExpType'       );

$f3->map( '/expandata/client/@id'      , 'ExpViewClient' );
$f3->map( '/expandata/client/@id/edit' , 'ExpEditClient' );

$f3->map( '/expandata/new/client'           , 'ExpNewClient'    );
$f3->map( '/expandata/new/client/type'      , 'ExpNewType'      );
$f3->map( '/expandata/new/client/attribute' , 'ExpNewAttribute' );

$f3->map( '/expandata/new/client/type/ajax'      , 'ExpNewTypeAjax'      );
$f3->map( '/expandata/new/client/attribute/ajax' , 'ExpNewAttributeAjax' );

/* property */
$f3->map( '/expandata/properties'                     , 'ExpProperty' );//list all properties
$f3->map( '/expandata/properties/unassigned/features' , 'ExpUnassignedFeature' );//list all properties with unassigned features
$f3->map( '/expandata/properties/unassigned/styles'   , 'ExpUnassignedStyle' );//list all properties with unassigned styles
$f3->map( '/expandata/properties/@feature'            , 'ExpFeature'  );//list all properties with 'x' feature
$f3->map( '/expandata/properties/@style'              , 'ExpStyle'    );//list all property with 'x' style

$f3->map( '/expandata/property/@id'      , 'ExpViewProperty' );
$f3->map( '/expandata/property/@id/edit' , 'ExpEditProperty' );

$f3->map( '/expandata/new/property'         , 'ExpNewProperty' );
$f3->map( '/expandata/new/property/style'   , 'ExpNewStyle'    );
$f3->map( '/expandata/new/property/feature' , 'ExpNewFeature'  );

/* END EXPANDATA DATABASE APP END */

//$f3->map( '/'              , 'Splash'  );
$f3->map( '/'               , 'Home'    );
$f3->map( '/archive'        , 'Archive' );
$f3->map( '/contact'        , 'Contact' );
$f3->map( '/code'           , 'Code'    );
$f3->map( '/about'          , 'About'   );
$f3->map( '/article/@title' , 'Article' );
$f3->map( '/feed'           , 'Feed'    );
$f3->map( '/new/comment'    , 'Comment' );
$f3->map( '/delete/comment' , 'DeleteComment' );
$f3->map( '/seen/comment'   , 'SeenComment' );


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

$f3->map( '/splash' , 'Splash' );


$f3->run();
