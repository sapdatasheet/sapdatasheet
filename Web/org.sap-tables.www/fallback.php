<?php
$__WS_ROOT__ = dirname(__FILE__, 2);
$__ROOT__ = dirname(__FILE__, 1);
require_once ($__WS_ROOT__ . '/common-php/library/global.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_db.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_ui.php');
require_once ($__WS_ROOT__ . '/common-php/library/erd.php');

// URL Strucutre Overview for this site
//
//   /index.php
//   /table/index.php           -->  Table List by Modules
//   /table/tablename.html      -->  /table/table.php         Table data page
//   /table/tablename/erd.png   -->  /table/table-erd.php     ER diagram of the table in picture format
//   /table/tablename/erd.pdf   -->  /table/table-erd.php     ER diagram of the table in pdf format
//   /table/tablename/book.pdf  -->  /table/table-book.php    One page book for the table
//

$fb_requri = html_entity_decode(strtolower($_SERVER['REQUEST_URI']));
unset($fbk_target);

const TABLE_URI = array(
    //    Prefix     Tail  PHP-File                 Format(optional)
    array(ABAP_UI_TABLES_Navigation::URI_SUFFIX_HTML   , -5, '/table/table.php'     , ''),
    array(ABAP_UI_TABLES_Navigation::URI_SUFFIX_ERD_PDF, -8, '/table/table-erd.php' , ERD_Format::pdf),
    array(ABAP_UI_TABLES_Navigation::URI_SUFFIX_ERD_PNG, -8, '/table/table-erd.php' , ERD_Format::png),
 // array('/book.pdf', -9, '/table/table-book.php', 'pdf'),    // TODO Not ready yet
);


if (GLOBAL_UTIL::StartsWith($fb_requri, ABAP_UI_TABLES_Navigation::URI_PREFIX_TABLE)) {
    $rest = substr($fb_requri, strlen(ABAP_UI_TABLES_Navigation::URI_PREFIX_TABLE));
    
    foreach (TABLE_URI as $row) {
        if (GLOBAL_UTIL::EndsWith($rest, $row[0])) {
            if ($row[0] == ABAP_UI_TABLES_Navigation::URI_SUFFIX_HTML) {
                $table_name = substr($rest, 0, $row[1]);
            } else {
                error_log(strrpos($rest, '/'));
                $table_name = substr($rest, 0, strrpos($rest, '/'));
            }
            
            $fbk_table_name = strtoupper($table_name);
            $fbk_target = $__ROOT__ . $row[2];
            $fbk_format = $row[3];
        }
    }
    
    if (GLOBAL_UTIL::IsEmpty($fbk_table_name) || empty(ABAP_DB_TABLE_TABL::DD02L($fbk_table_name))) {
        // The table name is not valid
        unset($fbk_target);
    }
}

if (!isset($fbk_target)) {
    $fbk_target = $__WS_ROOT__ . '/common-php/library/page404.php';
}

error_log($fb_requri . ' --> ' . $fbk_target);

include $fbk_target;
exit();
