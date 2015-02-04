<?php

define('__ROOT__', dirname(dirname(__FILE__)));
require_once (__ROOT__ . '/include/global.php');
require_once (__ROOT__ . '/include/abap_db.php');
require_once (__ROOT__ . '/include/abap_ui.php');

$tabname = strtoupper(filter_input(INPUT_GET, 'tabname'));

if (strlen(trim($tabname)) > 0) {
    // Download the file
    // SELECT * FROM abap.dd03l where TABNAME = 'BKPF' ORDER BY POSITION;

    $con = ABAP_DB_SCHEMA::getConnection();
    $tabname = $con->real_escape_string($tabname);
    $sql = "SELECT * FROM " . ABAP_DB_TABLE_TABL::DD03L
            . " where TABNAME = '" . $tabname . "' ORDER BY POSITION";
    $result = $con->query($sql);

    if (mysqli_num_rows($result) > 0) {
        query_to_csv($result, 'sap-table-' . $tabname . '.csv');
    } else {
        echo 'Cannot found table columns for the specified table: ' . $tabname;
    }
} else {
    echo 'The table name is invalid';
}

function query_to_csv($result, $filename) {

    // send response headers to the browser
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename=' . $filename);
    $fp = fopen('php://output', 'w');

    // output header row (if at least one row exists)
    $row = mysqli_fetch_assoc($result);
    if ($row) {
        fputcsv($fp, array_keys($row));
        // reset pointer back to beginning
        mysqli_data_seek($result, 0);
    }

    while ($row = mysqli_fetch_assoc($result)) {
        fputcsv($fp, $row);
    }

    fclose($fp);
}
