<?php
$__ROOT__ = dirname(dirname(__FILE__));
require_once ($__ROOT__ . '/include/global.php');
require_once ($__ROOT__ . '/include/abap_db.php');
require_once ($__ROOT__ . '/include/sitemap.php');

$obj_type = 'msag';
$list = ABAP_DB_TABLE_MSAG::T100A_List();
$column_name = 'ARBGB';

Sitemap4ABAPOType($obj_type, $list, $column_name);
