<?php
$__WS_ROOT__ = dirname(__FILE__, 3);           // Root folder for the Workspace
$__ROOT__ = dirname(__FILE__, 2);              // Root folder for Current web site

require_once ($__WS_ROOT__ . '/common-php/library/global.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_db.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_ui.php');
?>
<?xml version="1.0" encoding="UTF-8"?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <sitemap>
        <loc><?php echo GLOBAL_WEBSITE::URLPREFIX_SAPTCODES_ORG ?>/sitemap/analytics.xml</loc>
        <lastmod><?php echo date("Y-m-d") ?></lastmod>
    </sitemap>
    <sitemap>
        <loc><?php echo GLOBAL_WEBSITE::URLPREFIX_SAPTCODES_ORG ?>/sitemap/download.xml</loc>
        <lastmod><?php echo date("Y-m-d") ?></lastmod>
    </sitemap>
    <?php for ($i = 1; $i <= ABAP_DBDATA::SITEMAP_SAPTCODES_MAX; $i++) { ?>
        <sitemap>
            <loc><?php echo GLOBAL_WEBSITE::URLPREFIX_SAPTCODES_ORG ?>/sitemap/tcode<?php echo $i ?>.xml</loc>
            <lastmod><?php echo date("Y-m-d") ?></lastmod>
        </sitemap>
    <?php } ?>

</sitemapindex>
