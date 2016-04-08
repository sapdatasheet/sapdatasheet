<!-- Where Used List for ABAP Objects -->
<?php
$__ROOT__ = dirname(dirname(__FILE__));
require_once ($__ROOT__ . '/include/common/global.php');
require_once ($__ROOT__ . '/include/common/abap_db.php');
require_once ($__ROOT__ . '/include/common/abap_ui.php');
require_once ($__ROOT__ . '/include/common/sitemap.php');

$fname_prefix = 'wul-abap';
$list = ABAPANA_DB_TABLE::WULCOUNTER_Sitemap();
$i = 1;
$j = 1;
foreach ($list as $row) {
    if ($j == 1) {
        SitemapStartOB();
    }

    $wulurl = "http://www.sapdatasheet.org" . ABAP_UI_Navigation::GetWulURL($row);
    SitemapEchoUrl($wulurl);

    // Check if the Sitemap is full
    $j++;
    if ($j >= SITEMAP::MAX_URL_COUNT) {
        SitemapEndOB($fname_prefix, $i);
        $i++;
        $j = 1;
    }

    if ($row['COUNTER'] > ABAP_DB_CONST::INDEX_PAGESIZE) {
        $urls = ABAP_UI_Navigation::GetWulURLs(
                $row['SRC_OBJ_TYPE'], $row['SRC_OBJ_NAME'], $row['SRC_SUBOBJ'], $row['OBJ_TYPE'], $row['COUNTER']);
        foreach ($urls as $wulurl) {
            SitemapEchoUrl("http://www.sapdatasheet.org" . $wulurl);

            // Check if the Sitemap is full
            $j++;
            if ($j >= SITEMAP::MAX_URL_COUNT) {
                SitemapEndOB($fname_prefix, $i);
                $i++;

                $j = 1;
                SitemapStartOB();
            }
        }
    }
} // End foreach

if ($j > 1) {
    SitemapEndOB($fname_prefix, $i);
}
