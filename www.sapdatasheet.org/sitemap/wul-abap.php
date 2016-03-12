<!-- Where Used List for ABAP Objects -->
<?php
$__ROOT__ = dirname(dirname(__FILE__));
require_once ($__ROOT__ . '/include/global.php');
require_once ($__ROOT__ . '/include/abap_db.php');
require_once ($__ROOT__ . '/include/abap_ui.php');

function startOB() {
    ob_start();
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
    echo "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">";
    echo "\r\n";
}

function echoUrl($wulurl) {
    echo '<url>';
    echo '<loc>' . $wulurl . '</loc>';
    echo '<changefreq>yearly</changefreq>';
    echo '<priority>0.6</priority>';
    echo '</url>';
    echo "\r\n";
}

function endOB($i) {
    echo '</urlset>';

    $ob_content = ob_get_contents();
    ob_end_flush();
    $filename = "./wul-abap" . $i . ".xml";
    $ob_fp = fopen($filename, "w");
    fwrite($ob_fp, $ob_content);
    fclose($ob_fp);
}

$list = ABAPANA_DB_TABLE::WULCOUNTER_Sitemap();
$i = 1;
$j = 1;
foreach ($list as $row) {
    if ($j == 1) {
        startOB();
    }

    $wulurl = "http://www.sapdatasheet.org" . ABAP_Navigation::getWulURL($row);
    echoUrl($wulurl);

    // Check if the Sitemap is full
    $j++;
    if ($j >= SITEMAP::MAX_URL_COUNT) {
        endOB($i);
        $i++;
        $j = 1;
    }

    if ($row['COUNTER'] > ABAP_DB_CONST::INDEX_PAGESIZE) {
        $pageCount = ceil($row['COUNTER'] / ABAP_DB_CONST::INDEX_PAGESIZE);
        for ($page = 1; $page <= $pageCount; $page++) {
            $wulurl = "http://www.sapdatasheet.org/wul/abap/"
                    . htmlentities(strtolower($row['SRC_OBJ_TYPE']))
                    . "/" . htmlentities(strtolower($row['SRC_OBJ_NAME']))
                    . "-" . htmlentities(strtolower($row['OBJ_TYPE']))
                    . "-" . $page
                    . ".html";
            echoUrl($wulurl);

            // Check if the Sitemap is full
            $j++;
            if ($j >= SITEMAP::MAX_URL_COUNT) {
                endOB($i);
                $i++;
                $j = 1;
            }
        }
    }
} // End foreach

if ($j > 1) {
    endOB($i);
}
