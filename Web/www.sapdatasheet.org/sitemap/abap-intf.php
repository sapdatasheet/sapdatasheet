<?php
$__ROOT__ = dirname(dirname(__FILE__));
require_once ($__ROOT__ . '/include/common/global.php');
require_once ($__ROOT__ . '/include/common/abap_db.php');
require_once ($__ROOT__ . '/include/common/abap_ui.php');
require_once ($__ROOT__ . '/include/common/sitemap.php');

$obj_type = 'intf';
$list = ABAP_DB_TABLE_SEO::SEOCLASS_Sitemap(ABAP_DB_TABLE_SEO::SEOCLASS_CLSTYPE_INTF);
$column_name = 'CLSNAME';

Sitemap4ABAPOType($obj_type, $list, $column_name);