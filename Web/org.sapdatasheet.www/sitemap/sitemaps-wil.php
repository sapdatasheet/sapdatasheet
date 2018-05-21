<?php
$__WS_ROOT__ = dirname(__FILE__, 3);

require_once($__WS_ROOT__ . '/common-php/library/global.php');
require_once($__WS_ROOT__ . '/common-php/library/abap_db.php');

ob_start();
?>
<?xml version="1.0" encoding="UTF-8"?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <?php for ($i = 1; $i <= ABAP_DBDATA::SITEMAP_WIL_MAX; $i++) { ?>
        <sitemap>
            <loc><?php echo GLOBAL_WEBSITE::URLPREFIX_SAPDS_ORG ?>/sitemap/wil-abap<?php echo $i ?>.xml</loc>
            <lastmod><?php echo date("Y-m-d") ?></lastmod>
        </sitemap>
    <?php } ?>
</sitemapindex>

<?php
$ob_content = ob_get_contents();
ob_end_flush();
$ob_fp = fopen("./sitemaps-wil.xml", "w");
fwrite($ob_fp, $ob_content);
fclose($ob_fp);


