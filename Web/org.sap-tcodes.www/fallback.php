<?php
$__WS_ROOT__ = dirname(__FILE__, 2);           // Root folder for the Workspace
$__ROOT__ = dirname(__FILE__, 1);              // Root folder for Current web site

require_once($__WS_ROOT__ . '/common-php/library/global.php');
require_once($__WS_ROOT__ . '/common-php/library/abap_ui.php');

$fb_requri = strtolower(urldecode($_SERVER['REQUEST_URI']));
unset($fb_target);

// - Hacker URL
if ($fb_requri === '/wp/wp-admin/' || $fb_requri === '/wp-admin/' || $fb_requri === '/test/wp-admin/' || $fb_requri === '/blog/wp-admin/') {
    $fb_target = $__WS_ROOT__ . '/common-php/library/page404.php';

// - /analytics/component/...
} else if (str_starts_with($fb_requri, ABAP_UI_TCODES_Navigation::PATH_ANALYTICS_COMP) && str_ends_with($fb_requri, '.html')) {
    $fb_ObjID = substr($fb_requri, strlen(ABAP_UI_TCODES_Navigation::PATH_ANALYTICS_COMP), -5);
    $fb_target = substr(ABAP_UI_TCODES_Navigation::PATH_ANALYTICS_COMP, 1) . 'analytics.php';

// - /analytics/module/...
} else if (str_starts_with($fb_requri, ABAP_UI_TCODES_Navigation::PATH_ANALYTICS_MODULE) && str_ends_with($fb_requri, '.html')) {
    $fb_ObjID = substr($fb_requri, strlen(ABAP_UI_TCODES_Navigation::PATH_ANALYTICS_MODULE), -5);
    $fb_target = substr(ABAP_UI_TCODES_Navigation::PATH_ANALYTICS_MODULE, 1) . 'analytics.php';

// - /analytics/name/...
} else if (str_starts_with($fb_requri, ABAP_UI_TCODES_Navigation::PATH_ANALYTICS_NAME) && str_ends_with($fb_requri, '.html')) {
    $fb_ObjID = substr($fb_requri, strlen(ABAP_UI_TCODES_Navigation::PATH_ANALYTICS_NAME), -5);
    $fb_target = substr(ABAP_UI_TCODES_Navigation::PATH_ANALYTICS_NAME, 1) . 'analytics.php';

// - /tcode/...
} else if (str_starts_with($fb_requri, ABAP_UI_TCODES_Navigation::PATH_TCODE) && str_ends_with($fb_requri, '.html')) {
    $fb_ObjID = substr($fb_requri, strlen(ABAP_UI_TCODES_Navigation::PATH_TCODE), -5);
    $fb_target = substr(ABAP_UI_TCODES_Navigation::PATH_TCODE, 1) . 'tcode.php';
}

if (!isset($fb_target)) {
    $fb_target = $__WS_ROOT__ . '/common-php/library/page404.php';
}

include $fb_target;
exit();
