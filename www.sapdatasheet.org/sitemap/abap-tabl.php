<?php
$__ROOT__ = dirname(dirname(__FILE__));
require_once ($__ROOT__ . '/include/global.php');
require_once ($__ROOT__ . '/include/abap_db.php');
require_once ($__ROOT__ . '/include/sitemap.php');

$obj_type = 'tabl';
$list = ABAP_DB_TABLE_TABL::DD02L_Sitemap();
$column_name = 'TABNAME';

Sitemap4ABAPOType($obj_type, $list, $column_name);
