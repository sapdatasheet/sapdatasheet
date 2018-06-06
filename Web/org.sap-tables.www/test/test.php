<?php

/**
 * Test Script will generate the E-R Diagram for Each table, in order to detect issues.
 */
$__WS_ROOT__ = dirname(__FILE__, 3);
$__ROOT__ = dirname(__FILE__, 2);

require_once ($__ROOT__ . '/include/erd.php');
require_once ($__ROOT__ . '/include/site_tables_ui.php');
GLOBAL_UTIL::UpdateSAPDescLangu();

$count = 0;
$dd02l_list = ABAP_DB_TABLE_TABL::DD02L_Sitemap();
$dd02l_list_count = count($dd02l_list);
foreach ($dd02l_list as $dd02l) {
    $count++;

    // In Dev box, we test for limited cases
    // if ($count > 9000) {
    //    break;
    //}

    $filename = ERD::escape($dd02l['TABNAME']);

    foreach (ERD_Format::enabledFormats() as $format) {

        echo number_format($count) . '-' . $format . ' ('
        . number_format($count * 100 / $dd02l_list_count, 4) . '%)'
        . '. Table {' . $dd02l['TABNAME'] . '} Processing started. ';

        $erd = new ERD($format, $dd02l['TABNAME']);
        $er_file = $filename . '-' . $format . '.er';
        file_put_contents($er_file, $erd->process());

        $output_file_path = $erd->run();
        $log_text = 'format [' . $format . '] result ';
        if (strlen($output_file_path) > 0) {
            // We do not have to copy the result files
            // 
            // $cmd_cp = 'cp ' . $output_file_path . ' ' . $filename . '.' . $format;
            // shell_exec($cmd_cp);
            echo $log_text . ' Succeed ' . PHP_EOL;

            // Clear the E-R file if succeed
            unlink($er_file);
        } else {
            echo $log_text . ' Failed !!! ==========  ==========  ==========' . PHP_EOL;
            sleep(2);
        }

        unlink($output_file_path);
    }
}
