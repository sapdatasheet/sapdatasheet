<?php
$__ROOT__ = dirname(dirname(dirname(__FILE__)));
require_once ($__WS_ROOT__ . '/common-php/library/global.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_db.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_ui.php');
require_once ($__ROOT__ . '/include/site/site_global.php');
require_once ($__ROOT__ . '/include/site/site_ui.php');

$db_list = ABAPANA_DB_TABLE::ABAPTRAN_ANALYTICS_NAME_LEFT1();
echo SITE_UI_ANALYTICS::List2Json_D3BubbleChart(SITE_UI_ANALYTICS::AnaName_DB2UI($db_list));
