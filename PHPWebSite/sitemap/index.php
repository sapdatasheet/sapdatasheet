<?php ob_start(); ?>
<?xml version="1.0" encoding="UTF-8"?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <sitemap>
        <loc>http://www.sapdatasheet.org/sitemap/sitemap.xml</loc>
        <lastmod><?php echo date("Y-m-d") ?></lastmod>
    </sitemap>
</sitemapindex>
<?php

$ob_content = ob_get_contents();
ob_end_flush();
$ob_fp = fopen("./index.xml", "w");
fwrite($ob_fp, $ob_content);
fclose($ob_fp);


