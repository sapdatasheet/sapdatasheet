<?php
ob_start();
require_once (dirname(dirname(__FILE__)) . '/include/abap_db.php');
$bmfr = ABAP_DB_TABLE_HIER::DF14L_Sitemap();
?>
<?xml version="1.0" encoding="UTF-8"?>
<!-- ABAP BMFR - 5439 lines -->
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"> 
    <?php while ($row = mysqli_fetch_array($bmfr)) { ?>
    <url>
        <loc>http://www.sapdatasheet.org/abap/bmfr/<?php echo htmlentities(strtolower($row['FCTR_ID'])) ?>.html</loc> 
        <changefreq>yearly</changefreq>
        <priority>0.6</priority>
    </url>
    <?php } ?>
</urlset>
<?php
$ob_content = ob_get_contents();
ob_end_flush();
$ob_fp = fopen("./abap-bmfr.xml", "w");
fwrite($ob_fp, $ob_content);
fclose($ob_fp);


