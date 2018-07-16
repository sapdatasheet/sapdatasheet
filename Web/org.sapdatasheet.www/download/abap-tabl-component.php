<?php
$__WS_ROOT__ = dirname(__FILE__, 3);
$__ROOT__ = dirname(__FILE__, 2);

require_once ($__WS_ROOT__ . '/common-php/library/global.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_db.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_ui.php');
require_once ($__WS_ROOT__ . '/common-php/library/download.php');
GLOBAL_UTIL::UpdateSAPDescLangu();

$tabname = strtoupper(filter_input(INPUT_GET, 'tabname'));
$format = strtoupper(filter_input(INPUT_GET, 'format'));
if ($format != DOWNLOAD::FORMAT_XLS && $format != DOWNLOAD::FORMAT_XLSX) {
    $format = DOWNLOAD::FORMAT_CSV;
}

if (strlen(trim($tabname)) > 0) {
    // Load Data
    $result = ABAP_DB_TABLE_TABL::DD03L_List($tabname);

    // Download the file
    $filename = 'sap-table-' . GLOBAL_UTIL::SlashEscape($tabname) . '.' . strtolower($format);
    download_query($format, $result, $filename);
} else {
    exit('The table name is invalid');
}

/**
 * Download the query result as a file.
 */
function download_query(string $format, array $result, string $filename) {
    if (count($result) > 0) {
        if ($format === DOWNLOAD::FORMAT_XLS) {
            DOWNLOAD::AsXLS($result, $filename);
        } else if ($format === DOWNLOAD::FORMAT_XLSX) {
            DOWNLOAD::AsXLSX($result, $filename);
        } else {
            DOWNLOAD::AsCSV($result, $filename);
        }
    } else {
        exit('Unfortunately no data found in database. Please check the input paramter.');
    }
}
