<!-- Where Used List for ABAP Objects -->
<?php
$__ROOT__ = dirname(dirname(__FILE__));
require_once ($__ROOT__ . '/include/common/global.php');
require_once ($__ROOT__ . '/include/common/abap_db.php');
require_once ($__ROOT__ . '/include/common/abap_ui.php');
require_once ($__ROOT__ . '/include/common/sitemap.php');

$fname_prefix = 'wil-abap';
$list = ABAPANA_DB_TABLE::WILCOUNTER_Sitemap();
$i = 1;
$j = 1;
foreach ($list as $row) {
    if ($j == 1) {
        SitemapStartOB();
    }

    $wilurl = GLOBAL_WEBSITE::URLPREFIX_SAPDS_ORG . ABAP_UI_DS_Navigation::GetWilPath($row);
    SitemapEchoUrl($wilurl, '0.4');

    // Check if the Sitemap is full
    $j++;
    if ($j >= SITEMAP::MAX_URL_COUNT) {
        SitemapEndOB($fname_prefix, $i);
        $i++;
        $j = 1;
    }

    // If several pages exists ...
    if ($row['COUNTER'] > ABAP_DB_CONST::INDEX_PAGESIZE) {
        $urls = ABAP_UI_DS_Navigation::GetWilPaths($row['OBJ_TYPE'], $row['OBJ_NAME'], $row['SRC_OBJ_TYPE'], $row['COUNTER']);
        foreach ($urls as $wilurl) {
            SitemapEchoUrl(GLOBAL_WEBSITE::URLPREFIX_SAPDS_ORG . $wilurl, '0.4');

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
