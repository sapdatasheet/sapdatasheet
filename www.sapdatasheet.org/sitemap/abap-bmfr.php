<?php
$__ROOT__ = dirname(dirname(__FILE__));
require_once ($__ROOT__ . '/include/global.php');
require_once ($__ROOT__ . '/include/abap_db.php');
require_once ($__ROOT__ . '/include/sitemap.php');

$obj_type = 'bmfr';
$list = ABAP_DB_TABLE_HIER::DF14L_Sitemap();
$column_name = 'FCTR_ID';

Sitemap4ABAPOType($obj_type, $list, $column_name);