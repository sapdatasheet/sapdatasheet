<?php
$__WS_ROOT__ = dirname(__FILE__, 4);
$__ROOT__ = dirname(__FILE__, 3);

require_once ($__WS_ROOT__ . '/common-php/library/global.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_db.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_ui.php');
require_once ($__WS_ROOT__ . '/common-php/library/download.php');
require_once ($__WS_ROOT__ . '/common-php/library/schemaorg.php');
GLOBAL_UTIL::UpdateSAPDescLangu();

if (empty($ObjID)) {
    ABAP_UI_TOOL::Redirect404();
}
$dd02l = ABAP_DB_TABLE_TABL::DD02L(strtoupper($ObjID));
if (empty($dd02l['TABNAME'])) {
    ABAP_UI_TOOL::Redirect404();
}
$dd02l_desc = ABAP_DB_TABLE_TABL::DD02T($dd02l['TABNAME']);
$dd02l_tabclass_desc = ABAP_DB_TABLE_DOMA::DD07T(ABAP_DB_TABLE_TABL::DD02L_TABCLASS_DOMAIN, $dd02l['TABCLASS']);
$dd02l_contflag_desc = ABAP_DB_TABLE_DOMA::DD07T(ABAP_DB_TABLE_TABL::DD02L_CONTFLAG_DOMAIN, $dd02l['CONTFLAG']);
$dd02l_mainflag_desc = ABAP_DB_TABLE_DOMA::DD07T(ABAP_DB_TABLE_TABL::DD02L_MAINFLAG_DOMAIN, $dd02l['MAINFLAG']);
$dd03l = ABAP_DB_TABLE_TABL::DD03L_List($dd02l['TABNAME']);

$wul_counter_list = ABAPANA_DB_TABLE::WULCOUNTER_List(GLOBAL_ABAP_OTYPE::TABL_NAME, $dd02l['TABNAME']);
$wil_enabled = TRUE;
$wil_counter_list = ABAPANA_DB_TABLE::WILCOUNTER_List(GLOBAL_ABAP_OTYPE::TABL_NAME, $dd02l['TABNAME']);

$hier = ABAP_DB_TABLE_HIER::Hier(ABAP_DB_TABLE_HIER::TADIR_PGMID_R3TR, GLOBAL_ABAP_OTYPE::TABL_NAME, $dd02l['TABNAME']);
$GLOBALS['TITLE_TEXT'] = ABAP_UI_TOOL::GetObjectTitle(GLOBAL_ABAP_OTYPE::TABL_NAME, $dd02l['TABNAME']);

$json_ld = new \OrgSchema\Thing();
$json_ld->name = $dd02l['TABNAME'];
$json_ld->alternateName = $dd02l_desc;
$json_ld->description = $GLOBALS['TITLE_TEXT'];
$json_ld->image = GLOBAL_ABAP_ICON::getIconURL(GLOBAL_ABAP_ICON::OTYPE_TABL, TRUE);
$json_ld->url = ABAP_UI_DS_Navigation::GetObjectURL(GLOBAL_ABAP_OTYPE::TABL_NAME, $json_ld->name);
?>
<!DOCTYPE html>
<!-- DDIC Table -->
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <title><?php echo $GLOBALS['TITLE_TEXT'] . GLOBAL_WEBSITE_SAPDS::TITLE ?> </title>
        <meta name="author" content="SAP Datasheet" />
        <meta name="description" content="<?php echo GLOBAL_WEBSITE_SAPDS::META_DESC; ?>" />
        <meta name="keywords" content="SAP,<?php echo GLOBAL_ABAP_OTYPE::TABL_DESC ?>,<?php echo $dd02l['TABNAME'] ?>,<?php echo $dd02l_desc ?>" />

        <link rel="stylesheet" type="text/css"  href="/3rdparty/bootstrap/css/bootstrap.min.css"/>
        <link rel="stylesheet" type="text/css"  href="/sapdatasheet.css"/>

        <script type="application/ld+json"><?php echo $json_ld->toJson() ?></script>
    </head>
    <body>
        <!-- Header -->
        <?php require $__ROOT__ . '/include/header.php' ?>

        <div class="container-fluid">
            <div class="row">
                <div  class="col-xl-2 col-lg-2 col-md-3  col-sm-3    bd-sidebar bg-light">
                    <!-- Left Side bar -->
                    <h6 class="pt-4">Object Hierarchy</h6>
                    <table>
                        <tbody>
                            <tr><td><small><strong>Software Component</strong></small></td></tr>
                            <tr><td><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeCVERS() ?>
                                    <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Cvers($hier->DLVUNIT, $hier->DLVUNIT_T) ?>&nbsp;</td></tr>
                            <tr><td><small><strong> Application Component ID</strong></small></td></tr>
                            <tr><td><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeBMFR() ?>
                                    <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Bmfr($hier->FCTR_ID, $hier->POSID, $hier->POSID_T) ?>&nbsp;</td></tr>
                            <tr><td><small><strong> Package </strong></small></td></tr>
                            <tr><td><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeDEVC() ?>
                                    <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Devc($hier->DEVCLASS, $hier->DEVCLASS_T) ?></td></tr>
                            <tr><td><small><strong> Object type </strong></small></td></tr>
                            <tr><td><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeTABL() ?>
                                    <a href="/abap/tabl/"><?php echo $dd02l_tabclass_desc ?></a></td></tr>
                            <tr><td><small><strong>Object name </strong></small></td></tr>
                            <tr><td><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeTABL() ?>
                                    <a href="#" title="<?php echo $dd02l['TABNAME'] ?>"><?php echo $dd02l['TABNAME'] ?></a> </td></tr>
                        </tbody>
                    </table>

                    <?php require $__ROOT__ . '/include/abap_oname_wul.php' ?>
                    <?php require $__ROOT__ . '/include/abap_ads_side.php' ?>
                </div>

                <main class="col-xl-8 col-lg-8 col-md-6  col-sm-9    col-12 bd-content" role="main">
                    <nav class="pt-3" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/"><?php echo GLOBAL_ABAP_ICON::getIcon4Home() ?> Home</a></li>
                            <li class="breadcrumb-item"><a href="/abap/">ABAP Object Types</a></li>
                            <li class="breadcrumb-item"><a href="/abap/tabl/"><?php echo htmlentities($dd02l_tabclass_desc) ?></a></li>
                            <li class="breadcrumb-item active"><a href="#"><?php echo $dd02l['TABNAME'] ?></a></li>
                        </ol>
                    </nav>

                    <div class="card shadow">
                        <div class="card-header sapds-card-header"><?php echo $GLOBALS['TITLE_TEXT'] ?></div>
                        <div class="card-body table-responsive sapds-card-body">
                            <div class="align-content-start"><?php include $__WS_ROOT__ . '/common-php/google/adsense-content-top.html' ?></div>
                            <?php require $__ROOT__ . '/include/abap_desc_language.php' ?>
                            <?php require $__ROOT__ . '/include/abap_oname_hier.php' ?>

                            <h5 class="pt-4"><?php echo GLOBAL_ABAP_ICON::getIcon4Header() ?> Basic Data </h5>
                            <table>
                                <tbody>
                                    <tr><td class="sapds-gui-label"> Table Category        </td>
                                        <td class="sapds-gui-field"> <?php echo ABAP_UI_DS_Navigation::GetHyperlink4DomainValue(ABAP_DB_TABLE_TABL::DD02L_TABCLASS_DOMAIN, $dd02l['TABCLASS'], $dd02l_tabclass_desc) ?> &nbsp;</td>
                                        <td><?php echo htmlentities($dd02l_tabclass_desc) ?>&nbsp;</td></tr>
                                    <tr><td class="sapds-gui-label"> <?php echo htmlentities($dd02l_tabclass_desc) ?> </td>
                                        <td class="sapds-gui-field"><a href="#"><?php echo $dd02l['TABNAME'] ?></a></td>
                                        <td>&nbsp;</td></tr>
                                    <tr><td class="sapds-gui-label"> Short Description     </td>
                                        <td class="sapds-gui-field"> <?php echo htmlentities($dd02l_desc) ?> &nbsp;</td>
                                        <td>&nbsp;</td></tr>
                                </tbody>
                            </table>

                            <!-- Delivery and Maintenance -->
                            <h5 class="pt-4"><?php echo GLOBAL_ABAP_ICON::getIcon4MaintenanceStatus() ?> Delivery and Maintenance </h5>
                            <table>
                                <tbody>
                                    <tr><td class="sapds-gui-label"> Pool/cluster </td>
                                        <td class="sapds-gui-field"> <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Sqlt($dd02l['SQLTAB'], '') ?> &nbsp;</td>
                                        <td>&nbsp;</td></tr>
                                    <tr><td class="sapds-gui-label"> Delivery Class </td>
                                        <td class="sapds-gui-field"> <?php echo ABAP_UI_DS_Navigation::GetHyperlink4DomainValue(ABAP_DB_TABLE_TABL::DD02L_CONTFLAG_DOMAIN, $dd02l['CONTFLAG'], $dd02l_contflag_desc) ?> &nbsp;</td>
                                        <td><?php echo htmlentities($dd02l_contflag_desc) ?>&nbsp;</td></tr>
                                    <tr><td class="sapds-gui-label"> Data Browser/Table View Maintenance </td>
                                        <td class="sapds-gui-field"> <?php echo ABAP_UI_DS_Navigation::GetHyperlink4DomainValue(ABAP_DB_TABLE_TABL::DD02L_MAINFLAG_DOMAIN, $dd02l['MAINFLAG'], $dd02l_mainflag_desc) ?> &nbsp;</td>
                                        <td><?php echo htmlentities($dd02l_mainflag_desc) ?>&nbsp;</td></tr>
                                </tbody>
                            </table>

                            <!-- Components -->
                            <h5 class="pt-4"><?php echo GLOBAL_ABAP_ICON::getIcon4Field() ?> Components </h5>
                            <table class="table table-sm">
                                <caption class="right">
                                    <a href="/download/abap-tabl-component.php?format=<?php echo strtolower(DOWNLOAD::FORMAT_CSV) ?>&tabname=<?php echo $dd02l['TABNAME'] ?>"
                                       title="Download components as <?php echo DOWNLOAD::FORMAT_CSV_Title ?>.&#10;The downloaded file contains more columns than displayed here."
                                       target="_blank">
                                        <img src='/abap/icon/s_wdvtxe.gif'></a> &nbsp;
                                    <a href="/download/abap-tabl-component.php?format=<?php echo strtolower(DOWNLOAD::FORMAT_XLS) ?>&tabname=<?php echo $dd02l['TABNAME'] ?>"
                                       title="Download components as <?php echo DOWNLOAD::FORMAT_XLS_Title ?>.&#10;The downloaded file contains more columns than displayed here."
                                       target="_blank">
                                        <img src='/abap/icon/s_x__xls.gif'></a> &nbsp;
                                    <a href="/download/abap-tabl-component.php?format=<?php echo strtolower(DOWNLOAD::FORMAT_XLSX) ?>&tabname=<?php echo $dd02l['TABNAME'] ?>"
                                       title="Download components as <?php echo DOWNLOAD::FORMAT_XLSX_Title ?>.&#10;The downloaded file contains more columns than displayed here."
                                       target="_blank">
                                        <img src='/abap/icon/s_lisvie.gif'></a> &nbsp;
                                </caption>
                                <thead>
                                    <tr>
                                        <th class="sapds-alv"> <img src='/abap/icon/s_b_pvre.gif'> </th>
                                        <th class="sapds-alv"> Field </th>
                                        <th class="sapds-alv"> Key </th>
                                        <th class="sapds-alv"> Data Element</th>
                                        <th class="sapds-alv"> Domain</th>
                                        <th class="sapds-alv"> Data<br/>Type</th>
                                        <th class="sapds-alv"> Length</th>
                                        <th class="sapds-alv"> Decimal<br/>Places</th>
                                        <th class="sapds-alv"> Short Description</th>
                                        <th class="sapds-alv"> Check<br/>table</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($dd03l as $dd03l_item) {
                                        if (strlen(trim($dd03l_item['PRECFIELD'])) > 0) {
                                            $dd03l_fieldname_url = ABAP_UI_DS_Navigation::GetHyperlink4TablInclude($dd02l['TABNAME'], $dd03l_item['FIELDNAME'], $dd03l_item['POSITION']);
                                            $anchor_name = 'FIELD_' . $dd03l_item['POSITION'];
                                        } else {
                                            $dd03l_fieldname_url = ABAP_UI_DS_Navigation::GetHyperlink4TablField($dd02l['TABNAME'], $dd03l_item['FIELDNAME']);
                                            $anchor_name = 'FIELD_' . $dd03l_item['FIELDNAME'];
                                        }
                                        $dd03l_fieldname_desc = ABAP_UI_TOOL::GetTablFieldDesc($dd03l_item['PRECFIELD'], $dd03l_item['ROLLNAME']);
                                        $dd03l_rollname_url = ABAP_UI_DS_Navigation::GetHyperlink4Dtel($dd03l_item['ROLLNAME'], '');
                                        ?>
                                        <tr>
                                            <td class="sapds-alv"> <a id="<?php echo $anchor_name ?>"></a> <?php echo $dd03l_item['POSITION'] ?> </td>
                                            <td class="sapds-alv"> <?php echo GLOBAL_ABAP_ICON::getIcon4OtypeDTF() ?>
                                                <?php echo $dd03l_fieldname_url ?> </td>
                                            <td class="sapds-alv text-center"> <?php echo ABAP_UI_TOOL::GetCheckBox('field_' . $dd03l_item['FIELDNAME'], $dd03l_item['KEYFLAG']) ?> </td>
                                            <td class="sapds-alv"> <?php echo $dd03l_rollname_url ?> </td>
                                            <td class="sapds-alv"> <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Doma($dd03l_item['DOMNAME'], '') ?> </td>
                                            <td class="sapds-alv"> <?php echo ABAP_UI_DS_Navigation::GetHyperlink4DomainValue(ABAP_DB_CONST::DOMAIN_DATATYPE, $dd03l_item['DATATYPE'], '') ?> </td>
                                            <td class="sapds-alv text-right"> <?php echo intval($dd03l_item['LENG']) ?> &nbsp; </td>
                                            <td class="sapds-alv text-right"> <?php echo intval($dd03l_item['DECIMALS']) ?> &nbsp; </td>
                                            <td class="sapds-alv"> <?php echo htmlentities($dd03l_fieldname_desc) ?> </td>
                                            <td class="sapds-alv"> <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Tabl($dd03l_item['CHECKTABLE'], '') ?> </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>

                            <!--
                            <h5 class="pt-4"> Index </h5>
                            <h5 class="pt-4"> Append Structure </h5>
                            <h5 class="pt-4"> Technical Settings </h5>
                            <h5 class="pt-4"> Table Maintenance Generator </h5>
                            <h5 class="pt-4"> Enhancement category </h5>
                            -->

                            <h5 class="pt-4"><?php echo GLOBAL_ABAP_ICON::getIcon4History() ?> History </h5>
                            <table>
                                <tbody>
                                    <tr><td class="sapds-gui-label"> Last changed by/on      </td><td class="sapds-gui-field"><?php echo $dd02l['AS4USER'] ?>&nbsp;</td><td> <?php echo $dd02l['AS4DATE'] ?>&nbsp;</td></tr>
                                    <tr><td class="sapds-gui-label"> SAP Release Created in  </td><td class="sapds-gui-field"><?php echo $hier->CRELEASE ?>&nbsp;</td><td>&nbsp;</td></tr>
                                </tbody>
                            </table>

                        </div> 
                    </div><!-- End Card -->
                </main>

                <div  class="col-xl-2 col-lg-2 d-md-3    col-sm-none" >
                    <!-- Right Side bar -->
                    <?php require $__ROOT__ . '/include/abap_relatedlinks.php' ?>
                </div>
            </div><!-- End of row -->
            <hr>
        </div><!-- End container-fluid, main content -->

        <!-- Footer -->
        <?php require $__ROOT__ . '/include/footer.php' ?>

    </body>
</html>
<?php
// Close PDO Database Connection
ABAP_DB_TABLE::close_conn();
