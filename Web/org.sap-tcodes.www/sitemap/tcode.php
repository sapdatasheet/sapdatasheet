<?php

$__WS_ROOT__ = dirname(__FILE__, 3);           // Root folder for the Workspace
$__ROOT__ = dirname(__FILE__, 2);              // Root folder for Current web site

require_once ($__WS_ROOT__ . '/common-php/library/global.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_db.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_ui.php');
require_once ($__WS_ROOT__ . '/common-php/library/sitemap.php');

$sitemaps = array();

//
// Analytics Pages
//

$fname_analytics = 'analytics';

$sitemap_analytics = new SITEMAP($fname_analytics);
$sitemap_analytics->StartOB();

$sitemap_analytics->EchoUrl(GLOBAL_WEBSITE::SAP_TCODES_ORG_URL . ABAP_UI_TCODES_Navigation::PATH_ANALYTICS_COMP, SITEMAP::changefreq_yearly, SITEMAP::priority_09);
$sitemap_analytics->EchoUrl(GLOBAL_WEBSITE::SAP_TCODES_ORG_URL . ABAP_UI_TCODES_Navigation::PATH_ANALYTICS_MODULE, SITEMAP::changefreq_yearly, SITEMAP::priority_09);
$sitemap_analytics->EchoUrl(GLOBAL_WEBSITE::SAP_TCODES_ORG_URL . ABAP_UI_TCODES_Navigation::PATH_ANALYTICS_NAME, SITEMAP::changefreq_yearly, SITEMAP::priority_09);

foreach (ABAPANA_DB_TABLE::ABAPTRAN_ANALYTICS_SOFTCOMP() as $item) {
    $url = ABAP_UI_TCODES_Navigation::AnalyticsCompPath($item['SOFTCOMP'], TRUE);
    $sitemap_analytics->EchoUrl($url, SITEMAP::changefreq_yearly, SITEMAP::priority_09);
}
foreach (ABAPANA_DB_TABLE::ABAPTRAN_Sitemap_Module() as $item) {
    $url = ABAP_UI_TCODES_Navigation::AnalyticsModulePath($item['MODULE'], TRUE);
    $sitemap_analytics->EchoUrl($url, SITEMAP::changefreq_yearly, SITEMAP::priority_09);
}
foreach (ABAPANA_DB_TABLE::ABAPTRAN_ANALYTICS_NAME_LEFT2() as $item) {
    $url = ABAP_UI_TCODES_Navigation::AnalyticsNamePath($item['TCODEPREFIX'], TRUE);
    $sitemap_analytics->EchoUrl($url, SITEMAP::changefreq_yearly, SITEMAP::priority_09);
}
$sitemap_analytics->EndOB();

// - Add to sitemaps
$sitemaps[$fname_analytics] = $sitemap_analytics->GetFilenameSeq();

//
// Download Pages
//

$fname_dw = 'download';

$sitemap_dw = new SITEMAP($fname_dw);
$sitemap_dw->StartOB();

$sitemap_dw->EchoUrl(GLOBAL_WEBSITE::SAP_TCODES_ORG_URL . ABAP_UI_TCODES_Navigation::PATH_DOWNLOAD_BOOK, SITEMAP::changefreq_yearly, SITEMAP::priority_09);
$sitemap_dw->EchoUrl(GLOBAL_WEBSITE::SAP_TCODES_ORG_URL . ABAP_UI_TCODES_Navigation::PATH_DOWNLOAD_BOOK_DIST, SITEMAP::changefreq_yearly, SITEMAP::priority_09);
$sitemap_dw->EchoUrl(GLOBAL_WEBSITE::SAP_TCODES_ORG_URL . ABAP_UI_TCODES_Navigation::PATH_DOWNLOAD_SHEET, SITEMAP::changefreq_yearly, SITEMAP::priority_09);
$sitemap_dw->EchoUrl(GLOBAL_WEBSITE::SAP_TCODES_ORG_URL . ABAP_UI_TCODES_Navigation::PATH_DOWNLOAD_SHEET_DIST, SITEMAP::changefreq_yearly, SITEMAP::priority_09);

foreach (new DirectoryIterator($__ROOT__ . ABAP_UI_TCODES_Navigation::PATH_DOWNLOAD_BOOK_DIST) as $fileinfo) {
    if (!$fileinfo->isDot()) {
        $url = ABAP_UI_TCODES_Navigation::DownloadBookPath($fileinfo->getFilename(), TRUE);
        $sitemap_dw->EchoUrl($url, SITEMAP::changefreq_yearly, SITEMAP::priority_09);
    }
}
foreach (new DirectoryIterator($__ROOT__ . ABAP_UI_TCODES_Navigation::PATH_DOWNLOAD_SHEET_DIST) as $fileinfo) {
    if (!$fileinfo->isDot()) {
        $url = ABAP_UI_TCODES_Navigation::DownloadSheetPath($fileinfo->getFilename(), TRUE);
        $sitemap_dw->EchoUrl($url, SITEMAP::changefreq_yearly, SITEMAP::priority_09);
    }
}
$sitemap_dw->EndOB();

// - Add to sitemaps
$sitemaps[$fname_dw] = $sitemap_dw->GetFilenameSeq();


//
// TCodes Pages
//

$fname_tcode = 'tcode';
$sitemap_tcode = new SITEMAP($fname_tcode);
$sitemap_tcode->StartOB();

foreach (ABAPANA_DB_TABLE::ABAPTRAN_Sitemap_TCode() as $row) {
    $url = ABAP_UI_TCODES_Navigation::TCode($row['TCODE'], TRUE);
    $sitemap_tcode->EchoUrl($url, SITEMAP::changefreq_yearly, SITEMAP::priority_08);
}
$sitemap_tcode->EndOB();

// - Add to sitemaps
$sitemaps[$fname_tcode] = $sitemap_tcode->GetFilenameSeq();


//
// Sitemaps list
//

$sitemapIndex = new SITEMAP_Index('sitemap');
$sitemapIndex->StartOB();

foreach ($sitemaps as $key => $value) {
    for ($i = 1; $i <= $value; $i++) {
        $url = GLOBAL_WEBSITE::SAP_TABLES_ORG_URL . '/sitemap/' . SITEMAP::GetSitemapFilename($key, $i);
        $sitemapIndex->EchoUrl4Index($url);
    }
}
$sitemapIndex->EndOB();
