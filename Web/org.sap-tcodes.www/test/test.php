<?php

/**
 * Test Script will generate the Graphviz Diagram for Each table, in order to detect issues.
 */
$__WS_ROOT__ = dirname(__FILE__, 3);
$__ROOT__ = dirname(__FILE__, 2);

require_once ($__WS_ROOT__ . '/common-php/library/global.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_db.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_ui.php');
require_once ($__ROOT__ . '/include/site/site_ui.php');
GLOBAL_UTIL::UpdateSAPDescLangu();


$tran_list = ABAPANA_DB_TABLE::ABAPTRAN_Sitemap_TCode();
$tran_list_count = count($tran_list);

$error_count = 0;
$error_list = array();

$count = 0;
foreach ($tran_list as $tran) {
    $count++;

    // In Dev box, we test for limited cases
    //if ($count > 100) {
    //    break;
    //}
    if ($count < 15000) {
        continue;
    }

    $tcode = $tran['TCODE'];
    echo PHP_EOL;
    echo number_format($count) . ' - (' . number_format($count * 100 / $tran_list_count, 4) . '%). TCode {' . $tcode . '} Processing started.';
    
    $abaptran = ABAPANA_DB_TABLE::ABAPTRAN(strtoupper($tcode));
    $analytics_list = SITE_UI_TCODE::LoadAnalytics($abaptran);
    $graphviz = new TCodeGraphviz($abaptran, $analytics_list);
    foreach (TCodeGraphviz::$LAYOUTS as $layout) {
        $output_file_path = $graphviz->run($layout);
        if (GLOBAL_UTIL::IsEmpty($output_file_path)) {
            $error_count++;
            echo $log_text . '!!! ==========  ==========  ========== Failed for {' . $tcode . '}, layout {' . $layout . '}' . PHP_EOL;
            sleep(2);
        } else {
            echo ' Output file name: ' . $output_file_path;
        }
    }
    
    if ($error_count > 10) {
        break;
    }
}

echo PHP_EOL;
echo 'Total records ' . $tran_list_count . PHP_EOL;
echo 'Error records ' . $error_count . PHP_EOL;
echo "Finished";
