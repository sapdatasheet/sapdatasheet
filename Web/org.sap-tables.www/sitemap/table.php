<?php

$__WS_ROOT__ = dirname(__FILE__, 3);
$__ROOT__ = dirname(__FILE__, 2);

require_once ($__WS_ROOT__ . '/common-php/library/global.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_db.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_ui.php');
require_once ($__WS_ROOT__ . '/common-php/library/sitemap.php');
require_once ($__ROOT__ . '/include/erd.php');
require_once ($__ROOT__ . '/include/site_tables_ui.php');
GLOBAL_UTIL::UpdateSAPDescLangu();

const SITEMAP_FILE_PREFIX = 'table';


// Sitemap for the Table Pages

$list = ABAP_DB_TABLE_TABL::DD02L_Sitemap();

$sitemap = new SITEMAP('table');
$sitemap->StartOB();

// - Home page
$sitemap->EchoUrl(GLOBAL_WEBSITE::SAP_TABLES_ORG_URL, SITEMAP::changefreq_monthly, SITEMAP::priority_09);
foreach ($list as $item) {
    // - Each Table page
    $sitemap->EchoUrl(SITE_UI_TABLES::url_table($item['TABNAME'], TRUE), SITEMAP::changefreq_monthly, SITEMAP::priority_08);
    $sitemap->EchoUrl(SITE_UI_TABLES::uri_table_erd_pdf($item['TABNAME'], TRUE), SITEMAP::changefreq_yearly, SITEMAP::priority_06);
    $sitemap->EchoUrl(SITE_UI_TABLES::uri_table_erd_png($item['TABNAME'], TRUE), SITEMAP::changefreq_yearly, SITEMAP::priority_04);
}
$sitemap->EndOB();

$filenameSeq = $sitemap->GetFilenameSeq();

// Sitemap Indexes

$sitemapIndex = new SITEMAP_Index('sitemap');
$sitemapIndex->StartOB();
for ($i = 1; $i <= $filenameSeq; $i++) {
    $url = GLOBAL_WEBSITE::SAP_TABLES_ORG_URL . '/sitemap/' . SITEMAP_FILE_PREFIX . '-' . $i . '.xml';
    $sitemapIndex->EchoUrl4Index($url);
}
$sitemapIndex->EndOB();
