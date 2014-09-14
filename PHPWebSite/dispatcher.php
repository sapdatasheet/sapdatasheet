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

define('__ROOT__', dirname(__FILE__));
require_once(__ROOT__ . '/include/global.php');

$requri = urldecode(strtolower($_SERVER['REQUEST_URI']));

// - Root path
if ($requri === '/') {
    $target = 'index.php';
// - ALL other URL
//   http://localhost/abap/
//   http://localhost/abap/cvers/
//   http://localhost/abap/prog/
} else if (startsWith($requri, '/') && endsWith($requri, '/')) {
    $target = substr($requri, 1) . 'index.php';
// - BMFR - Application Component
//   http://localhost/abap/bmfr/
//   http://localhost/abap/bmfr/index-top.html
//   http://localhost/abap/bmfr/index.php?index=top
//   http://localhost/abap/bmfr/index-a.html
//   http://localhost/abap/bmfr/index.php?index=a
//   http://localhost/abap/bmfr/HLB0009009.html
//   http://localhost/abap/bmfr/bmfr.php?id=HLB0009009
} else if ($requri === '/abap/bmfr/index.html') {
    $target = 'abap/bmfr/index.php';
} else if (startsWith($requri, '/abap/bmfr/index-') && endsWith($requri, '.html')) {
    $index = substr($requri, 17, -5);
    $target = 'abap/bmfr/index.php';
} else if (startsWith($requri, '/abap/bmfr/') && endsWith($requri, '.html')) {
    $ObjID = substr($requri, 11, -5);
    $target = 'abap/bmfr/bmfr.php';
// - CVERS - Software Component
//   http://localhost/abap/cvers/index.html
//   http://localhost/abap/cvers/AIN.html
//   http://localhost/abap/cvers/cvers.php?id=AIN
} else if ($requri === '/abap/cvers/index.html') {
    $target = 'abap/cvers/index.php';
} else if (startsWith($requri, '/abap/cvers/') && endsWith($requri, '.html')) {
    $$ObjID = substr($requri, 12, -5);
    $target = 'abap/cvers/cvers.php';
// - DEVC - Package
} else if ($requri === '/abap/devc/index.html') {
    $target = 'abap/devc/index.php';
} else if (startsWith($requri, '/abap/devc/index-') && endsWith($requri, '.html')) {
    $index = substr($requri, 17, -5);
    $target = 'abap/devc/index.php';
} else if (startsWith($requri, '/abap/devc/') && endsWith($requri, '.html')) {
    $ObjID = substr($requri, 11, -5);
    $target = 'abap/devc/devc.php';
// DOMA - DDIC Domain
    

// Not Found
} else {
    $target = 'page404.php';
}

// Logging
error_log('dispatcher: ' . $requri . ' --> ' . $target);

// Navigation
include $target;
exit();
