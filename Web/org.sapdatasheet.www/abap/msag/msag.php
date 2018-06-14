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
$ObjID = strtoupper($ObjID);
$msag = ABAP_DB_TABLE_MSAG::T100A(strtoupper($ObjID));
if (empty($msag['ARBGB'])) {
    ABAP_UI_TOOL::Redirect404();
}

$msag_t = ABAP_DB_TABLE_MSAG::T100T($ObjID);
$t100_list = ABAP_DB_TABLE_MSAG::T100($ObjID);

$wul_counter_list = ABAPANA_DB_TABLE::WULCOUNTER_List(GLOBAL_ABAP_OTYPE::MSAG_NAME, $ObjID);

$hier = ABAP_DB_TABLE_HIER::Hier(ABAP_DB_TABLE_HIER::TADIR_PGMID_R3TR, GLOBAL_ABAP_OTYPE::MSAG_NAME, $ObjID);
$GLOBALS['TITLE_TEXT'] = ABAP_UI_TOOL::GetObjectTitle(GLOBAL_ABAP_OTYPE::MSAG_NAME, $ObjID);

$json_ld = new \OrgSchema\Thing();
$json_ld->name = $msag['ARBGB'];
$json_ld->alternateName = $msag_t;
$json_ld->description = $GLOBALS['TITLE_TEXT'];
$json_ld->image = GLOBAL_ABAP_ICON::getIconURL(GLOBAL_ABAP_ICON::OTYPE_MSAG, TRUE);
$json_ld->url = ABAP_UI_DS_Navigation::GetObjectURL(GLOBAL_ABAP_OTYPE::MSAG_NAME, $json_ld->name);
?>
<!DOCTYPE html>
<!-- IMG Activity object. -->
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <title><?php echo $GLOBALS['TITLE_TEXT'] . GLOBAL_WEBSITE::SAPDS_ORG_TITLE ?> </title>
        <meta name="author" content="SAP Datasheet" />
        <meta name="description" content="<?php echo $GLOBALS['TITLE_TEXT'] . GLOBAL_WEBSITE::SAPDS_ORG_TITLE ?>" />
        <meta name="keywords" content="SAP,<?php echo GLOBAL_ABAP_OTYPE::MSAG_DESC ?>,<?php echo $ObjID ?>,<?php echo $msag_t ?>" />

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
                            <tr><td><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeMSAG() ?>
                                    <a href="/abap/msag/"><?php echo GLOBAL_ABAP_OTYPE::MSAG_DESC ?></a></td></tr>
                            <tr><td><small><strong>Object name </strong></small></td></tr>
                            <tr><td><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeMSAG() ?>
                                    <a href="#" title="<?php echo $msag_t ?>"><?php echo $ObjID ?></a> </td></tr>
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
                            <li class="breadcrumb-item"><a href="/abap/msag/"><?php echo GLOBAL_ABAP_OTYPE::MSAG_DESC ?></a></li>
                            <li class="breadcrumb-item active"><a href="#"><?php echo $ObjID ?></a></li>
                        </ol>
                    </nav>

                    <div class="card shadow">
                        <div class="card-header sapds-card-header"><?php echo $GLOBALS['TITLE_TEXT'] ?></div>
                        <div class="card-body table-responsive sapds-card-body">
                            <div class="align-content-start"><?php include $__WS_ROOT__ . '/common-php/google/adsense-content-top.html' ?></div>
                            <?php require $__ROOT__ . '/include/abap_desc_language.php' ?>

                            <h5> Basic Data </h5>
                            <?php require $__ROOT__ . '/include/abap_oname_hier.php' ?>

                            <h5 class="pt-4"> <?php echo GLOBAL_ABAP_ICON::getIcon4Header() ?> Attributes </h5>
                            <table>
                                <tbody>
                                    <tr><td class="sapds-gui-label"> Message class </td>
                                        <td><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeMSAG() ?></td>
                                        <td class="sapds-gui-field"> <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Msag($ObjID, $msag_t, FALSE); ?> </td>
                                    </tr>
                                    <tr><td class="sapds-gui-label"> Short Description</td>
                                        <td><?php echo GLOBAL_ABAP_ICON::getIcon4Description() ?></td>
                                        <td class="sapds-gui-field"> <?php echo $msag_t ?> &nbsp;</td>
                                    </tr>
                                    <tr><td class="sapds-gui-label"> Changed On</td>
                                        <td><?php echo GLOBAL_ABAP_ICON::getIcon4Date() ?></td>
                                        <td class="sapds-gui-field"><?php echo $msag['LDATE'] ?>&nbsp;</td>
                                    </tr>
                                    <tr><td class="sapds-gui-label"> Last Changed At </td>
                                        <td><?php echo GLOBAL_ABAP_ICON::getIcon4Time() ?></td>
                                        <td class="sapds-gui-field"><?php echo $msag['LTIME'] ?>&nbsp;</td>
                                    </tr>
                                </tbody>
                            </table>

                            <h5 class="pt-4"> <?php echo GLOBAL_ABAP_ICON::getIcon4Folder() ?> Messages </h5>
                            <table class="table table-sm">
                                <tr>
                                    <th class="sapds-alv"> # </th>
                                    <th class="sapds-alv"> Message </th>
                                    <th class="sapds-alv"> Message Short Text </th>
                                    <th class="sapds-alv"> Documentation status </th>
                                    <th class="sapds-alv"> Authorization check </th>
                                </tr>
                                <?php
                                $count = 0;
                                foreach ($t100_list as $t100) {
                                    $count++;
                                    $t100u = ABAP_DB_TABLE_MSAG::T100U($ObjID, $t100['MSGNR']);
                                    $t100u_t = ABAP_DB_TABLE_DOMA::DD07T(ABAP_DB_TABLE_MSAG::T100U_SELFDEF_DOMAIN, $t100u['SELFDEF']);
                                    $t100x = ABAP_DB_TABLE_MSAG::T100X($ObjID, $t100['MSGNR']);
                                    ?>
                                    <tr><td class="sapds-alv text-right"><?php echo number_format($count) ?> </td>
                                        <td class="sapds-alv"><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeNN() ?>
                                            <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Msgnr($ObjID, $t100['MSGNR']) ?></td>
                                        <td class="sapds-alv"><?php echo htmlentities($t100['TEXT']) ?></td>
                                        <td class="sapds-alv"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4DomainValue(ABAP_DB_TABLE_MSAG::T100U_SELFDEF_DOMAIN, $t100u_t, $t100u['SELFDEF']) ?></td>
                                        <td class="sapds-alv"><?php echo ABAP_UI_TOOL::GetCheckBox('AUTH_CHECK', $t100x['AUTH_CHECK']) ?></td>
                                    </tr>
                                <?php } ?>
                            </table>

                            <h5 class="pt-4"> <?php echo GLOBAL_ABAP_ICON::getIcon4History() ?> History </h5>
                            <table>
                                <tbody>
                                    <tr><td class="sapds-gui-label"> Last changed on/by      </td>
                                        <td><?php echo GLOBAL_ABAP_ICON::getIcon4Date() ?></td>
                                        <td class="sapds-gui-field"><?php echo $msag['LDATE'] ?>&nbsp;</td>
                                        <td> <?php echo $msag['LASTUSER'] ?>&nbsp;</td></tr>
                                    <tr><td class="sapds-gui-label"> SAP Release Created in  </td>
                                        <td>&nbsp;</td>
                                        <td class="sapds-gui-field"><?php echo $hier->CRELEASE ?>&nbsp;</td>
                                        <td>&nbsp;</td></tr>
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
