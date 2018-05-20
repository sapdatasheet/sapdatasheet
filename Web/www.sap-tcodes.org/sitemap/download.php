<?php
$__ROOT__ = dirname(dirname(__FILE__));
require_once ($__ROOT__ . '/include/common/global.php');
require_once ($__ROOT__ . '/include/common/abap_db.php');
require_once ($__ROOT__ . '/include/common/abap_ui.php');
require_once ($__ROOT__ . '/include/common/sitemap.php');

$fname = pathinfo(__FILE__, PATHINFO_FILENAME);

SitemapStartOB();

SitemapEchoUrl(GLOBAL_WEBSITE::URLPREFIX_SAPTCODES_ORG . '/download/book/', '0.9');
SitemapEchoUrl(GLOBAL_WEBSITE::URLPREFIX_SAPTCODES_ORG . '/download/sheet/', '0.9');
SitemapEchoUrl(GLOBAL_WEBSITE::URLPREFIX_SAPTCODES_ORG . ABAP_UI_TCODES_Navigation::PATH_DOWNLOAD_BOOK_DIST, '0.9');
SitemapEchoUrl(GLOBAL_WEBSITE::URLPREFIX_SAPTCODES_ORG . ABAP_UI_TCODES_Navigation::PATH_DOWNLOAD_SHEET_DIST, '0.9');

$dir = new DirectoryIterator('C:\Data\Business\SAP-TCodes\Runtime\www-root\download\book\dist');
foreach ($dir as $fileinfo) {
    if (!$fileinfo->isDot()) {
        $url = ABAP_UI_TCODES_Navigation::DownloadBookPath($fileinfo->getFilename(), TRUE);
        SitemapEchoUrl($url, '0.9');
    }
}

$dir = new DirectoryIterator('C:\Data\Business\SAP-TCodes\Runtime\www-root\download\sheet\dist');
foreach ($dir as $fileinfo) {
    if (!$fileinfo->isDot()) {
        $url = ABAP_UI_TCODES_Navigation::DownloadSheetPath($fileinfo->getFilename(), TRUE);
        SitemapEchoUrl($url, '0.9');
    }
}

SitemapEndOB($fname);
