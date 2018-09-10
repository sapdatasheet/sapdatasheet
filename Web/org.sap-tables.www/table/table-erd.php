<?php

$__WS_ROOT__ = dirname(__FILE__, 3);
$__ROOT__ = dirname(__FILE__, 2);

require_once ($__WS_ROOT__ . '/common-php/library/erd.php');
GLOBAL_UTIL::UpdateSAPDescLangu();

$format = $fbk_format;
$table_name = $fbk_table_name;
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
if (GLOBAL_UTIL::IsNotEmpty($output_file_path)) {
    header("Content-Type: " . $content_type);
    header("Content-Length: " . filesize($output_file_path));
    readfile($output_file_path);
    
    unlink($output_file_path);
} else {
    header("Content-Type: " . $content_type);
    header("Content-Length: 0");
}

// Other Options
// fpassthru(fopen($output_file_path, 'rb'));
// $data = file_get_contents($output_file_path);
// $base64 = 'data:image/' . ERD_Format::png . ';base64,' . base64_encode($data);
// echo $base64;

exit;
