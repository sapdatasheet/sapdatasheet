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

$dd02l = ABAP_DB_TABLE_TABL::DD02L(strtoupper($Table));
if (empty($dd02l['TABNAME'])) {
    ABAP_UI_TOOL::Redirect404();
}
$dd02l_desc = ABAP_DB_TABLE_TABL::DD02T($dd02l['TABNAME']);
$dd02l_tabclass_desc = ABAP_DB_TABLE_DOMA::DD07T(ABAP_DB_CONST::DOMAIN_DD02L_TABCLASS, $dd02l['TABCLASS']);

$hier = ABAP_DB_TABLE_HIER::Hier(ABAP_DB_CONST::TADIR_PGMID_R3TR, ABAP_OTYPE::TABL_NAME, $dd02l['TABNAME']);
$GLOBALS['TITLE_TEXT'] = 'SAP ABAP Table Field ' . $dd02l['TABNAME'] . '-' . $Field;
?>
<html>
    <head>
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" href="../../abap.css" type="text/css" />
        <title><?php echo $GLOBALS['TITLE_TEXT'] ?> <?php echo WEBSITE::TITLE ?> </title>
        <meta name="keywords" content="SAP,Table Field,<?php echo $dd02l['TABNAME'] . '-' . $Field ?>" />
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
                    <tr><td class="left_value"> <a href="#"><?php echo $Field ?></a> </td></tr>
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
                <?php echo ABAP_Navigation::GetURLTable($dd02l['TABNAME'], $dd02l['TABNAME']) ?>-
                <a href="#"><?php echo $Field ?></a>
            </div>

            <!-- Content Object -->
            <div class="content_obj_title"><span><?php echo $GLOBALS['TITLE_TEXT'] ?></span></div>
            <div class="content_obj">
                <h4> Basic Data </h4>
                <table class="content_obj">
                    <tbody>
                        <tr><td class="content_label"> Table        </td>
                            <td class="field"> &nbsp;</td>
                            <td class="field"> &nbsp;</td>
                        </tr>
                    </tbody>
                </table>


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
