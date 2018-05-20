<?php

$__ROOT__ = dirname(dirname(__FILE__));
require_once ($__ROOT__ . '/include/common/global.php');
require_once ($__ROOT__ . '/include/common/abap_db.php');
require_once ($__ROOT__ . '/include/common/abap_ui.php');
require_once ($__ROOT__ . '/include/common/sitemap.php');

$fname_prefix = pathinfo(__FILE__, PATHINFO_FILENAME);
$list = ABAPANA_DB_TABLE::ABAPTRAN_Sitemap_TCode();
$i = 1;
$j = 1;
foreach ($list as $row) {
    if ($j == 1) {
        SitemapStartOB();
    }

    $url = ABAP_UI_TCODES_Navigation::TCode($row['TCODE'], TRUE);
    SitemapEchoUrl($url, '0.8');

    // Check if the Sitemap is full
    $j++;
    if ($j >= SITEMAP::MAX_URL_COUNT) {
        SitemapEndOB($fname_prefix, $i);
        $i++;
        $j = 1;
    }
} // End foreach

if ($j > 1) {
    SitemapEndOB($fname_prefix, $i);
}

