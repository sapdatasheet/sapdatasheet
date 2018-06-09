<?php
$__WS_ROOT__ = dirname(__FILE__, 3);           // Root folder for the Workspace
$__ROOT__ = dirname(__FILE__, 2);              // Root folder for Current web site

require_once ($__WS_ROOT__ . '/common-php/library/global.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_db.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_ui.php');
require_once ($__WS_ROOT__ . '/common-php/library/sitemap.php');

$fname_dw = 'download';

$sitemap_dw = new SITEMAP($fname);
$sitemap_dw->StartOB();

$sitemap_dw->EchoUrl(GLOBAL_WEBSITE::URLPREFIX_SAPTCODES_ORG . ABAP_UI_TCODES_Navigation::PATH_DOWNLOAD_BOOK, SITEMAP::changefreq_yearly, SITEMAP::priority_09);
$sitemap_dw->EchoUrl(GLOBAL_WEBSITE::URLPREFIX_SAPTCODES_ORG . ABAP_UI_TCODES_Navigation::PATH_DOWNLOAD_SHEET, SITEMAP::changefreq_yearly, SITEMAP::priority_09);
$sitemap_dw->EchoUrl(GLOBAL_WEBSITE::URLPREFIX_SAPTCODES_ORG . ABAP_UI_TCODES_Navigation::PATH_DOWNLOAD_BOOK_DIST, SITEMAP::changefreq_yearly, SITEMAP::priority_09);
$sitemap_dw->EchoUrl(GLOBAL_WEBSITE::URLPREFIX_SAPTCODES_ORG . ABAP_UI_TCODES_Navigation::PATH_DOWNLOAD_SHEET_DIST, SITEMAP::changefreq_yearly, SITEMAP::priority_09);

$dir = new DirectoryIterator($__ROOT__ . ABAP_UI_TCODES_Navigation::PATH_DOWNLOAD_BOOK_DIST);
foreach ($dir as $fileinfo) {
    if (!$fileinfo->isDot()) {
        $url = ABAP_UI_TCODES_Navigation::DownloadBookPath($fileinfo->getFilename(), TRUE);
        $sitemap_dw->EchoUrl($url, SITEMAP::changefreq_yearly, SITEMAP::priority_09);
    }
}

$dir = new DirectoryIterator($__ROOT__ . ABAP_UI_TCODES_Navigation::PATH_DOWNLOAD_SHEET_DIST);
foreach ($dir as $fileinfo) {
    if (!$fileinfo->isDot()) {
        $url = ABAP_UI_TCODES_Navigation::DownloadSheetPath($fileinfo->getFilename(), TRUE);
        $sitemap_dw->EchoUrl($url, SITEMAP::changefreq_yearly, SITEMAP::priority_09);
    }
}

$sitemap_dw->EndOB();
