<!DOCTYPE html>
<!-- DDIC Cluster/Pool table object. -->
<?php
require_once '../../include/global.php';
require_once '../../include/abap_db.php';
require_once '../../include/abap_ui.php';

$ClusterTable = filter_input(INPUT_GET, 'id');
if (empty($ClusterTable)) {
    ABAP_UI_TOOL::Redirect404();
}
$sqlt = ABAP_DB_TABLE_TABL::DD06L(strtoupper($ClusterTable));
if (empty($sqlt['SQLTAB'])) {
    ABAP_UI_TOOL::Redirect404();
}
$sqlt_desc = ABAP_DB_TABLE_TABL::DD06T($sqlt['SQLTAB']);
$sqlt_sqlcalss_desc = ABAP_UI_TOOL::GetSqltDesc($sqlt['SQLCLASS']);
$dd16s = ABAP_DB_TABLE_TABL::DD16S($sqlt['SQLTAB']);
$hier = ABAP_DB_TABLE_HIER::Hier(ABAP_DB_CONST::TADIR_PGMID_R3TR, ABAP_OTYPE::SQLT_NAME, $sqlt['SQLTAB']);
$GLOBALS['TITLE_TEXT'] = 'SAP ABAP ' . $sqlt_sqlcalss_desc . ' ' . $sqlt['SQLTAB'];
?>
<html>
    <head>
        <link rel="stylesheet" href="../../abap.css" type="text/css" >
        <title><?php echo $GLOBALS['TITLE_TEXT'] ?> <?php echo WEBSITE::TITLE ?> </title>
        <meta name="keywords" content="SAP,<?php echo ABAP_OTYPE::SQLT_DESC ?>,<?php echo $sqlt_sqlcalss_desc ?>,<?php echo $doma['SQLTAB'] ?>,<?php echo $sqlt_desc ?>">
        <meta name="description" content="<?php echo WEBSITE::META_DESC; ?>">
        <meta name="author" content="SAP Datasheet">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
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
                    <tr><td class="left_value"><a href="/abap/sqlt/"><?php echo $sqlt_sqlcalss_desc; ?></a></td></tr>
                    <tr><td class="left_attribute"> Object name </td></tr>
                    <tr><td class="left_value"> <a href="#" title="<?php echo $sqlt_desc ?>"><?php echo $sqlt['SQLTAB'] ?></a> </td></tr>
                </tbody>
            </table>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Content Navigator -->
            <div class="content_navi">
                <a href="/">Home page</a> &gt; 
                <a href="/abap/">ABAP Object</a> &gt; 
                <a href="/abap/sqlt/">ABAP <?php echo $sqlt_sqlcalss_desc ?></a> &gt; 
                <a href="#"><?php echo $sqlt['SQLTAB'] ?></a>
            </div>

            <!-- Content Object -->
            <div class="content_obj_title"><span><?php echo $GLOBALS['TITLE_TEXT'] ?></span></div>
            <div class="content_obj">
                <h4> Basic Data </h4>
                <table class="content_obj">
                    <tbody>
                        <tr><td class="content_label"> Category              </td><td class="field"> <?php echo ABAP_Navigation::GetURLDomainValue(ABAP_DB_CONST::DOMAIN_DD06L_SQLCLASS, $sqlt['SQLCLASS'], $sqlt_sqlcalss_desc) ?> &nbsp;</td><td><?php echo $sqlt_sqlcalss_desc ?>&nbsp;</td></tr>
                        <tr><td class="content_label"> <?php echo $sqlt_sqlcalss_desc; ?> </td><td class="field"> <?php echo ABAP_Navigation::GetURLSqltable($sqlt['SQLTAB'], $sqlt_desc) ?> &nbsp;</td><td>&nbsp;</td></tr>
                        <tr><td class="content_label"> Short Description     </td><td class="field"> <?php echo $sqlt_desc ?> &nbsp;</td><td>&nbsp;</td></tr>
                    </tbody>
                </table>

                <!-- Components -->
                <h4> Components </h4>
                <table class="alv">
                    <thead>
                        <tr><th class="alv">Field name</th><th class="alv">Key</th><th class="alv">Data type</th><th class="alv">Length</th></tr>
                    </thead>
                    <tbody>
                        <?php while ($dd16s_item = mysqli_fetch_array($dd16s)) { ?>
                            <tr>
                                <td class="alv"><?php echo $dd16s_item['FIELDNAME'] ?></td>
                                <td class="alv"><?php echo ABAP_UI_TOOL::GetCheckBox($dd16s_item['FIELDNAME'], $dd16s_item['KEYFLAG']) ?></td>
                                <td class="alv"><?php echo ABAP_Navigation::GetURLDomainValue(DOMAIN_DATATYPE, $dd16s_item['DATATYPE'], '') ?></td>
                                <td class="alv"><?php echo intval($dd16s_item['LENG']) ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

                <!-- Contained table -->
                <h4> Contained table </h4>
                <table class="alv">
                    <thead>
                        <tr><th class="alv">Table name</th>
                            <th class="alv">Short description</th>
                            <th class="alv">Date of Last Change</th></tr>
                    </thead>
                    <tbody>
                        <?php
                        $dd02l_sqlt = ABAP_DB_TABLE_TABL::DD02L_SQLTAB($sqlt['SQLTAB']);
                        while ($dd02l_sqlt_item = mysqli_fetch_array($dd02l_sqlt)) {
                            $dd02l_sqlt_item_desc = ABAP_DB_TABLE_TABL::DD02T($dd02l_sqlt_item['TABNAME']);
                            ?>
                            <tr>
                                <td class="alv"><?php echo ABAP_Navigation::GetURLTable($dd02l_sqlt_item['TABNAME'], $dd02l_sqlt_item_desc) ?></td>
                                <td class="alv"><?php echo $dd02l_sqlt_item_desc ?></td>
                                <td class="alv"><?php echo $dd02l_sqlt_item['AS4DATE'] ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>


                <h4> Hierarchy </h4>
                <table class="content_obj">
                    <tbody>
                        <tr><td class="content_label"> Last changed by/on      </td><td class="field"><?php echo $sqlt['AS4USER'] ?>&nbsp;</td><td> <?php echo $sqlt['AS4DATE'] ?>&nbsp;</td></tr>
                        <tr><td class="content_label"> Software Component      </td><td class="field"><?php echo ABAP_Navigation::GetURLSoftComp($hier->DLVUNIT, $hier->DLVUNIT_T) ?>&nbsp;</td><td> <?php echo $hier->DLVUNIT_T ?>&nbsp;</td></tr>
                        <tr><td class="content_label"> SAP Release Created in  </td><td class="field"><?php echo $hier->CRELEASE ?>&nbsp;</td><td>&nbsp;</td></tr>
                        <tr><td class="content_label"> Application Component   </td><td class="field"><?php echo ABAP_Navigation::GetURLAppComp($hier->FCTR_ID, $hier->POSID, $hier->POSID_T) ?>&nbsp;(<?php echo $hier->FCTR_ID ?>)</td><td> <?php echo $hier->POSID_T ?>&nbsp;</td></tr>
                        <tr><td class="content_label"> Package                 </td><td class="field"><?php echo ABAP_Navigation::GetURLPackage($hier->DEVCLASS, $hier->DEVCLASS_T) ?>&nbsp;</td><td> <?php echo $hier->DEVCLASS_T ?>&nbsp;</td></tr>
                    </tbody>
                </table>

            </div>
        </div><!-- Content: End -->

        <!-- Footer -->
        <?php include '../../include/footer.html' ?>

    </body>
</html>
