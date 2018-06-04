<?php

$__WS_ROOT__ = dirname(__FILE__, 3);
$__ROOT__ = dirname(__FILE__, 2);

require_once ($__ROOT__ . '/include/erd.php');
require_once ($__ROOT__ . '/include/site_tables_ui.php');
GLOBAL_UTIL::UpdateSAPDescLangu();

$format = strtolower(filter_input(INPUT_GET, SITE_TABLES_UI_CONST::HTTP_GET_FORMAT));
$table_name = strtoupper(filter_input(INPUT_GET, SITE_TABLES_UI_CONST::HTTP_GET_TABLE));
if (strlen($format) < 1 || strlen($table_name) < 1) {
    // Invalid parameter
    exit(-1);
}

if ($format == ERD_Format::png) {
    $content_type = 'image/png';
} else if ($format == ERD_Format::pdf) {
    $content_type = 'application/pdf';
} else {
    // Un-recognized format
    exit(-1);
}

$output_file_path = (new ERD($format, $table_name))->run();

header("Content-Type: " . $content_type);
header("Content-Length: " . filesize($output_file_path));
readfile($output_file_path);

// Other Options
// fpassthru(fopen($output_file_path, 'rb'));
// $data = file_get_contents($output_file_path);
// $base64 = 'data:image/' . ERD_Format::png . ';base64,' . base64_encode($data);
// echo $base64;

exit;
