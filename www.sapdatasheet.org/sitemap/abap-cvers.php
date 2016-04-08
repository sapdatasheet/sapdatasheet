<?php
$__ROOT__ = dirname(dirname(__FILE__));
require_once ($__ROOT__ . '/include/common/global.php');
require_once ($__ROOT__ . '/include/common/abap_db.php');
require_once ($__ROOT__ . '/include/common/sitemap.php');

$obj_type = 'cvers';
$list = ABAP_DB_TABLE_HIER::CVERS_List();
$column_name = 'COMPONENT';

Sitemap4ABAPOType($obj_type, $list, $column_name);
