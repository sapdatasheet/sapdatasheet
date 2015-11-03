<!DOCTYPE html>
<!-- DDIC Table -->
<?php
$__ROOT__ = dirname(dirname(dirname(__FILE__)));
require_once ($__ROOT__ . '/include/global.php');
require_once ($__ROOT__ . '/include/abap_db.php');
require_once ($__ROOT__ . '/include/abap_ui.php');
GLOBAL_UTIL::UpdateSAPDescLangu();

if (!isset($ObjID)) {
    $ObjID = filter_input(INPUT_GET, 'id');
}

if (empty($ObjID)) {
    ABAP_UI_TOOL::Redirect404();
}
$dd02l = ABAP_DB_TABLE_TABL::DD02L(strtoupper($ObjID));
if (empty($dd02l['TABNAME'])) {
    ABAP_UI_TOOL::Redirect404();
}
$dd02l_desc = ABAP_DB_TABLE_TABL::DD02T($dd02l['TABNAME']);
$dd02l_tabclass_desc = ABAP_DB_TABLE_DOMA::DD07T(ABAP_DB_CONST::DOMAIN_DD02L_TABCLASS, $dd02l['TABCLASS']);
$dd02l_contflag_desc = ABAP_DB_TABLE_DOMA::DD07T(ABAP_DB_CONST::DOMAIN_DD02L_CONTFLAG, $dd02l['CONTFLAG']);
$dd02l_mainflag_desc = ABAP_DB_TABLE_DOMA::DD07T(ABAP_DB_CONST::DOMAIN_DD02L_MAINFLAG, $dd02l['MAINFLAG']);
$dd03l = ABAP_DB_TABLE_TABL::DD03L_List($dd02l['TABNAME']);
$hier = ABAP_DB_TABLE_HIER::Hier(ABAP_DB_TABLE_HIER::TADIR_PGMID_R3TR, ABAP_OTYPE::TABL_NAME, $dd02l['TABNAME']);
$GLOBALS['TITLE_TEXT'] = 'SAP ABAP ' . $dd02l_tabclass_desc . ' ' . $dd02l['TABNAME'];
?>
<html>
    <head>
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" href="/abap.css" type="text/css" />
        <title><?php echo $GLOBALS['TITLE_TEXT'] ?> <?php echo WEBSITE::TITLE ?> </title>
        <meta name="keywords" content="SAP,<?php echo ABAP_OTYPE::TABL_DESC ?>,<?php echo $dd02l['TABNAME'] ?>,<?php echo $dd02l_desc ?>" />
        <meta name="description" content="<?php echo WEBSITE::META_DESC; ?>" />
        <meta name="author" content="SAP Datasheet" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    </head>
    <body>

        <!-- Header -->
        <?php require $__ROOT__ . '/include/header.php' ?>

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
                    <tr><td class="left_value"> <a href="#" title="<?php echo $dd02l['TABNAME'] ?>"><?php echo $dd02l['TABNAME'] ?></a> </td></tr>
                </tbody>
            </table>

            <h5>&nbsp;</h5>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Content Navigator -->
            <div class="content_navi">
                <a href="/">Home page</a> &gt;
                <a href="/abap/">ABAP Object</a> &gt;
                <a href="/abap/tabl/"><?php echo htmlentities($dd02l_tabclass_desc) ?></a> &gt;
                <a href="#"><?php echo $dd02l['TABNAME'] ?></a>
            </div>

            <!-- Content Object -->
            <div class="content_obj_title"><span><?php echo $GLOBALS['TITLE_TEXT'] ?></span></div>
            <div class="content_obj">
                <div>
                    <?php include $__ROOT__ . '/include/google/adsense-content-top.html' ?>
                </div>

                <h4> Basic Data </h4>
                <table class="content_obj">
                    <tbody>
                        <tr><td class="content_label"> Table Category        </td>
                            <td class="field"> <?php echo ABAP_Navigation::GetURLDomainValue(ABAP_DB_CONST::DOMAIN_DD02L_TABCLASS, $dd02l['TABCLASS'], $dd02l_tabclass_desc) ?> &nbsp;</td>
                            <td><?php echo htmlentities($dd02l_tabclass_desc) ?>&nbsp;</td></tr>
                        <tr><td class="content_label"> <?php echo htmlentities($dd02l_tabclass_desc) ?> </td>
                            <td class="field"><a href="#"><?php echo $dd02l['TABNAME'] ?></a></td>
                            <td>&nbsp;</td></tr>
                        <tr><td class="content_label"> Short Description     </td>
                            <td class="field"> <?php echo htmlentities($dd02l_desc) ?> &nbsp;</td>
                            <td>&nbsp;</td></tr>
                    </tbody>
                </table>

                <!-- Delivery and Maintenance -->
                <h4> Delivery and Maintenance </h4>
                <table class="content_obj">
                    <tbody>
                        <tr><td class="content_label"> Pool/cluster </td>
                            <td class="field"> <?php echo ABAP_Navigation::GetURLSqltable($dd02l['SQLTAB'], '') ?> &nbsp;</td>
                            <td>&nbsp;</td></tr>
                        <tr><td class="content_label"> Delivery Class </td>
                            <td class="field"> <?php echo ABAP_Navigation::GetURLDomainValue(ABAP_DB_CONST::DOMAIN_DD02L_CONTFLAG, $dd02l['CONTFLAG'], $dd02l_contflag_desc) ?> &nbsp;</td>
                            <td><?php echo htmlentities($dd02l_contflag_desc) ?>&nbsp;</td></tr>
                        <tr><td class="content_label"> Data Browser/Table View Maintenance </td>
                            <td class="field"> <?php echo ABAP_Navigation::GetURLDomainValue(ABAP_DB_CONST::DOMAIN_DD02L_MAINFLAG, $dd02l['MAINFLAG'], $dd02l_mainflag_desc) ?> &nbsp;</td>
                            <td><?php echo htmlentities($dd02l_mainflag_desc) ?>&nbsp;</td></tr>
                    </tbody>
                </table>

                <!-- Components -->
                <h4> Components </h4>
                <table class="alv">
                    <caption class="right">
                        <a href="/download/abap-tabl-component.php?format=<?php echo strtolower(DOWNLOAD::FORMAT_CSV) ?>&tabname=<?php echo $dd02l['TABNAME'] ?>"
                           title="Download components as CSV file.&#10;The downloaded file contains more columns than displayed here."
                           target="_blank">
                           <img src='/abap/icon/s_wdvtxe.gif'></a> &nbsp;
                        <a href="/download/abap-tabl-component.php?format=<?php echo strtolower(DOWNLOAD::FORMAT_XLS) ?>&tabname=<?php echo $dd02l['TABNAME'] ?>"
                           title="Download components as Excel (.xls) file.&#10;The downloaded file contains more columns than displayed here."
                           target="_blank">
                           <img src='/abap/icon/s_x__xls.gif'></a> &nbsp;
                        <a href="/download/abap-tabl-component.php?format=<?php echo strtolower(DOWNLOAD::FORMAT_XLSX) ?>&tabname=<?php echo $dd02l['TABNAME'] ?>"
                           title="Download components as Excel (.xlsx) file.&#10;The downloaded file contains more columns than displayed here."
                           target="_blank">
                           <img src='/abap/icon/s_lisvie.gif'></a> &nbsp;
                    </caption>
                    <thead>
                        <tr>
                            <th class="alv"> <img src='/abap/icon/s_b_pvre.gif'> </th>
                            <th class="alv"> Field </th>
                            <th class="alv"> Key </th>
                            <th class="alv"> Data Element</th>
                            <th class="alv"> Domain</th>
                            <th class="alv"> Data<br/>Type</th>
                            <th class="alv"> Length</th>
                            <th class="alv"> Decimal<br/>Places</th>
                            <th class="alv"> Short Description</th>
                            <th class="alv"> Check<br/>table</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($dd03l_item = mysqli_fetch_array($dd03l)) {
                            if (strlen(trim($dd03l_item['PRECFIELD'])) > 0) {
                                $dd03l_fieldname_url = ABAP_Navigation::GetURLTableInclude($dd02l['TABNAME'], $dd03l_item['FIELDNAME'], $dd03l_item['POSITION']);
                                $anchor_name = 'FIELD_' . $dd03l_item['POSITION'];
                            } else {
                                $dd03l_fieldname_url = ABAP_Navigation::GetURLTableField($dd02l['TABNAME'], $dd03l_item['FIELDNAME']);
                                $anchor_name = 'FIELD_' . $dd03l_item['FIELDNAME'];
                            }
                            $dd03l_fieldname_desc = ABAP_UI_TOOL::GetTablFieldDesc($dd03l_item['PRECFIELD'], $dd03l_item['ROLLNAME']);
                            $dd03l_rollname_url = ABAP_Navigation::GetURLDtel($dd03l_item['ROLLNAME'], '');
                            ?>
                            <tr>
                                <td class="alv"> <a id="<?php echo $anchor_name ?>"></a> <?php echo $dd03l_item['POSITION'] ?> </td>
                                <td class="alv"> <?php echo $dd03l_fieldname_url ?> </td>
                                <td class="alv_center"> <?php echo ABAP_UI_TOOL::GetCheckBox('field_' . $dd03l_item['FIELDNAME'], $dd03l_item['KEYFLAG']) ?> </td>
                                <td class="alv"> <?php echo $dd03l_rollname_url ?> </td>
                                <td class="alv"> <?php echo ABAP_Navigation::GetURLDomain($dd03l_item['DOMNAME'], '') ?> </td>
                                <td class="alv"> <?php echo ABAP_Navigation::GetURLDomainValue(ABAP_DB_CONST::DOMAIN_DATATYPE, $dd03l_item['DATATYPE'], '') ?> </td>
                                <td class="alv_right"> <?php echo intval($dd03l_item['LENG']) ?> &nbsp; </td>
                                <td class="alv_right"> <?php echo intval($dd03l_item['DECIMALS']) ?> &nbsp; </td>
                                <td class="alv"> <?php echo htmlentities($dd03l_fieldname_desc) ?> </td>
                                <td class="alv"> <?php echo ABAP_Navigation::GetURLTable($dd03l_item['CHECKTABLE'], '') ?> </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

                <h4> Index </h4>
                <h4> Append Structure </h4>
                <h4> Technical Settings </h4>
                <h4> Table Maintenance Generator </h4>
                <h4> Enhancement category </h4>

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
        <?php require $__ROOT__ . '/include/footer.php' ?>

    </body>
</html>
