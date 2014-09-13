<?php

$requri = $_SERVER['REQUEST_URI'];
$target = '/';

if ($requri == '/') {
    $target = 'index.php';
} else if ($requri == '/abap/') {
    $target = 'abap/index.php';
} else if ($requri == '/abap/doma/') {
    $target = 'abap/doma/index.php';
} else if ($requri == '/abap/tabl/bkpf.html') {
    $Table = 'bkpf';
    $target = 'abap/tabl/tabl.php';
}

error_log('dispatcher: ' . $requri . ' --> ' . $target);

include $target;
exit();

