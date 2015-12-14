<?php
ob_start();
require_once (dirname(dirname(__FILE__)) . '/include/abap_db.php');
$sqlt = ABAP_DB_TABLE_TABL::DD06L_List();
?>
<?xml version="1.0" encoding="UTF-8"?>
<!-- ABAP SQLT - 174 lines -->
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"> 
    <?php foreach ($sqlt as $row) { ?>
    <url>
        <loc>http://www.sapdatasheet.org/abap/sqlt/<?php echo htmlentities(strtolower($row['SQLTAB'])) ?>.html</loc> 
        <changefreq>yearly</changefreq>
        <priority>0.6</priority>
    </url>
    <?php } ?>
</urlset>
<?php
$ob_content = ob_get_contents();
ob_end_flush();
$ob_fp = fopen("./abap-sqlt.xml", "w");
fwrite($ob_fp, $ob_content);
fclose($ob_fp);
