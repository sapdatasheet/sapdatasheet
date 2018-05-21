<?php
$__ROOT__ = dirname(dirname(__FILE__));
require_once ($__WS_ROOT__ . '/common-php/library/global.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_db.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_ui.php');
require_once ($__WS_ROOT__ . '/common-php/library/sitemap.php');

$fname = pathinfo(__FILE__, PATHINFO_FILENAME);

SitemapStartOB();

SitemapEchoUrl(GLOBAL_WEBSITE::URLPREFIX_SAPTCODES_ORG . ABAP_UI_TCODES_Navigation::PATH_ANALYTICS_COMP, '0.9');
SitemapEchoUrl(GLOBAL_WEBSITE::URLPREFIX_SAPTCODES_ORG . ABAP_UI_TCODES_Navigation::PATH_ANALYTICS_MODULE, '0.9');
SitemapEchoUrl(GLOBAL_WEBSITE::URLPREFIX_SAPTCODES_ORG . ABAP_UI_TCODES_Navigation::PATH_ANALYTICS_NAME, '0.9');

$component_list = ABAPANA_DB_TABLE::ABAPTRAN_ANALYTICS_SOFTCOMP();
foreach ($component_list as $item) {
    $url = ABAP_UI_TCODES_Navigation::AnalyticsCompPath($item['SOFTCOMP'], TRUE);
    SitemapEchoUrl($url, '0.9');
}

$module_list = ABAPANA_DB_TABLE::ABAPTRAN_Sitemap_Module();
foreach ($module_list as $item) {
    $url = ABAP_UI_TCODES_Navigation::AnalyticsModulePath($item['MODULE'], TRUE);
    SitemapEchoUrl($url, '0.9');
}

$name_list = ABAPANA_DB_TABLE::ABAPTRAN_ANALYTICS_NAME_LEFT2();
foreach ($name_list as $item) {
    $url = ABAP_UI_TCODES_Navigation::AnalyticsNamePath($item['TCODEPREFIX'], TRUE);
    SitemapEchoUrl($url, '0.9');
}

SitemapEndOB($fname);
