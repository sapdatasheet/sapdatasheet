<?php
$__WS_ROOT__ = dirname(__FILE__, 3);

require_once ($__WS_ROOT__ . '/common-php/library/global.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_db.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_ui.php');
require_once ($__WS_ROOT__ . '/common-php/library/sitemap.php');

$obj_type = 'shlp';
$list = ABAP_DB_TABLE_SHLP::DD30L_Sitemap();
$column_name = 'SHLPNAME';

Sitemap4ABAPOType($obj_type, $list, $column_name);
