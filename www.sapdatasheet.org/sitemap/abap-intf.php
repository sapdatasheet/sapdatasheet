<?php
$__ROOT__ = dirname(dirname(__FILE__));
require_once ($__ROOT__ . '/include/global.php');
require_once ($__ROOT__ . '/include/abap_db.php');
require_once ($__ROOT__ . '/include/sitemap.php');

$obj_type = 'intf';
$list = ABAP_DB_TABLE_SEO::SEOCLASS_Sitemap(ABAP_DB_TABLE_SEO::SEOCLASS_CLSTYPE_INTF);
$column_name = 'CLSNAME';

Sitemap4ABAPOType($obj_type, $list, $column_name);
