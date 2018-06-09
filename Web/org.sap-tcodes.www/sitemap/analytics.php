<?php
$__WS_ROOT__ = dirname(__FILE__, 3);           // Root folder for the Workspace
$__ROOT__ = dirname(__FILE__, 2);              // Root folder for Current web site

require_once ($__WS_ROOT__ . '/common-php/library/global.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_db.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_ui.php');
require_once ($__WS_ROOT__ . '/common-php/library/sitemap.php');

$fname_analytics = 'analytics';

$sitemap_analytics = new SITEMAP($fname);
$sitemap_analytics->StartOB();

$sitemap_analytics->EchoUrl(GLOBAL_WEBSITE::URLPREFIX_SAPTCODES_ORG . ABAP_UI_TCODES_Navigation::PATH_ANALYTICS_COMP, SITEMAP::changefreq_yearly, SITEMAP::priority_09);
$sitemap_analytics->EchoUrl(GLOBAL_WEBSITE::URLPREFIX_SAPTCODES_ORG . ABAP_UI_TCODES_Navigation::PATH_ANALYTICS_MODULE, SITEMAP::changefreq_yearly, SITEMAP::priority_09);
$sitemap_analytics->EchoUrl(GLOBAL_WEBSITE::URLPREFIX_SAPTCODES_ORG . ABAP_UI_TCODES_Navigation::PATH_ANALYTICS_NAME, SITEMAP::changefreq_yearly, SITEMAP::priority_09);

$component_list = ABAPANA_DB_TABLE::ABAPTRAN_ANALYTICS_SOFTCOMP();
foreach ($component_list as $item) {
    $url = ABAP_UI_TCODES_Navigation::AnalyticsCompPath($item['SOFTCOMP'], TRUE);
    $sitemap_analytics->EchoUrl($url, SITEMAP::changefreq_yearly, SITEMAP::priority_09);
}

$module_list = ABAPANA_DB_TABLE::ABAPTRAN_Sitemap_Module();
foreach ($module_list as $item) {
    $url = ABAP_UI_TCODES_Navigation::AnalyticsModulePath($item['MODULE'], TRUE);
    $sitemap_analytics->EchoUrl($url, SITEMAP::changefreq_yearly, SITEMAP::priority_09);
}

$name_list = ABAPANA_DB_TABLE::ABAPTRAN_ANALYTICS_NAME_LEFT2();
foreach ($name_list as $item) {
    $url = ABAP_UI_TCODES_Navigation::AnalyticsNamePath($item['TCODEPREFIX'], TRUE);
    $sitemap_analytics->EchoUrl($url, SITEMAP::changefreq_yearly, SITEMAP::priority_09);
}

$sitemap_analytics->EndOB();