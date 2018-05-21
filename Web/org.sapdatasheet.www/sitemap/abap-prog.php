<?php
$__WS_ROOT__ = dirname(__FILE__, 3);

require_once ($__WS_ROOT__ . '/common-php/library/global.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_db.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_ui.php');
require_once ($__WS_ROOT__ . '/common-php/library/sitemap.php');

$obj_type = 'prog';
$list = ABAP_DB_TABLE_HIER::TADIR_PROG_Sitemap();
$column_name = 'OBJ_NAME';

Sitemap4ABAPOType($obj_type, $list, $column_name);
