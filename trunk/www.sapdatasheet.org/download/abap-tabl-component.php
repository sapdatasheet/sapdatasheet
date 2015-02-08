<?php

$__ROOT__ = dirname(dirname(__FILE__));
require_once ($__ROOT__ . '/include/global.php');
require_once ($__ROOT__ . '/include/abap_db.php');
require_once ($__ROOT__ . '/include/abap_ui.php');
require_once ($__ROOT__ . '/include/library/php-export-data/php-export-data.class.php');
include_once ($__ROOT__ . "/include/library/php_xlsxwriter/xlsxwriter.class.php");

$tabname = strtoupper(filter_input(INPUT_GET, 'tabname'));
$format = strtoupper(filter_input(INPUT_GET, 'format'));
if ($format != DOWNLOAD::FORMAT_XLS && $format != DOWNLOAD::FORMAT_XLSX) {
    $format = DOWNLOAD::FORMAT_CSV;
}

if (strlen(trim($tabname)) > 0) {
    // Download the file
    // Load Data
    // SELECT * FROM abap.dd03l where TABNAME = 'BKPF' ORDER BY POSITION;
    $con = ABAP_DB_SCHEMA::getConnection();
    $tabname = $con->real_escape_string($tabname);
    $sql = "SELECT * FROM " . ABAP_DB_TABLE_TABL::DD03L
            . " where TABNAME = '" . $tabname . "' ORDER BY POSITION";
    $result = $con->query($sql);

    // Download
    download_query($format, $result, 'sap-table-' . $tabname);
} else {
    echo 'The table name is invalid';
}

/**
 * Download the query resutl as a file.
 */
function download_query($format, $result, $filename) {
    if (mysqli_num_rows($result) > 0) {
        if ($format === DOWNLOAD::FORMAT_XLS) {
            query_to_xls($result, $filename);
        } else if ($format === DOWNLOAD::FORMAT_XLSX) {
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
    header('Content-Disposition: attachment;filename=' . $filename . '.' . strtolower(DOWNLOAD::FORMAT_CSV));
    $fp = fopen('php://output', 'w');

    // output header row (if at least one row exists)
    $row = mysqli_fetch_assoc($result);
    if ($row) {
        fputcsv($fp, array_keys($row));
        mysqli_data_seek($result, 0);    // reset pointer back to beginning
    }

    // output each row
    while ($row = mysqli_fetch_assoc($result)) {
        fputcsv($fp, $row);
    }

    fclose($fp);
}

/**
 * Download the file in Excel 2003 XML format (.xls).
 */
function query_to_xls($result, $filename) {
    $exporter = new ExportDataExcel('browser', $filename . '.' . strtolower(DOWNLOAD::FORMAT_XLS));
    $exporter->title = $filename;
    $exporter->initialize();                  // starts streaming data to web browser
    // Table Header
    $row = mysqli_fetch_assoc($result);
    if ($row) {
        $exporter->addRow(array_keys($row));
        mysqli_data_seek($result, 0);         // reset pointer back to beginning
    }

    // Table Rows
    while ($row = mysqli_fetch_assoc($result)) {
        $exporter->addRow(array_values($row));
    }

    $exporter->finalize();                    // writes the footer, flushes remaining data to browser.
    exit();                                   // all done
}

/**
 * Download the file in Excel 2007+ format (.xlsx).
 */
function query_to_xlsx($result, $filename) {
    header('Content-disposition: attachment; filename="' . XLSXWriter::sanitize_filename($filename . '.' . strtolower(DOWNLOAD::FORMAT_XLSX)) . '"');
    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
    header('Content-Transfer-Encoding: binary');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');

    $row = mysqli_fetch_assoc($result);
    if ($row) {
        $header = $row;
        mysqli_data_seek($result, 0);         // reset pointer back to beginning
    }

    $rows = array();
    while ($row = mysqli_fetch_assoc($result)) {
        array_push($rows, array_values($row));
    }

    $writer = new XLSXWriter();
    $writer->setAuthor('www.sapdatasheet.org');
    $writer->writeSheet($rows, $filename, $header);
    $writer->writeToStdOut();
    exit(0);
}
