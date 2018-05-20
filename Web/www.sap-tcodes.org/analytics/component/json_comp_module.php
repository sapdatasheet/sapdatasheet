<?php
$__ROOT__ = dirname(dirname(dirname(__FILE__)));
require_once ($__ROOT__ . '/include/common/global.php');
require_once ($__ROOT__ . '/include/common/abap_db.php');
require_once ($__ROOT__ . '/include/common/abap_ui.php');
require_once ($__ROOT__ . '/include/site/site_global.php');
require_once ($__ROOT__ . '/include/site/site_ui.php');

GLOBAL_UTIL::UpdateSAPDescLangu();

$softcomp = filter_input(INPUT_GET, 'id');
if (empty($softcomp)) {
    $softcomp = 'SAP_BASIS';
}

$db_list = ABAPANA_DB_TABLE::ABAPTRAN_ANALYTICS_SOFTCOMP_APPLPOSID(strtoupper($softcomp));
echo SITE_UI_ANALYTICS::List2Json_D3BubbleChart(SITE_UI_ANALYTICS::AnaCompModule_DB2UI($db_list));
