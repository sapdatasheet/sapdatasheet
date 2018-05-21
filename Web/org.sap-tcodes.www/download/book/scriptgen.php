<?php
// Script Generator for Books

$__ROOT__ = dirname(dirname(dirname(__FILE__)));
require_once ($__WS_ROOT__ . '/common-php/library/global.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_db.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_ui.php');


$module_l1_list = ABAPANA_DB_TABLE::ABAPTRAN_ANALYTICS_PS_POSID_L1();
foreach ($module_l1_list as $item) {
    $filename = ABAP_UI_TCODES_Navigation::BookName4Module($item['PS_POSID_L1']); 
    $target = ABAP_UI_TCODES_Navigation::DistPath($filename);
    echo 'php pdf-module.php ' . $item['PS_POSID_L1'] . ' >> ' . $target;
    echo "\r\n";
}
