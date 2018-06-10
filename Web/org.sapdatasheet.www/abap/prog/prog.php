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
$prog = ABAP_DB_TABLE_PROG::YREPOSRCMETA(strtoupper($ObjID));
if (empty($prog['PROGNAME'])) {
    ABAP_UI_TOOL::Redirect404();
}

$prog_desc = htmlentities(ABAP_DB_TABLE_PROG::TRDIRT($prog['PROGNAME']));
$reposrc_subc_desc = ABAP_DB_TABLE_DOMA::DD07T(ABAP_DB_CONST::DOMAIN_REPOSRC_SUBC, $prog['SUBC']);
$reposrc_rstat_desc = ABAP_DB_TABLE_DOMA::DD07T(ABAP_DB_CONST::DOMAIN_REPOSRC_RSTAT, $prog['RSTAT']);
$reposrc_appl_desc = ABAP_DB_TABLE_PROG::YTAPLT($prog['APPL']);
$reposrc_ldbname_desc = ABAP_DB_TABLE_PROG::LDBT($prog['LDBNAME']);

$tcode_list = ABAP_DB_TABLE_TRAN::TSTC_PGMNA($prog['PROGNAME']);
$dynr_list = ABAP_DB_TABLE_PROG::D020S_PROG($prog['PROGNAME']);

$wul_counter_list = ABAPANA_DB_TABLE::WULCOUNTER_List(GLOBAL_ABAP_OTYPE::PROG_NAME, $prog['PROGNAME']);
$wil_enabled = TRUE;
$wil_counter_list = ABAPANA_DB_TABLE::WILCOUNTER_List(GLOBAL_ABAP_OTYPE::PROG_NAME, $prog['PROGNAME']);

$hier = ABAP_DB_TABLE_HIER::Hier(ABAP_DB_TABLE_HIER::TADIR_PGMID_R3TR, GLOBAL_ABAP_OTYPE::PROG_NAME, $prog['PROGNAME']);
$GLOBALS['TITLE_TEXT'] = ABAP_UI_TOOL::GetObjectTitle(GLOBAL_ABAP_OTYPE::PROG_NAME, $prog['PROGNAME']);

$json_ld = new \OrgSchema\Thing();
$json_ld->name = $prog['PROGNAME'];
$json_ld->alternateName = $prog_desc;
$json_ld->description = $GLOBALS['TITLE_TEXT'];
$json_ld->image = GLOBAL_ABAP_ICON::getIconURL(GLOBAL_ABAP_ICON::OTYPE_PROG, TRUE);
$json_ld->url = ABAP_UI_DS_Navigation::GetObjectURL(GLOBAL_ABAP_OTYPE::PROG_NAME, $json_ld->name);
?>
<!DOCTYPE html>
<!-- Program object. -->
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <title><?php echo $GLOBALS['TITLE_TEXT'] . GLOBAL_WEBSITE::SAPDS_ORG_URL_TITLE ?> </title>
        `        <meta name="author" content="SAP Datasheet" />
        <meta name="description" content="<?php echo GLOBAL_WEBSITE::SAPDS_ORG_URL_META_DESC; ?>" />
        <meta name="keywords" content="SAP,<?php echo GLOBAL_ABAP_OTYPE::PROG_DESC ?>,<?php echo $prog['PROGNAME'] ?>,<?php echo $prog_desc ?>" />

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
                            <tr><td><?php echo GLOBAL_ABAP_ICON::getIcon4OtypePROG() ?>
                                    <a href="/abap/prog/"><?php echo GLOBAL_ABAP_OTYPE::PROG_DESC ?></a></td></tr>
                            <tr><td><small><strong>Object name </strong></small></td></tr>
                            <tr><td><?php echo GLOBAL_ABAP_ICON::getIcon4OtypePROG() ?>
                                    <a href="#" title="<?php echo $prog_desc ?>"><?php echo $prog['PROGNAME'] ?></a> </td></tr>
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
                            <li class="breadcrumb-item"><a href="/abap/prog/"><?php echo GLOBAL_ABAP_OTYPE::PROG_DESC ?></a></li>
                            <li class="breadcrumb-item active"><a href="#"><?php echo $prog['PROGNAME'] ?></a></li>
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
                                    <tr><td class="sapds-gui-label"> Program </td>
                                        <td class="sapds-gui-field"> <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Prog($prog['PROGNAME'], $prog_desc); ?> </td>
                                        <td> <?php echo $prog_desc ?> &nbsp;</td>
                                    </tr>
                                    <tr><td class="sapds-gui-label"> Program Type </td>
                                        <td class="sapds-gui-field"> <?php echo ABAP_UI_DS_Navigation::GetHyperlink4DomainValue(ABAP_DB_CONST::DOMAIN_REPOSRC_SUBC, $prog['SUBC'], $reposrc_subc_desc); ?> </td>
                                        <td> <?php echo htmlentities($reposrc_subc_desc) ?> &nbsp;</td>
                                    </tr>
                                </tbody>
                            </table>

                            <h5 class="pt-4"> Attributes </h5>
                            <table>
                                <tbody>
                                    <tr><td class="sapds-gui-label"> Status </td>
                                        <td class="sapds-gui-field"> <?php echo ABAP_UI_DS_Navigation::GetHyperlink4DomainValue(ABAP_DB_CONST::DOMAIN_REPOSRC_RSTAT, $prog['RSTAT'], $reposrc_rstat_desc); ?> </td>
                                        <td> <?php echo htmlentities($reposrc_rstat_desc) ?> &nbsp;</td>
                                    </tr>
                                    <tr><td class="sapds-gui-label"> Application </td>
                                        <td class="sapds-gui-field"> <?php echo $prog['APPL'] ?> </td>
                                        <td> <?php echo htmlentities($reposrc_appl_desc) ?> &nbsp;</td>
                                    </tr>
                                    <tr><td class="sapds-gui-label"> Authorization Group </td>
                                        <td class="sapds-gui-field"> <?php echo $prog['SECU'] ?> </td> <!-- TODO: Add link -->
                                        <td> &nbsp;</td>
                                    </tr>
                                    <tr><td class="sapds-gui-label"> Logical database </td>
                                        <td class="sapds-gui-field"> <?php echo $prog['LDBNAME'] ?> </td> <!-- TODO: Add link -->
                                        <td> <?php echo htmlentities($reposrc_ldbname_desc) ?> &nbsp;</td>
                                    </tr>
                                    <tr><td class="sapds-gui-label">Selection screen </td>
                                        <td class="sapds-gui-field"> <?php echo $prog['TYPE'] ?> </td>
                                        <td> &nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td class="sapds-gui-label"> <?php echo ABAP_UI_TOOL::GetCheckBox("PROG", $prog['EDTX']) ?> Editor lock </td>
                                        <td class="sapds-gui-label"> <?php echo ABAP_UI_TOOL::GetCheckBox("PROG", $prog['FIXPT']) ?> Fixed point arithmetic </td>
                                        <td> &nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td class="sapds-gui-label"> <?php echo ABAP_UI_TOOL::GetCheckBox("PROG", $prog['UCCHECK']) ?> Unicode checks active</td>
                                        <td class="sapds-gui-label"> <?php echo ABAP_UI_TOOL::GetCheckBox("PROG", $prog['SSET']) ?> Start using variant </td>
                                        <td> &nbsp;</td>
                                    </tr>
                                </tbody>
                            </table><!-- Attributes: End -->

                            <!-- Function Group -->
                            <?php
                            if ($prog['SUBC'] == ABAP_DB_CONST::DOMAINVALUE_SUBC_F) {
                                $tfdir_list = ABAP_DB_TABLE_FUNC::TFDIR_PGMNA($prog['PROGNAME']);
                                ?>
                                <h5 class="pt-4"><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeFUGR() ?> Function Group </h5>
                                <table class="table table-sm">
                                    <thead>
                                        <tr><th class="sapds-alv"> Include </th>
                                            <th class="sapds-alv"> Function Module </th>
                                            <th class="sapds-alv"> Short Description </th>
                                            <th class="sapds-alv"> Mode </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($tfdir_list as $tfdir) {
                                            $tfdir_desc = ABAP_DB_TABLE_FUNC::TFTIT($tfdir['FUNCNAME']);
                                            ?>
                                            <tr>
                                                <td class="sapds-alv"> <?php echo $tfdir['INCLUDE'] ?> &nbsp;</td>
                                                <td class="sapds-alv"> <?php echo GLOBAL_ABAP_ICON::getIcon4OtypeFUNC() ?>
                                                    <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Func($tfdir['FUNCNAME'], $tfdir_desc) ?> &nbsp;</td>
                                                <td class="sapds-alv"> <?php echo htmlentities($tfdir_desc) ?> &nbsp;</td>
                                                <td class="sapds-alv"> <?php echo $tfdir['FMODE'] ?> &nbsp;</td>
                                            </tr>
                                        <?php } ?>
                                        <tr>
                                            <td class="sapds-alv"> &nbsp; </td>
                                            <td class="sapds-alv"> &nbsp; </td>
                                            <td class="sapds-alv"> &nbsp; </td>
                                            <td class="sapds-alv"> &nbsp; </td>
                                        </tr>
                                    </tbody>
                                </table>
                            <?php } ?>
                            <!-- Function Group: End -->

                            <!-- Transaction Code -->
                            <h5 class="pt-4"><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeTRAN() ?> Transaction Code </h5>
                            <?php if (count($tcode_list) > 0) { ?>
                                <table class="table table-sm">
                                    <caption class="sapds-alv">Transactions reference to this program</caption>
                                    <tr>
                                        <th class="sapds-alv"> # </th>
                                        <th class="sapds-alv"> Transaction Code </th>
                                        <th class="sapds-alv"> Short Description </th>
                                    </tr>                        
                                    <?php
                                    $count = 0;
                                    foreach ($tcode_list as $tcode) {
                                        $count++;
                                        $tcode_desc = ABAP_DB_TABLE_TRAN::TSTCT($tcode['TCODE']);
                                        ?>
                                        <tr><td class="sapds-alv text-right"><?php echo number_format($count) ?> </td>
                                            <td class="sapds-alv"><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeTRAN() ?>
                                                <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Tran($tcode['TCODE'], $tcode_desc) ?></td>
                                            <td class="sapds-alv"><?php echo htmlentities($tcode_desc) ?>&nbsp;</td>
                                        </tr>
                                    <?php } ?>
                                    <tr><td class="sapds-alv">&nbsp;</td>
                                        <td class="sapds-alv">&nbsp;</td>
                                        <td class="sapds-alv">&nbsp;</td>
                                    </tr>
                                </table>
                            <?php } else { ?>
                                <table class="table table-sm">
                                    <caption class="sapds-alv">There is no transaction reference to this program &nbsp;</caption>
                                </table>
                            <?php } ?>
                            <!-- Transaction Code: End -->

                            <!-- Screen -->
                            <?php if (count($dynr_list) > 0) { ?>
                                <h5 class="pt-4">Screens </h5>
                                <table class="table table-sm">
                                    <tr>
                                        <th class="sapds-alv"> # </th>
                                        <th class="sapds-alv"> Screen </th>
                                        <th class="sapds-alv"> Short Description </th>
                                    </tr>
                                    <?php
                                    $count = 0;
                                    foreach ($dynr_list as $dynr) {
                                        $count++;
                                        $dynr_desc = ABAP_DB_TABLE_PROG::D020T($prog['PROGNAME'], $dynr['DNUM']);
                                        ?>
                                        <tr><td class="sapds-alv text-right"><?php echo number_format($count) ?> </td>
                                            <td class="sapds-alv"><?php echo $dynr['DNUM'] ?>&nbsp;</td>
                                            <td class="sapds-alv"><?php echo htmlentities($dynr_desc) ?>&nbsp;</td>
                                        </tr>
                                    <?php } ?>
                                    <tr><td class="sapds-alv">&nbsp;</td>
                                        <td class="sapds-alv">&nbsp;</td>
                                        <td class="sapds-alv">&nbsp;</td>
                                    </tr>
                                </table>
                            <?php } ?>
                            <!-- Screen: End -->

                            <!-- Report Texts  -->
                            <?php $rsmptexts_list_status = ABAP_DB_TABLE_PROG::RSMPTEXTS($prog['PROGNAME'], ABAP_DB_CONST::DOMAINVALUE_MP_OBJTYPE_C); ?>
                            <?php if (count($rsmptexts_list_status) > 0) { ?>
                                <h5 class="pt-4">GUI Status </h5>
                                <table class="table table-sm">
                                    <tr>
                                        <th class="sapds-alv"> # </th>
                                        <th class="sapds-alv"> GUI Status </th>
                                        <th class="sapds-alv"> Short Description </th>
                                    </tr>
                                    <?php
                                    $count = 0;
                                    foreach ($rsmptexts_list_status as $rsmptexts) {
                                        $count++;
                                        ?>
                                        <tr><td class="sapds-alv text-right"><?php echo number_format($count) ?> </td>
                                            <td class="sapds-alv"><?php echo $rsmptexts['OBJ_CODE'] ?>&nbsp;</td>
                                            <td class="sapds-alv"><?php echo htmlentities($rsmptexts['TEXT']) ?>&nbsp;</td>
                                        </tr>
                                    <?php } ?>
                                    <tr><td class="sapds-alv">&nbsp;</td>
                                        <td class="sapds-alv">&nbsp;</td>
                                        <td class="sapds-alv">&nbsp;</td>
                                    </tr>
                                </table>
                            <?php } ?>
                            <?php $rsmptexts_list_title = ABAP_DB_TABLE_PROG::RSMPTEXTS($prog['PROGNAME'], ABAP_DB_CONST::DOMAINVALUE_MP_OBJTYPE_T); ?>
                            <?php if (count($rsmptexts_list_title) > 0) { ?>
                                <h5 class="pt-4">GUI Title </h5>
                                <table class="table table-sm">
                                    <tr>
                                        <th class="sapds-alv"> # </th>
                                        <th class="sapds-alv"> GUI Title </th>
                                        <th class="sapds-alv"> Short Description </th>
                                    </tr>
                                    <?php
                                    $count = 0;
                                    foreach ($rsmptexts_list_title as $rsmptexts) {
                                        $count++;
                                        ?>
                                        <tr><td class="sapds-alv text-right"><?php echo number_format($count) ?> </td>
                                            <td class="sapds-alv"><?php echo $rsmptexts['OBJ_CODE'] ?>&nbsp;</td>
                                            <td class="sapds-alv"><?php echo htmlentities($rsmptexts['TEXT']) ?>&nbsp;</td>
                                        </tr>
                                    <?php } ?>
                                    <tr><td class="sapds-alv">&nbsp;</td>
                                        <td class="sapds-alv">&nbsp;</td>
                                        <td class="sapds-alv">&nbsp;</td>
                                    </tr>
                                </table>
                            <?php } ?>
                            <!-- Report Texts: End  -->

                            <h5 class="pt-4"><?php echo GLOBAL_ABAP_ICON::getIcon4History() ?> History </h5>
                            <table>
                                <tbody>
                                    <tr><td class="sapds-gui-label"> Last changed by/on      </td><td class="sapds-gui-field"><?php echo $prog['CNAM'] ?>&nbsp;</td><td> <?php echo $prog['CDAT'] ?>&nbsp;</td></tr>
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
