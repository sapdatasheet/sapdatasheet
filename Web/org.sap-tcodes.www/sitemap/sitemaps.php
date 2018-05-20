<?php
$__ROOT__ = dirname(dirname(__FILE__));
require_once ($__ROOT__ . '/include/common/global.php');
require_once ($__ROOT__ . '/include/common/abap_db.php');
require_once ($__ROOT__ . '/include/common/abap_ui.php');
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
