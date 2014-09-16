<?php
ob_start();
define('__ROOT__', dirname(dirname(__FILE__)));
require_once (__ROOT__ . '/include/abap_db.php');
$devc = ABAP_DB_TABLE_HIER::TDEVC_Sitemap();
?>
<?xml version="1.0" encoding="UTF-8"?>
<!-- ABAP DEVC - 15585 lines -->
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"> 
    <?php while ($row = mysqli_fetch_array($devc)) { ?>
    <url>
        <loc>http://www.sapdatasheet.org/abap/devc/<?php echo htmlentities(strtolower($row['DEVCLASS'])) ?>.html</loc> 
        <changefreq>monthly</changefreq>
        <priority>0.6</priority>
    </url>
    <?php } ?>
</urlset>
<?php
$ob_content = ob_get_contents();
ob_end_flush();
$ob_fp = fopen("./abap-devc.xml", "w");
fwrite($ob_fp, $ob_content);
fclose($ob_fp);
