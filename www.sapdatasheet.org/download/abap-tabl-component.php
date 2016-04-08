<?php

$__ROOT__ = dirname(dirname(__FILE__));
require_once ($__ROOT__ . '/include/common/global.php');
require_once ($__ROOT__ . '/include/common/abap_db.php');
require_once ($__ROOT__ . '/include/common/abap_ui.php');
require_once ($__ROOT__ . '/include/3rdparty/php-export-data/php-export-data.class.php');
include_once ($__ROOT__ . "/include/3rdparty/php_xlsxwriter/xlsxwriter.class.php");

$tabname = strtoupper(filter_input(INPUT_GET, 'tabname'));
$format = strtoupper(filter_input(INPUT_GET, 'format'));
if ($format != GLOBAL_DOWNLOAD::FORMAT_XLS && $format != GLOBAL_DOWNLOAD::FORMAT_XLSX) {
    $format = GLOBAL_DOWNLOAD::FORMAT_CSV;
}

if (strlen(trim($tabname)) > 0) {
    // Download the file
    // Load Data
    // SELECT * FROM abap.dd03l where TABNAME = 'BKPF' ORDER BY POSITION;
    $sql = "SELECT * FROM " . ABAP_DB_TABLE_TABL::DD03L
            . " where TABNAME = :id ORDER BY POSITION";
    $result = ABAP_DB_TABLE::select_1filter($sql, $tabname);

    // Download
    download_query($format, $result, 'sap-table-' . $tabname);
} else {
    echo 'The table name is invalid';
}

/**
 * Download the query resutl as a file.
 */
function download_query($format, $result, $filename) {
    if (count($result) > 0) {
        if ($format === GLOBAL_DOWNLOAD::FORMAT_XLS) {
            query_to_xls($result, $filename);
        } else if ($format === GLOBAL_DOWNLOAD::FORMAT_XLSX) {
            query_to_xlsx($result, $filename);
        } else {
            query_to_csv($result, $filename);
        }
    } else {
        echo 'Unfortunately no data found in database. Please check the input paramter.';
    }
}

/**
 * Download the file in CSV format
 */
function query_to_csv($result, $filename) {

    // send response headers to the browser
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename=' . $filename . '.' . strtolower(GLOBAL_DOWNLOAD::FORMAT_CSV));
    $fp = fopen('php://output', 'w');

    // output header row (if at least one row exists)
    fputcsv($fp, array_keys($result[0]));

    // output each row
    foreach ($result as $row) {
        fputcsv($fp, $row);
    }

    fclose($fp);
}

/**
 * Download the file in Excel 2003 XML format (.xls).
 */
function query_to_xls($result, $filename) {
    $exporter = new ExportDataExcel('browser', $filename . '.' . strtolower(GLOBAL_DOWNLOAD::FORMAT_XLS));
    $exporter->title = $filename;
    $exporter->initialize();                  // starts streaming data to web browser
    // Table Header
    $exporter->addRow(array_keys($result[0]));

    // Table Rows
    foreach ($result as $row) {
        $exporter->addRow(array_values($row));
    }

    $exporter->finalize();                    // writes the footer, flushes remaining data to browser.
    exit();                                   // all done
}

/**
 * Download the file in Excel 2007+ format (.xlsx).
 */
function query_to_xlsx($result, $filename) {
    header('Content-disposition: attachment; filename="' . XLSXWriter::sanitize_filename($filename . '.' . strtolower(GLOBAL_DOWNLOAD::FORMAT_XLSX)) . '"');
    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
    header('Content-Transfer-Encoding: binary');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');

    $header = array_keys($result[0]);
    $rows = array();
    foreach ($result as $row) {
        array_push($rows, array_values($row));
    }

    $writer = new XLSXWriter();
    $writer->setAuthor('www.sapdatasheet.org');
    $writer->writeSheet($rows, $filename, $header);
    $writer->writeToStdOut();
    exit(0);
}
