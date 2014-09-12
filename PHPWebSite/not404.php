<?php

require_once 'include/global.php';

$req = $_SERVER['REQUEST_URI'];
// echo $req;

if ($req == '/') {
    include 'index.php';
    exit();
} else if ($req == '/abap/') {
    include 'abap/index.php';
    //exit();
} else if ($req == '/abap/doma/') {
    include 'abap/doma/index.php';
    exit();
} else if ($req == '/abap/tabl/bkpf.html') {
    $Table = 'bkpf';
    include 'abap/tabl/tabl.php';
    exit();
}
?>
