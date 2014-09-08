<!DOCTYPE html>
<!-- DDIC Table Field -->
<?php
require_once '../../include/global.php';
require_once '../../include/abap_db.php';
require_once '../../include/abap_ui.php';

$Table = filter_input(INPUT_GET, 'table');
$Field = strtoupper(filter_input(INPUT_GET, 'field'));
if (empty($Table) || empty($Field)) {
    ABAP_UI_TOOL::Redirect404();
}

$dd03l = ABAP_DB_TABLE_TABL::DD03L(strtoupper($Table), strtoupper($Field));
if (empty($dd03l['FIELDNAME'])) {
    ABAP_UI_TOOL::Redirect404();
}

$dd02l = ABAP_DB_TABLE_TABL::DD02L(strtoupper($Table));
$dd02l_desc = ABAP_DB_TABLE_TABL::DD02T($dd02l['TABNAME']);
$dd02l_tabclass_desc = ABAP_DB_TABLE_DOMA::DD07T(ABAP_DB_CONST::DOMAIN_DD02L_TABCLASS, $dd02l['TABCLASS']);

$dd03l_fieldname_desc = ABAP_DB_TABLE_TABL::DD03L_FIELDNAME_DESC($dd03l['COMPTYPE'], $dd03l['ROLLNAME']);
$dd03l_checktable_desc = ABAP_DB_TABLE_TABL::DD02T($dd03l['CHECKTABLE']);

$hier = ABAP_DB_TABLE_HIER::Hier(ABAP_DB_CONST::TADIR_PGMID_R3TR, ABAP_OTYPE::TABL_NAME, $dd02l['TABNAME']);
$GLOBALS['TITLE_TEXT'] = 'SAP ABAP Table Field ' . $dd02l['TABNAME'] . '-' . $dd03l['FIELDNAME'];
?>
<html>
    <head>
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" href="../../abap.css" type="text/css" />
        <title><?php echo $GLOBALS['TITLE_TEXT'] ?> <?php echo WEBSITE::TITLE ?> </title>
        <meta name="keywords" content="SAP,Table Field,<?php echo $dd02l['TABNAME'] . '-' . $dd03l['FIELDNAME'] ?>" />
        <meta name="description" content="<?php echo WEBSITE::META_DESC; ?>" />
        <meta name="author" content="SAP Datasheet" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    </head>
    <body>

        <!-- Header -->
        <?php require '../../include/header.php' ?>

        <!-- Left -->
        <div class="left">
            <h5>&nbsp;</h5>
            <h5>Object Hierarchy</h5>
            <table class="content_obj">
                <tbody>
                    <tr><td>Software Component</td></tr>
                    <tr><td class="left_value"><?php echo ABAP_Navigation::GetURLSoftComp($hier->DLVUNIT, $hier->DLVUNIT_T) ?>&nbsp;</td></tr>
                    <tr><td class="left_attribute"> Application Component ID</td></tr>
                    <tr><td class="left_value"><?php echo ABAP_Navigation::GetURLAppComp($hier->FCTR_ID, $hier->POSID, $hier->POSID_T) ?>&nbsp;</td></tr>
                    <tr><td class="left_attribute"> Package </td></tr>
                    <tr><td class="left_value"><?php echo ABAP_Navigation::GetURLPackage($hier->DEVCLASS, $hier->DEVCLASS_T) ?></td></tr>
                    <tr><td class="left_attribute"> Object type </td></tr>
                    <tr><td class="left_value"><a href="/abap/tabl/"><?php echo $dd02l_tabclass_desc ?></a></td></tr>
                    <tr><td class="left_attribute"> Object name </td></tr>
                    <tr><td class="left_value"><?php echo ABAP_Navigation::GetURLTable($dd02l['TABNAME'], $dd02l['TABNAME']) ?></td></tr>
                    <tr><td class="left_attribute"> Field </td></tr>
                    <tr><td class="left_value"> <a href="#"><?php echo $dd03l['FIELDNAME'] ?></a> </td></tr>
                </tbody>
            </table>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Content Navigator -->
            <div class="content_navi">
                <a href="/">Home page</a> &gt; 
                <a href="/abap/">ABAP Object</a> &gt;
                <a href="/abap/tabl/"><?php echo $dd02l_tabclass_desc ?></a> &gt; 
                <?php echo ABAP_Navigation::GetURLTable($dd02l['TABNAME'], $dd02l_desc) ?>-
                <a href="#"><?php echo $dd03l['FIELDNAME'] ?></a>
            </div>

            <!-- Content Object -->
            <div class="content_obj_title"><span><?php echo $GLOBALS['TITLE_TEXT'] ?></span></div>
            <div class="content_obj">
                <h4> Basic Data </h4>
                <table class="content_obj">
                    <tbody>
                        <tr><td class="content_label"> Table </td>
                            <td class="field"> <?php echo ABAP_Navigation::GetURLTable($dd02l['TABNAME'], $dd02l_desc) ?> &nbsp;</td>
                            <td> <?php echo $dd02l_desc ?> &nbsp;</td>
                        </tr>
                        <tr><td class="content_label"> Field </td>
                            <td class="field"> <?php echo ABAP_Navigation::GetURLTableField($dd02l['TABNAME'], $dd03l['FIELDNAME']) ?> &nbsp;</td>
                            <td> <?php echo $dd03l_fieldname_desc ?> &nbsp;</td>
                        </tr>
                    </tbody>
                </table>

                <h4> Field Attributes </h4>
                <table class="content_obj">
                    <tbody>
                        <tr><td class="content_label"> Position </td>
                            <td class="field"> <?php echo $dd03l['POSITION'] ?> &nbsp;</td>
                            <td> &nbsp;</td>
                        </tr>
                        <tr><td class="content_label"> Key </td>
                            <td> <?php echo ABAP_UI_TOOL::GetCheckBox('field_' . $dd03l['FIELDNAME'], $dd03l['KEYFLAG']) ?> &nbsp;</td>
                            <td> &nbsp;</td>
                        </tr>
                        <tr><td class="content_label"> Mandatory </td>
                            <td class="field"> <?php echo $dd03l['MANDATORY'] ?> &nbsp;</td>
                            <td> &nbsp;</td>
                        </tr>
                        <tr><td class="content_label"> Data Element </td>
                            <td class="field"> <?php echo ABAP_Navigation::GetURLDtel($dd03l['ROLLNAME'], $dd03l_fieldname_desc) ?> &nbsp;</td>
                            <td> <?php echo $dd03l_fieldname_desc ?> &nbsp;</td>
                        </tr>
                        <tr><td class="content_label"> Check Table </td>
                            <td class="field"> <?php echo ABAP_Navigation::GetURLTable($dd03l['CHECKTABLE'], $dd03l_checktable_desc) ?> &nbsp;</td>
                            <td> <?php echo $dd03l_checktable_desc ?> &nbsp;</td>
                        </tr>
                    </tbody>
                </table>

                <h4> Contained in Index </h4>

                <!-- Hierarchy -->
                <h4> Hierarchy </h4>
                <table class="content_obj">
                    <tbody>
                        <tr><td class="content_label"> Last changed by/on      </td><td class="field"><?php echo $dd02l['AS4USER'] ?>&nbsp;</td><td> <?php echo $dd02l['AS4DATE'] ?>&nbsp;</td></tr>
                        <tr><td class="content_label"> Software Component      </td><td class="field"><?php echo ABAP_Navigation::GetURLSoftComp($hier->DLVUNIT, $hier->DLVUNIT_T) ?>&nbsp;</td><td> <?php echo $hier->DLVUNIT_T ?>&nbsp;</td></tr>
                        <tr><td class="content_label"> SAP Release Created in  </td><td class="field"><?php echo $hier->CRELEASE ?>&nbsp;</td><td>&nbsp;</td></tr>
                        <tr><td class="content_label"> Application Component   </td><td class="field"><?php echo ABAP_Navigation::GetURLAppComp($hier->FCTR_ID, $hier->POSID, $hier->POSID_T) ?>&nbsp;(<?php echo $hier->FCTR_ID ?>)</td><td> <?php echo $hier->POSID_T ?>&nbsp;</td></tr>
                        <tr><td class="content_label"> Package                 </td><td class="field"><?php echo ABAP_Navigation::GetURLPackage($hier->DEVCLASS, $hier->DEVCLASS_T) ?>&nbsp;</td><td> <?php echo $hier->DEVCLASS_T ?>&nbsp;</td></tr>
                    </tbody>
                </table>

            </div>
        </div><!-- End of Content -->

        <!-- Footer -->
        <?php include '../../include/footer.html' ?>

    </body>
</html>
