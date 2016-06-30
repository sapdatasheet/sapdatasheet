<?php

$__ROOT__ = dirname(dirname(__FILE__));
require_once ($__ROOT__ . '/include/common/global.php');
require_once ($__ROOT__ . '/include/common/abap_db.php');
require_once ($__ROOT__ . '/include/common/abap_ui.php');
require_once ($__ROOT__ . '/include/common/sitemap.php');

$obj_type = 'view';
$list = ABAP_DB_TABLE_VIEW::DD25L_Sitemap();
$column_name = 'VIEWNAME';

Sitemap4ABAPOType($obj_type, $list, $column_name);
