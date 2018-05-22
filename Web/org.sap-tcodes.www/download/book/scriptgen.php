<?php
// Script Generator for Books

$__WS_ROOT__ = dirname(__FILE__, 4);           // Root folder for the Workspace
$__ROOT__ = dirname(__FILE__, 3);              // Root folder for Current web site

require_once ($__WS_ROOT__ . '/common-php/library/global.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_db.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_ui.php');


echo "#!/bin/sh";
echo "\n";

$module_l1_list = ABAPANA_DB_TABLE::ABAPTRAN_ANALYTICS_PS_POSID_L1();
foreach ($module_l1_list as $item) {
    $filename = ABAP_UI_TCODES_Navigation::BookName4Module($item['PS_POSID_L1']); 
    $target = ABAP_UI_TCODES_Navigation::DistPath($filename);
    echo 'echo "Generating PDF file for ' . $item['PS_POSID_L1'] .'"';
    echo "\n";
    echo 'sudo php pdf-module.php ' . $item['PS_POSID_L1'] . ' >> ' . $target;
    echo "\n";
}
