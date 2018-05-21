<?php

$__ROOT__ = dirname(dirname(__FILE__));
require_once ($__WS_ROOT__ . '/common-php/library/global.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_db.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_ui.php');
require_once ($__ROOT__ . '/include/site/site_global.php');
require_once ($__ROOT__ . '/include/site/site_ui.php');

GLOBAL_UTIL::UpdateSAPDescLangu();

$tcode = filter_input(INPUT_GET, 'id');
if (empty($tcode)) {
    echo '';
} else {
    $abaptran = ABAPANA_DB_TABLE::ABAPTRAN(strtoupper($tcode));
    $analytics_list = SITE_UI_TCODE::LoadAnalytics($abaptran);
    echo SITE_UI_TCODE::List2Json($tcode, $analytics_list);
}
