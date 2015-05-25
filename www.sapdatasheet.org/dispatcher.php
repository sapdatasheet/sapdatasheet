<?php

//
// This is the dispatcher for those URIs does not match any real file
// This is the so called 'Front Controller pattern'.
//
// See the following web page for details:
//   http://en.wikipedia.org/wiki/Front_Controller_pattern
//   
// Related links
//   http://php.net/manual/en/function.preg-match.php
//   http://stackoverflow.com/questions/16388959/url-rewriting-with-php
//
// ABAP URI analysis example
//   http://localhost/abap/bmfr/
//   http://localhost/abap/bmfr/index-top.html
//   http://localhost/abap/bmfr/index.php?index=top
//   http://localhost/abap/bmfr/index-a.html
//   http://localhost/abap/bmfr/index.php?index=a
//   http://localhost/abap/bmfr/HLB0009009.html
//   http://localhost/abap/bmfr/bmfr.php?id=HLB0009009

require_once(dirname(__FILE__) . '/include/global.php');

$requri = html_entity_decode(strtolower($_SERVER['REQUEST_URI']));
unset($target);

// - Hacker URL
if ($requri === '/wp/wp-admin/' 
        || $requri === '/wp-admin/'
        || $requri === '/test/wp-admin/'
        || $requri === '/blog/wp-admin/') {
    $target = 'page404.php';

// - Root path
} else if ($requri === '/') {
    $target = 'index.php';

// - ALL other URL
//   http://localhost/abap/
//   http://localhost/abap/cvers/
//   http://localhost/abap/prog/
} else if (startsWith($requri, '/') && endsWith($requri, '/')) {
    $target = substr($requri, 1) . 'index.php';

// - TABL - Tables (Transparent, Cluster, Pool)
//   http://localhost/abap/tabl/
//   http://localhost/abap/tabl/index-pool.html
//   http://localhost/abap/tabl/index.php?index=pool
//   http://localhost/abap/tabl/index-a.html
//   http://localhost/abap/tabl/index.php?index=a
//   http://localhost/abap/tabl/A002-TAXK1.html
//   http://localhost/abap/tabl/field.php?table=A002&field=TAXK1
//   http://localhost/abap/tabl/bkpf-0090.html
//   http://localhost/abap/tabl/field.php?table=BKPF&position=0090
//   http://localhost/abap/tabl/bkpf.html
//   http://localhost/abap/tabl/tabl.php?id=bkpf
} else if ($requri === '/abap/tabl/index.html') {
    $target = 'abap/tabl/index.php';
} else if (startsWith($requri, '/abap/tabl/index-') && endsWith($requri, '.html')) {
    $index = substr($requri, 17, -5);
    $target = 'abap/tabl/index.php';
} else if (startsWith($requri, '/abap/tabl/') && endsWith($requri, '.html')) {
    $TablURI = substr($requri, 11, -5);
    if (strpos($TablURI, '-') !== false) {
        list($Table, $FldPos) = explode('-', $TablURI, 2);
        if (ctype_digit($FldPos) === true) {
            $Position = $FldPos;
        } else{
            $Field = $FldPos;
        }
        $target = 'abap/tabl/field.php';
    } else {
        $ObjID = $TablURI;
        $target = 'abap/tabl/tabl.php';
    }
}

// - BMFR - Application Component
//if ($requri === '/abap/bmfr/index.html') {
//    $target = 'abap/bmfr/index.php';
//} else if (startsWith($requri, '/abap/bmfr/index-') && endsWith($requri, '.html')) {
//    $index = substr($requri, 17, -5);
//    $target = 'abap/bmfr/index.php';
//} else if (startsWith($requri, '/abap/bmfr/') && endsWith($requri, '.html')) {
//    $ObjID = substr($requri, 11, -5);
//    $target = 'abap/bmfr/bmfr.php';

$abap_uris = array(
    array("cvers", '/abap/cvers/index.html', '/abap/cvers/index-', '/abap/cvers/'),
    array("bmfr", '/abap/bmfr/index.html', '/abap/bmfr/index-', '/abap/bmfr/'),
    array("devc", '/abap/devc/index.html', '/abap/devc/index-', '/abap/devc/'),
    array("doma", '/abap/doma/index.html', '/abap/doma/index-', '/abap/doma/'),
    array("dtel", '/abap/dtel/index.html', '/abap/dtel/index-', '/abap/dtel/'),
    array("fugr", '/abap/fugr/index.html', '/abap/fugr/index-', '/abap/fugr/'),
    array("func", '/abap/func/index.html', '/abap/func/index-', '/abap/func/'),
    array("prog", '/abap/prog/index.html', '/abap/prog/index-', '/abap/prog/'),
    array("sqlt", '/abap/sqlt/index.html', '/abap/sqlt/index-', '/abap/sqlt/'),
    array("tran", '/abap/tran/index.html', '/abap/tran/index-', '/abap/tran/'),
    array("view", '/abap/view/index.html', '/abap/view/index-', '/abap/view/'),
);

if (!isset($target)) {
    foreach ($abap_uris as $abap_uri) {
        if ($requri === $abap_uri[1]) {
            $target = 'abap/' . $abap_uri[0] . '/index.php';
        } else if (startsWith($requri, $abap_uri[2]) && endsWith($requri, '.html')) {
            $index = substr($requri, strlen($abap_uri[2]), -5);
            $target = 'abap/' . $abap_uri[0] . '/index.php';
        } else if (startsWith($requri, $abap_uri[3]) && endsWith($requri, '.html')) {
            $ObjID = substr($requri, strlen($abap_uri[3]), -5);
            $target = 'abap/' . $abap_uri[0] . '/' . $abap_uri[0] . '.php';
        }
    }
}

if (!isset($target)) {
    $target = 'page404.php';
}

// Logging
// Only log for Debug purpose, do not log on production system 
// error_log('dispatcher: [' . $requri . '] --> [' . $target . ']');

//  Navigation
include $target;
exit();
