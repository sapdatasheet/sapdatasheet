<!DOCTYPE html>
<!-- Function Module object. -->
<!-- DDIC Data Element object. -->
<?php
require_once '../../include/global.php';
require_once '../../include/abap_db.php';
require_once '../../include/abap_ui.php';

$input_id = filter_input(INPUT_GET, 'id');
if (empty($input_id)) {
    ABAP_UI_TOOL::Redirect404();
}
$func = ABAP_DB_TABLE_DTEL::DD04L(strtoupper($input_id));
if (empty($func['FUNCNAME'])) {
    ABAP_UI_TOOL::Redirect404();
}

//$dtel_desc = ABAP_DB_TABLE_DTEL::DD04T($dtel['ROLLNAME']);
//$dtel_label = ABAP_DB_TABLE_DTEL::DD04T_ALL($dtel['ROLLNAME']);
//$dtel_refkind_desc = ABAP_DB_TABLE_DOMA::DD07T(ABAP_DB_CONST::DOMAIN_DD04L_REFKIND, $dtel['REFKIND']);
//$dtel_reftype_desc = ABAP_DB_TABLE_DOMA::DD07T(ABAP_DB_CONST::DOMAIN_DD04L_REFTYPE, $dtel['REFTYPE']);
//$dtel_datatype_desc = ABAP_DB_TABLE_DOMA::DD07T(ABAP_DB_CONST::DOMAIN_DATATYPE, $dtel['DATATYPE']);
//$hier = ABAP_DB_TABLE_HIER::Hier(ABAP_DB_CONST::TADIR_PGMID_R3TR, ABAP_OTYPE::DTEL_NAME, $dtel['ROLLNAME']);
//$GLOBALS['TITLE_TEXT'] = 'SAP ABAP ' . ABAP_OTYPE::DTEL_DESC . ' ' . $dtel['ROLLNAME'];
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        // put your code here
        ?>
    </body>
</html>
