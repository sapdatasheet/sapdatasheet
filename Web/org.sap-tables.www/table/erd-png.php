<?php
$__WS_ROOT__ = dirname(__FILE__, 3);
$__ROOT__ = dirname(__FILE__, 2);

require_once ($__ROOT__ . '/include/erd.php');
GLOBAL_UTIL::UpdateSAPDescLangu();

$erd = new ERD('MSEG', ERD_Format::png);
$png_file_path = $erd->run();

header("Content-Type: image/png");
header("Content-Length: " . filesize($png_file_path));
readfile($png_file_path);
// fpassthru(fopen($png_file_path, 'rb'));

// $data = file_get_contents($png_file_path);
// $base64 = 'data:image/' . ERD_Format::png . ';base64,' . base64_encode($data);
// echo $base64;

exit;
