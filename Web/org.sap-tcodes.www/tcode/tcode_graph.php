<?php

$__WS_ROOT__ = dirname(__FILE__, 3);           // Root folder for the Workspace
$__ROOT__ = dirname(__FILE__, 2);              // Root folder for Current web site

require_once ($__WS_ROOT__ . '/common-php/library/global.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_db.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_ui.php');
require_once ($__WS_ROOT__ . '/common-php/library/graphviz.php');
require_once ($__ROOT__ . '/include/site/site_ui.php');
GLOBAL_UTIL::UpdateSAPDescLangu();

# Check parameter
$tcode = filter_input(INPUT_GET, ABAP_UI_TCODES_Navigation::SHEET_PARAMETER_ID);
if (empty($tcode)) {
    echo 'ERROR: No parameter provided.';
    exit(0);
}

# Check the TCode exists
$abaptran = ABAPANA_DB_TABLE::ABAPTRAN(strtoupper($tcode));
if (empty($abaptran['TCODE'])) {
    echo 'ERROR: No data found for tcode ' . $tcode;
    exit(0);
}

# Layout of the graph
$layout = strtolower(filter_input(INPUT_GET, ABAP_UI_TCODES_Navigation::GRAPHVIZ_LAYOUT));
if (!in_array($layout, TCodeGraphviz::$LAYOUTS)) {
    $layout = TCodeGraphviz::layout_dot;
}

# Check 
$analytics_list = SITE_UI_TCODE::LoadAnalytics($abaptran);
$output_file_path = (new TCodeGraphviz($abaptran, $analytics_list))->run($layout);
if (GLOBAL_UTIL::IsNotEmpty($output_file_path)) {
    header("Content-Type: image/svg+xml");
    header("Content-Length: " . filesize($output_file_path));
    readfile($output_file_path);
    // unlink($output_file_path);
} else {
    header("Content-Type: html/text");
    header("Content-Length: 0");
}
