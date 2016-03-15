<?php
$__ROOT__ = dirname(dirname(__FILE__));
require_once ($__ROOT__ . '/include/global.php');
require_once ($__ROOT__ . '/include/abap_db.php');
require_once ($__ROOT__ . '/include/sitemap.php');

$obj_type = 'sqlt';
$list = ABAP_DB_TABLE_TABL::DD06L_List();
$column_name = 'SQLTAB';

Sitemap4ABAPOType($obj_type, $list, $column_name);
