<?php

/** Sitemap constants. */
class SITEMAP {

    const MAX_URL_COUNT = 50000;

}

/**
 * Start a new sitemap xml file.
 */
function SitemapStartOB() {
    ob_start();
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
    echo "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">";
    echo "\r\n";
}

/**
 * Echo one URL for the sitemap file.
 */
function SitemapEchoUrl($url) {
    echo '<url>';
    echo '<loc>' . $url . '</loc>';
    echo '<changefreq>yearly</changefreq>';
    echo '<priority>0.6</priority>';
    echo '</url>';
    echo "\r\n";
}

/**
 * End the sitemap xml file.
 * 
 * @param string $prefix File name prefix, example: 'wul-abap'
 * @param number $i File sequence number
 */
function SitemapEndOB($prefix, $i = NULL) {
    echo '</urlset>';

    $ob_content = ob_get_contents();
    ob_end_flush();
    if ($i === NULL) {
        $filename = "./" . $prefix . ".xml";
    } else {
        $filename = "./" . $prefix . $i . ".xml";
    }
    $ob_fp = fopen($filename, "w");
    fwrite($ob_fp, $ob_content);
    fclose($ob_fp);
}

function Sitemap4ABAPOType($obj_type, $list, $column_name, $fname_pre = NULL) {
    $fname_prefix = ($fname_pre === NULL) ? 'abap-' . $obj_type : $fname_pre;
    $i = 1;
    $j = 1;

    foreach ($list as $row) {
        if ($j == 1) {
            SitemapStartOB();
        }

        if (strlen(trim($row[$column_name])) > 0) {
            $abapurl = "http://www.sapdatasheet.org/abap/" . $obj_type . "/" . GLOBAL_UTIL::Clear4Url($row[$column_name]) . ".html";
            SitemapEchoUrl($abapurl);
        }

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
}
