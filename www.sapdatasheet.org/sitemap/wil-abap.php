<!-- Where Used List for ABAP Objects -->
<?php
$__ROOT__ = dirname(dirname(__FILE__));
require_once ($__ROOT__ . '/include/global.php');
require_once ($__ROOT__ . '/include/abap_db.php');
require_once ($__ROOT__ . '/include/abap_ui.php');
require_once ($__ROOT__ . '/include/sitemap.php');

$fname_prefix = 'wil-abap';
$list = ABAPANA_DB_TABLE::WILCOUNTER_Sitemap();
$i = 1;
$j = 1;
foreach ($list as $row) {
    if ($j == 1) {
        sitemapStartOB();
    }

    $wilurl = "http://www.sapdatasheet.org" . ABAP_Navigation::GetWilURL($row);
    sitemapEchoUrl($wilurl);

    // Check if the Sitemap is full
    $j++;
    if ($j >= SITEMAP::MAX_URL_COUNT) {
        sitemapEndOB($fname_prefix, $i);
        $i++;
        $j = 1;
    }

    // If several pages exists ...
    if ($row['COUNTER'] > ABAP_DB_CONST::INDEX_PAGESIZE) {
        $urls = ABAP_Navigation::GetWilURLs($row['OBJ_TYPE'], $row['OBJ_NAME'], $row['SRC_OBJ_TYPE'], $row['COUNTER']);
        foreach ($urls as $wilurl) {
            sitemapEchoUrl("http://www.sapdatasheet.org" . $wilurl);

            // Check if the Sitemap is full
            $j++;
            if ($j >= SITEMAP::MAX_URL_COUNT) {
                sitemapEndOB($fname_prefix, $i);
                $i++;

                $j = 1;
                sitemapStartOB();
            }
        }
    }
} // End foreach

if ($j > 1) {
    sitemapEndOB($fname_prefix, $i);
}
