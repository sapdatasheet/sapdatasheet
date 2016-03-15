<?php
$__ROOT__ = dirname(dirname(__FILE__));
require_once ($__ROOT__ . '/include/global.php');
require_once ($__ROOT__ . '/include/abap_db.php');
require_once ($__ROOT__ . '/include/sitemap.php');

$obj_type = 'devc';
$list = ABAP_DB_TABLE_HIER::TDEVC_Sitemap();
$column_name = 'DEVCLASS';

Sitemap4ABAPOType($obj_type, $list, $column_name);
