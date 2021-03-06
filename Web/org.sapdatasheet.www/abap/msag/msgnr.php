<?php
$__WS_ROOT__ = dirname(__FILE__, 4);
$__ROOT__ = dirname(__FILE__, 3);

require_once ($__WS_ROOT__ . '/common-php/library/global.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_db.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_ui.php');
require_once ($__WS_ROOT__ . '/common-php/library/schemaorg.php');
GLOBAL_UTIL::UpdateSAPDescLangu();

if (strlen(trim($ObjID)) == 0 || strlen(trim($MsgNr)) == 0) {
    ABAP_UI_TOOL::Redirect404();
}

$ObjID = strtoupper($ObjID);
$t100a = ABAP_DB_TABLE_MSAG::T100A(strtoupper($ObjID));
if (empty($t100a['ARBGB'])) {
    ABAP_UI_TOOL::Redirect404();
}

$t100t = ABAP_DB_TABLE_MSAG::T100T($ObjID);
$t100_nr_text = ABAP_DB_TABLE_MSAG::T100_NR($ObjID, $MsgNr);

$t100u = ABAP_DB_TABLE_MSAG::T100U($ObjID, $MsgNr);
$t100u_t = ABAP_DB_TABLE_DOMA::DD07T(ABAP_DB_TABLE_MSAG::T100U_SELFDEF_DOMAIN, $t100u['SELFDEF']);
$t100x = ABAP_DB_TABLE_MSAG::T100X($ObjID, $MsgNr);
$dok_na = ABAP_DB_TABLE_MSAG::YDOK_NA($ObjID, $MsgNr);

$wul_counter_list = ABAPANA_DB_TABLE::WULCOUNTER_List(GLOBAL_ABAP_OTYPE::NN_NAME, $ObjID, $MsgNr);

$hier = ABAP_DB_TABLE_HIER::Hier(ABAP_DB_TABLE_HIER::TADIR_PGMID_R3TR, GLOBAL_ABAP_OTYPE::MSAG_NAME, $ObjID);
$GLOBALS['TITLE_TEXT'] = 'SAP ABAP ' . GLOBAL_ABAP_OTYPE::MSAG_DESC . ' ' . $ObjID . ' Message Number ' . $MsgNr . ' (' . $t100_nr_text . ')';

$json_ld = new \OrgSchema\Thing();
$json_ld->name = $t100a['ARBGB'] . '-' . $MsgNr;
$json_ld->alternateName = $t100_nr_text;
$json_ld->description = $GLOBALS['TITLE_TEXT'];
$json_ld->image = GLOBAL_ABAP_ICON::getIconURL(GLOBAL_ABAP_ICON::OTYPE_NN, TRUE);
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
        <meta name="keywords" content="SAP,<?php echo GLOBAL_ABAP_OTYPE::MSAG_DESC ?>,<?php echo $ObjID ?>,<?php echo $MsgNr ?>,<?php echo $t100t ?>,<?php echo $t100_nr_text ?>" />

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
                            <tr><td><small><strong> Object name </strong></small></td></tr>
                            <tr><td><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeNN() ?>
                                    <a href="#" title="<?php echo $t100_nr_text ?>"><?php echo $ObjID . '-' . $MsgNr ?></a> </td></tr>
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
                            <li class="breadcrumb-item"><a href="/abap/msag/<?php echo $ObjID ?>.html"><?php echo $ObjID ?></a></li>
                            <li class="breadcrumb-item active"><a href="#"><?php echo $ObjID . '-' . $MsgNr ?></a></li>
                        </ol>
                    </nav>

                    <div class="card shadow">
                        <div class="card-header sapds-card-header"><?php echo $GLOBALS['TITLE_TEXT'] ?></div>
                        <div class="card-body table-responsive sapds-card-body">
                            <div class="align-content-start"><?php include $__WS_ROOT__ . '/common-php/google/adsense-content-top.html' ?></div>
                            <?php require $__ROOT__ . '/include/abap_desc_language.php' ?>

                            <?php require $__ROOT__ . '/include/abap_oname_hier.php' ?>

                            <h5 class="pt-4"> <?php echo GLOBAL_ABAP_ICON::getIcon4Header() ?> Attribute </h5>
                            <table>
                                <tbody>
                                    <tr><td class="sapds-gui-label"> Message class </td>
                                        <td><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeMSAG() ?></td>
                                        <td class="sapds-gui-field"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4Msag($ObjID, $t100t, FALSE); ?> </td>
                                        <td> &nbsp;</td>
                                    </tr>
                                    <tr><td class="sapds-gui-label"> Short Description</td>
                                        <td><?php echo GLOBAL_ABAP_ICON::getIcon4Description() ?></td>
                                        <td class="sapds-gui-field"><?php echo $t100t ?> &nbsp;</td>
                                        <td> &nbsp; </td>
                                    </tr>
                                    <tr><td class="sapds-gui-label"> Message Number </td>
                                        <td> <?php echo GLOBAL_ABAP_ICON::getIcon4OtypeNN() ?></td>
                                        <td class="sapds-gui-field"><a href="#" title="<?php echo $t100_nr_text ?>"><?php echo $MsgNr ?></a> </td>
                                        <td> &nbsp;</td>
                                    </tr>
                                    <tr><td class="sapds-gui-label"> Documentation status</td>
                                        <td> &nbsp;</td>
                                        <td class="sapds-gui-field"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4DomainValue(ABAP_DB_TABLE_MSAG::T100U_SELFDEF_DOMAIN, $t100u['SELFDEF'], $t100u_t) ?> &nbsp;</td>
                                        <td><?php echo GLOBAL_ABAP_ICON::getIcon4Description() ?> <?php echo $t100u_t ?> </td>
                                    </tr>
                                    <tr><td class="sapds-gui-label"> Authorization check Error Message</td>
                                        <td> &nbsp;</td>
                                        <td> <?php echo ABAP_UI_TOOL::GetCheckBox('AUTH_CHECK', $t100x['AUTH_CHECK']) ?> &nbsp;</td>
                                        <td> &nbsp; </td>
                                    </tr>
                                    <tr><td class="sapds-gui-label"> Changed On</td>
                                        <td><?php echo GLOBAL_ABAP_ICON::getIcon4Date() ?></td>
                                        <td class="sapds-gui-field"><?php echo $t100u['DATUM'] ?>&nbsp;</td>
                                        <td>&nbsp; </td>
                                    </tr>
                                </tbody>
                            </table>

                            <h5 class="pt-4"> <?php echo GLOBAL_ABAP_ICON::getIcon4DisplayText() ?> Message Text </h5>
                            <div class="sapds-f1doc"><?php echo $t100_nr_text ?></div>
                            <?php if (empty(trim($dok_na)) === FALSE) { ?>
                                <h5 class="pt-4"><?php echo GLOBAL_ABAP_ICON::getIcon4SystemHelp() ?> Help Document </h5>
                                <div class="sapds-f1doc"><?php echo $dok_na ?></div>
                            <?php } ?>

                            <h5 class="pt-4"> <?php echo GLOBAL_ABAP_ICON::getIcon4History() ?>  History </h5>
                            <table>
                                <tbody>
                                    <tr><td class="sapds-gui-label"> Last changed on/by      </td>
                                        <td><?php echo GLOBAL_ABAP_ICON::getIcon4Date() ?></td>
                                        <td class="sapds-gui-field"><?php echo $t100a['LDATE'] ?>&nbsp;</td>
                                        <td> <?php echo $t100a['LASTUSER'] ?>&nbsp;</td></tr>
                                    <tr><td class="sapds-gui-label"> SAP Release Created in  </td>
                                        <td>&nbsp; </td>
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
