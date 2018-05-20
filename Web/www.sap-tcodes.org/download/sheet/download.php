<?php

$__ROOT__ = dirname(dirname(dirname(__FILE__)));
require_once ($__ROOT__ . '/include/common/global.php');
require_once ($__ROOT__ . '/include/common/abap_db.php');
require_once ($__ROOT__ . '/include/common/abap_ui.php');
require_once ($__ROOT__ . '/include/common/download.php');

GLOBAL_UTIL::UpdateSAPDescLangu();

/**
 * @param string  $filter  Filter type: module, component, name
 * @param string  $id      Module name or Component name
 * @param string  $format  File format: csv, xls, xlsx
 * 
 * <pre>
 * download.php?filter=module&id=fi&format=csv
 * download.php?filter=module&id=fi&format=xls
 * download.php?filter=module&id=fi&format=xlsx
 * download.php?filter=component&id=dmis&format=csv
 * download.php?filter=component&id=dmis&format=xls
 * download.php?filter=component&id=dmis&format=xlsx
 * </pre>
 */
if (php_sapi_name() == 'cli') {
    $param_filter = strtolower($argv[1]);
    $param_id = strtoupper($argv[2]);
    $param_format = strtoupper($argv[3]);
} else {
    $param_filter = strtolower(filter_input(INPUT_GET, ABAP_UI_TCODES_Navigation::SHEET_PARAMETER_FILTER));
    $param_id = strtoupper(filter_input(INPUT_GET, ABAP_UI_TCODES_Navigation::SHEET_PARAMETER_ID));
    $param_format = strtoupper(filter_input(INPUT_GET, ABAP_UI_TCODES_Navigation::SHEET_PARAMETER_FORMAT));
}

if (strlen(trim($param_filter)) < 1) {
    exit('Download parameter FILTER is not set');
}
if (strlen(trim($param_id)) < 1) {
    exit('Download parameter ID is not set');
}
if (strlen(trim($param_format)) < 1) {
    exit('Download parameter FORMAT is not set');
}

// Load TCodes
if ($param_filter == ABAP_UI_TCODES_Navigation::SHEET_PARAMETER_FILTER_MODULE) {
    $tcode_list = ABAPANA_DB_TABLE::ABAPTRAN_DOANLOAD(ABAPANA_DB_TABLE::ABAPTRAN_PS_POSID_L1, $param_id, FALSE);
} else if ($param_filter == ABAP_UI_TCODES_Navigation::SHEET_PARAMETER_FILTER_COMPONENT) {
    $tcode_list = ABAPANA_DB_TABLE::ABAPTRAN_DOANLOAD(ABAPANA_DB_TABLE::ABAPTRAN_SOFTCOMP, $param_id, FALSE);
} else if ($param_filter == ABAP_UI_TCODES_Navigation::SHEET_PARAMETER_FILTER_NAME) {
    $tcode_list = ABAPANA_DB_TABLE::ABAPTRAN_NAMEPATTERN_DOWNLOAD($param_id . '%');
}

if (empty($tcode_list) || count($tcode_list) < 1) {
    print_r($_REQUEST);
    exit("<br>No data loaded for your reqeust");
}

// Add additional fields 
foreach ($tcode_list as &$tcode_item) {
    $tcode_item['TCODE_DESC'] = ABAP_DB_TABLE_TRAN::TSTCT($tcode_item['TCODE']);
    $tcode_item['TCODE_URL'] = ABAP_UI_TCODES_Navigation::TCode($tcode_item['TCODE'], TRUE);
    $tcode_item['PACKAGE_DESC'] = ABAP_DB_TABLE_HIER::TDEVCT($tcode_item['PACKAGE']);
    $tcode_item['MODULE_DESC'] = ABAPANA_DB_TABLE::ABAPBMFR_TEXT($tcode_item['MODULE']);
    $tcode_item['MODULE_URL'] = ABAP_UI_TCODES_Navigation::AnalyticsModulePath($tcode_item['MODULE'], TRUE);
    $tcode_item['MODULE_TOP_DESC'] = ABAPANA_DB_TABLE::ABAPBMFR_TEXT($tcode_item['MODULE_TOP']);
    $tcode_item['MODULE_TOP_URL'] = ABAP_UI_TCODES_Navigation::AnalyticsModulePath($tcode_item['MODULE_TOP'], TRUE);
    $tcode_item['COMPONENT_DESC'] = ABAP_DB_TABLE_HIER::CVERS_REF($tcode_item['COMPONENT']);
    $tcode_item['COMPONENT_URL'] = ABAP_UI_TCODES_Navigation::AnalyticsCompPath($tcode_item['COMPONENT'], TRUE);
}

$filename = ABAP_UI_TCODES_Navigation::SheetName($param_filter, $param_id, $param_format);

if ($param_format == DOWNLOAD::FORMAT_XLS) {
    DOWNLOAD::AsXLS($tcode_list, $filename);
} else if ($param_format == DOWNLOAD::FORMAT_XLSX) {
    DOWNLOAD::AsXLSX($tcode_list, $filename);
} else if ($param_format == DOWNLOAD::FORMAT_CSV) {
    DOWNLOAD::AsCSV($tcode_list, $filename);
}
