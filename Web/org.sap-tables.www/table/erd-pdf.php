<?php
$__WS_ROOT__ = dirname(__FILE__, 3);
$__ROOT__ = dirname(__FILE__, 2);

// Reference for download a file
// https://stackoverflow.com/questions/20080341/correct-php-headers-for-pdf-file-download

require_once ($__ROOT__ . '/include/erd.php');
require_once ($__ROOT__ . '/include/site_tables_ui.php');
GLOBAL_UTIL::UpdateSAPDescLangu();

$table_name = strtoupper(filter_input(INPUT_GET, SITE_TABLES_UI_CONST::HTTP_GET_TABLE));
if (strlen($table_name) < 1) {
    exit(-1);
}

$erd = new ERD($table_name, ERD_Format::pdf);
$file_path = $erd->run();

header("Content-Type: application/pdf");
header("Content-Length: " . filesize($file_path));
//echo '<pre>';
readfile($file_path);
//echo '</pre>';
// fpassthru(fopen($png_file_path, 'rb'));

// $data = file_get_contents($png_file_path);
// $base64 = 'data:image/' . ERD_Format::png . ';base64,' . base64_encode($data);
// echo $base64;

exit;
