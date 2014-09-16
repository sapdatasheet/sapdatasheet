<?php
ob_start();
define('__ROOT__', dirname(dirname(__FILE__)));
require_once (__ROOT__ . '/include/abap_db.php');
$cvers = ABAP_DB_TABLE_HIER::CVERS_List();
?>
<?xml version="1.0" encoding="UTF-8"?>
<!-- ABAP CVERS - 144 lines -->
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"> 
    <?php while ($row = mysqli_fetch_array($cvers)) { ?>
    <url>
        <loc>http://www.sapdatasheet.org/abap/cvers/<?php echo htmlentities(strtolower($row['COMPONENT'])) ?>.html</loc> 
        <changefreq>monthly</changefreq>
        <priority>0.6</priority>
    </url>
    <?php } ?>
</urlset>
<?php
$ob_content = ob_get_contents();
ob_end_flush();
$ob_fp = fopen("./abap-cvers.xml", "w");
fwrite($ob_fp, $ob_content);
fclose($ob_fp);
