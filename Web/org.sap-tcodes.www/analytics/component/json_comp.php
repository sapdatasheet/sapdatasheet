<?php
$__WS_ROOT__ = dirname(__FILE__, 4);           // Root folder for the Workspace
$__ROOT__ = dirname(__FILE__, 3);              // Root folder for Current web site

require_once ($__WS_ROOT__ . '/common-php/library/global.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_db.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_ui.php');
require_once ($__ROOT__ . '/include/site/site_global.php');
require_once ($__ROOT__ . '/include/site/site_ui.php');
GLOBAL_UTIL::UpdateSAPDescLangu();

$db_list = ABAPANA_DB_TABLE::ABAPTRAN_ANALYTICS_SOFTCOMP();
echo SITE_UI_ANALYTICS::List2Json_D3BubbleChart(SITE_UI_ANALYTICS::AnaComp_DB2UI($db_list));
