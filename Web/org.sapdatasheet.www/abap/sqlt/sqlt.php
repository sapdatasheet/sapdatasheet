<?php
$__WS_ROOT__ = dirname(__FILE__, 4);
$__ROOT__ = dirname(__FILE__, 3);

require_once ($__WS_ROOT__ . '/common-php/library/global.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_db.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_ui.php');
require_once ($__WS_ROOT__ . '/common-php/library/schemaorg.php');
GLOBAL_UTIL::UpdateSAPDescLangu();

if (empty($ObjID)) {
    ABAP_UI_TOOL::Redirect404();
}
$sqlt = ABAP_DB_TABLE_TABL::DD06L(strtoupper($ObjID));
if (empty($sqlt['SQLTAB'])) {
    ABAP_UI_TOOL::Redirect404();
}
$sqlt_desc = ABAP_DB_TABLE_TABL::DD06T($sqlt['SQLTAB']);
$sqlt_sqlcalss_desc = ABAP_UI_TOOL::GetSqltDesc($sqlt['SQLCLASS']);
$dd16s = ABAP_DB_TABLE_TABL::DD16S($sqlt['SQLTAB']);

$wul_counter_list = ABAPANA_DB_TABLE::WULCOUNTER_List(GLOBAL_ABAP_OTYPE::SQLT_NAME, $sqlt['SQLTAB']);
$hier = ABAP_DB_TABLE_HIER::Hier(ABAP_DB_TABLE_HIER::TADIR_PGMID_R3TR, GLOBAL_ABAP_OTYPE::SQLT_NAME, $sqlt['SQLTAB']);
$GLOBALS['TITLE_TEXT'] = ABAP_UI_TOOL::GetObjectTitle(GLOBAL_ABAP_OTYPE::SQLT_NAME, $sqlt['SQLTAB']);

$json_ld = new \OrgSchema\Thing();
$json_ld->name = $sqlt['SQLTAB'];
$json_ld->alternateName = $sqlt_desc;
$json_ld->description = $GLOBALS['TITLE_TEXT'];
$json_ld->image = GLOBAL_ABAP_ICON::getIconURL(GLOBAL_ABAP_ICON::OTYPE_SQLT, TRUE);
$json_ld->url = ABAP_UI_DS_Navigation::GetObjectURL(GLOBAL_ABAP_OTYPE::SQLT_NAME, $json_ld->name);
?>
<!DOCTYPE html>
<!-- DDIC Cluster/Pool table object. -->
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <title><?php echo $GLOBALS['TITLE_TEXT'] . GLOBAL_WEBSITE::SAPDS_ORG_TITLE ?> </title>
        <meta name="author" content="SAP Datasheet" />
        <meta name="description" content="<?php echo $GLOBALS['TITLE_TEXT'] . GLOBAL_WEBSITE::SAPDS_ORG_TITLE ?>" />
        <meta name="keywords" content="SAP,<?php echo GLOBAL_ABAP_OTYPE::SQLT_DESC ?>,<?php echo $sqlt_sqlcalss_desc ?>,<?php echo $sqlt['SQLTAB'] ?>,<?php echo $sqlt_desc ?>" />

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
                            <tr><td><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeSQLT() ?>
                                    <a href="/abap/sqlt/"><?php echo $sqlt_sqlcalss_desc; ?></a></td></tr>
                            <tr><td><small><strong>Object name </strong></small></td></tr>
                            <tr><td><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeSQLT() ?>
                                    <a href="#" title="<?php echo $sqlt_desc ?>"><?php echo $sqlt['SQLTAB'] ?></a> </td></tr>
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
                            <li class="breadcrumb-item"><a href="/abap/sqlt/">ABAP <?php echo $sqlt_sqlcalss_desc ?></a></li>
                            <li class="breadcrumb-item active"><a href="#"><?php echo $sqlt['SQLTAB'] ?></a></li>
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
                                    <tr><td class="sapds-gui-label"> Category              </td><td class="sapds-gui-field"> <?php echo ABAP_UI_DS_Navigation::GetHyperlink4DomainValue(ABAP_DB_TABLE_TABL::DD06L_SQLCLASS_DOMAIN, $sqlt['SQLCLASS'], $sqlt_sqlcalss_desc) ?> &nbsp;</td><td><?php echo $sqlt_sqlcalss_desc ?>&nbsp;</td></tr>
                                    <tr><td class="sapds-gui-label"> <?php echo $sqlt_sqlcalss_desc; ?> </td><td class="sapds-gui-field"> <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Sqlt($sqlt['SQLTAB'], $sqlt_desc) ?> &nbsp;</td><td>&nbsp;</td></tr>
                                    <tr><td class="sapds-gui-label"> Short Description     </td><td class="sapds-gui-field"> <?php echo htmlentities($sqlt_desc) ?> &nbsp;</td><td>&nbsp;</td></tr>
                                </tbody>
                            </table>

                            <h5 class="pt-4"><?php echo GLOBAL_ABAP_ICON::getIcon4Field() ?> Components </h5>
                            <table class="table table-sm">
                                <thead>
                                    <tr><th class="sapds-alv">#</th>
                                        <th class="sapds-alv">Field name</th>
                                        <th class="sapds-alv">Key</th>
                                        <th class="sapds-alv">Data type</th>
                                        <th class="sapds-alv">Length</th>
                                        <th class="sapds-alv">Internal type</th>
                                        <th class="sapds-alv">Internal length</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $count = 0;
                                    foreach ($dd16s as $dd16s_item) {
                                        $count++;
                                        ?>
                                        <tr><td class="sapds-alv text-right"><?php echo number_format($count) ?> </td>
                                            <td class="sapds-alv"><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeDTF() ?>
                                                <?php echo $dd16s_item['FIELDNAME'] ?></td>
                                            <td class="sapds-alv"><?php echo ABAP_UI_TOOL::GetCheckBox($dd16s_item['FIELDNAME'], $dd16s_item['KEYFLAG']) ?></td>
                                            <td class="sapds-alv"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4DomainValue(ABAP_DB_CONST::DOMAIN_DATATYPE, $dd16s_item['DATATYPE'], '') ?></td>
                                            <td class="sapds-alv"><?php echo intval($dd16s_item['LENG']) ?></td>
                                            <td class="sapds-alv"><?php echo $dd16s_item['INTTYPE'] ?></td>
                                            <td class="sapds-alv"><?php echo intval($dd16s_item['INTLEN']) ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>

                            <h5 class="pt-4"><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeTABL() ?> Contained table </h5>
                            <table class="table table-sm">
                                <thead>
                                    <tr><th class="sapds-alv">Table name</th>
                                        <th class="sapds-alv">Short description</th>
                                        <th class="sapds-alv">Date of Last Change</th></tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $dd02l_sqlt = ABAP_DB_TABLE_TABL::DD02L_SQLTAB($sqlt['SQLTAB']);
                                    foreach ($dd02l_sqlt as $dd02l_sqlt_item) {
                                        $dd02l_sqlt_item_desc = ABAP_DB_TABLE_TABL::DD02T($dd02l_sqlt_item['TABNAME']);
                                        ?>
                                        <tr>
                                            <td class="sapds-alv"><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeTABL() ?>
                                                <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Tabl($dd02l_sqlt_item['TABNAME'], $dd02l_sqlt_item_desc) ?></td>
                                            <td class="sapds-alv"><?php echo htmlentities($dd02l_sqlt_item_desc) ?></td>
                                            <td class="sapds-alv"><?php echo $dd02l_sqlt_item['AS4DATE'] ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>

                            <h5 class="pt-4"><?php echo GLOBAL_ABAP_ICON::getIcon4History() ?> History </h5>
                            <table>
                                <tbody>
                                    <tr><td class="sapds-gui-label"> Last changed by/on      </td><td class="sapds-gui-field"><?php echo $sqlt['AS4USER'] ?>&nbsp;</td><td> <?php echo $sqlt['AS4DATE'] ?>&nbsp;</td></tr>
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
