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
$dtel = ABAP_DB_TABLE_DTEL::DD04L(strtoupper($ObjID));
if (empty($dtel['ROLLNAME'])) {
    ABAP_UI_TOOL::Redirect404();
}
$dtel_desc = ABAP_DB_TABLE_DTEL::DD04T($dtel['ROLLNAME']);
$dtel_label = ABAP_DB_TABLE_DTEL::DD04T_ALL($dtel['ROLLNAME']);
$dtel_refkind_desc = ABAP_DB_TABLE_DOMA::DD07T(ABAP_DB_CONST::DOMAIN_DD04L_REFKIND, $dtel['REFKIND']);
$dtel_reftype_desc = ABAP_DB_TABLE_DOMA::DD07T(ABAP_DB_CONST::DOMAIN_DD04L_REFTYPE, $dtel['REFTYPE']);
$dtel_datatype_desc = ABAP_DB_TABLE_DOMA::DD07T(ABAP_DB_CONST::DOMAIN_DATATYPE, $dtel['DATATYPE']);
$dok_de = ABAP_DB_TABLE_DTEL::YDOK_DE($dtel['ROLLNAME']);
$dok_dz = ABAP_DB_TABLE_DTEL::YDOK_DZ($dtel['ROLLNAME']);

$wul_counter_list = ABAPANA_DB_TABLE::WULCOUNTER_List(GLOBAL_ABAP_OTYPE::DTEL_NAME, $dtel['ROLLNAME']);
$wul_list = ABAP_DB_TABLE_TABL::DD03L_ROLLNAME($ObjID);
$wil_enabled = TRUE;
$wil_counter_list = ABAPANA_DB_TABLE::WILCOUNTER_List(GLOBAL_ABAP_OTYPE::DTEL_NAME, $dtel['ROLLNAME']);

$hier = ABAP_DB_TABLE_HIER::Hier(ABAP_DB_TABLE_HIER::TADIR_PGMID_R3TR, GLOBAL_ABAP_OTYPE::DTEL_NAME, $dtel['ROLLNAME']);
$GLOBALS['TITLE_TEXT'] = ABAP_UI_TOOL::GetObjectTitle(GLOBAL_ABAP_OTYPE::DTEL_NAME, $dtel['ROLLNAME']);

$json_ld = new \OrgSchema\Thing();
$json_ld->name = $dtel['ROLLNAME'];
$json_ld->alternateName = $dtel_desc;
$json_ld->description = $GLOBALS['TITLE_TEXT'];
$json_ld->image = GLOBAL_ABAP_ICON::getIconURL(GLOBAL_ABAP_ICON::OTYPE_DTEL, TRUE);
$json_ld->url = ABAP_UI_DS_Navigation::GetObjectURL(GLOBAL_ABAP_OTYPE::DTEL_NAME, $json_ld->name);
?>
<!DOCTYPE html>
<!-- DDIC Data Element object. -->
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <title><?php echo $GLOBALS['TITLE_TEXT'] . GLOBAL_WEBSITE::SAPDS_ORG_URL_TITLE ?> </title>
        <meta name="author" content="SAP Datasheet" />
        <meta name="description" content="<?php echo GLOBAL_WEBSITE::SAPDS_ORG_URL_META_DESC; ?>" />
        <meta name="keywords" content="SAP,<?php echo GLOBAL_ABAP_OTYPE::DTEL_DESC ?>,<?php echo $dtel['ROLLNAME'] ?>,<?php echo $dtel_desc ?>" />

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
                            <tr><td><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeDTEL() ?>
                                    <a href="/abap/dtel/"><?php echo GLOBAL_ABAP_OTYPE::DTEL_DESC ?></a></td></tr>
                            <tr><td><small><strong>Object name </strong></small></td></tr>
                            <tr><td><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeDTEL() ?>
                                    <a href="#" title="<?php echo $dtel_desc ?>"><?php echo $dtel['ROLLNAME'] ?></a> </td></tr>
                        </tbody>
                    </table>

                    <?php require $__ROOT__ . '/include/abap_oname_wul.php' ?>
                    <?php require $__ROOT__ . '/include/abap_ads_side.php' ?>

                    <h6 class="pt-4">Used by Table/Structure</h6>
                    <table>
                        <tbody>
                            <?php if (empty($wul_list) === FALSE) { ?>
                                <?php foreach ($wul_list as $wul_item) { ?>
                                    <tr><td><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeTABL() ?>
                                            <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Tabl($wul_item['TABNAME'], ABAP_DB_TABLE_TABL::DD02T($wul_item['TABNAME'])) ?>&nbsp;</td></tr>
                                <?php } ?>
                            <?php } else { ?>
                                <tr><td>Not Used by Anyone</td></tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <main class="col-xl-8 col-lg-8 col-md-6  col-sm-9    col-12 bd-content" role="main">
                    <nav class="pt-3" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/"><?php echo GLOBAL_ABAP_ICON::getIcon4Home() ?> Home</a></li>
                            <li class="breadcrumb-item"><a href="/abap/">ABAP Object Types</a></li>
                            <li class="breadcrumb-item"><a href="/abap/dtel/"><?php echo GLOBAL_ABAP_OTYPE::DTEL_DESC ?></a></li>
                            <li class="breadcrumb-item active"><a href="#"><?php echo $dtel['ROLLNAME'] ?></a></li>
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
                                    <tr><td class="sapds-gui-label"> Data Element      </td><td class="sapds-gui-field"> <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Dtel($dtel['ROLLNAME'], $dtel_desc) ?> </td></tr>
                                    <tr><td class="sapds-gui-label"> Short Description </td><td class="sapds-gui-field"> <?php echo htmlentities($dtel_desc) ?> &nbsp;</td></tr>
                                </tbody>
                            </table>

                            <h5 class="pt-4"><?php echo GLOBAL_ABAP_ICON::getIcon4OOClassAttribute() ?> Data Type </h5>
                            <table>
                                <tbody>
                                    <tr><td class="sapds-gui-label"> Category of Dictionary Type </td>
                                        <td class="sapds-gui-field"> <?php echo ABAP_UI_DS_Navigation::GetHyperlink4DomainValue(ABAP_DB_CONST::DOMAIN_DD04L_REFKIND, $dtel['REFKIND'], $dtel_refkind_desc); ?> &nbsp;</td>
                                        <td><?php echo $dtel_refkind_desc ?></td></tr>
                                    <tr><td class="sapds-gui-label"> Type of Object Referenced  </td>
                                        <td class="sapds-gui-field"> <?php echo ABAP_UI_DS_Navigation::GetHyperlink4DomainValue(ABAP_DB_CONST::DOMAIN_DD04L_REFTYPE, $dtel['REFTYPE'], $dtel_reftype_desc); ?> &nbsp;</td>
                                        <td><?php echo $dtel_reftype_desc ?></td></tr>
                                    <tr><td class="sapds-gui-label">Domain / Name of Reference Type</td>
                                        <td class="sapds-gui-field"> <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Doma($dtel['DOMNAME'], ''); ?> &nbsp;</td>
                                        <td>&nbsp;</td></tr>
                                    <tr><td class="sapds-gui-label">Data Type </td>
                                        <td class="sapds-gui-field"> <?php echo ABAP_UI_DS_Navigation::GetHyperlink4DomainValue(ABAP_DB_CONST::DOMAIN_DATATYPE, $dtel['DATATYPE'], $dtel_datatype_desc) ?> &nbsp;</td>
                                        <td><?php echo htmlentities($dtel_datatype_desc) ?>&nbsp;</td></tr>
                                    <tr><td class="sapds-gui-label">Length </td>
                                        <td class="sapds-gui-field text-right"> <?php echo intval($dtel['LENG']) ?> &nbsp;</td>
                                        <td>&nbsp;</td></tr>
                                    <tr><td class="sapds-gui-label">Decimal Places </td>
                                        <td class="sapds-gui-field text-right"> <?php echo intval($dtel['DECIMALS']) ?> &nbsp;</td>
                                        <td>&nbsp;</td></tr>
                                    <tr><td class="sapds-gui-label">Output Length </td>
                                        <td class="sapds-gui-field text-right"> <?php echo intval($dtel['OUTPUTLEN']) ?> &nbsp;</td>
                                        <td>&nbsp;</td></tr>
                                    <tr><td class="sapds-gui-label">Value Table </td>
                                        <td class="sapds-gui-field text-right"> <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Tabl($dtel['ENTITYTAB'], '') ?> &nbsp;</td>
                                        <td>&nbsp;</td></tr>
                                </tbody>
                            </table>

                            <h5 class="pt-4"><?php echo GLOBAL_ABAP_ICON::getIcon4DisplayMore() ?> Further Characteristics </h5>
                            <table>
                                <tbody>
                                    <tr><td class="sapds-gui-label"> Search Help: Name       </td>
                                        <td class="sapds-gui-field"> <?php echo $dtel['SHLPNAME'] ?> &nbsp;</td>
                                        <td>&nbsp;</td></tr>
                                    <tr><td class="sapds-gui-label"> Search Help: Parameters </td>
                                        <td class="sapds-gui-field"> <?php echo $dtel['SHLPFIELD'] ?>&nbsp;</td>
                                        <td>&nbsp;</td></tr>
                                    <tr><td class="sapds-gui-label"> Parameter ID </td><td class="sapds-gui-field"> <?php echo $dtel['MEMORYID'] ?>&nbsp;</td><td>&nbsp;</td></tr>
                                    <tr><td class="sapds-gui-label"> Default Component name </td>
                                        <td class="sapds-gui-field"> <?php echo $dtel['DEFFDNAME'] ?>&nbsp;</td>
                                        <td>&nbsp;</td></tr>
                                    <tr><td class="sapds-gui-label"> Change document  </td>
                                        <td><?php echo ABAP_UI_TOOL::GetCheckBox('LOGFLAG', $dtel['LOGFLAG']) ?>&nbsp;</td>
                                        <td>&nbsp;</td></tr>
                                    <tr><td class="sapds-gui-label"> No Input History </td>
                                        <td><?php echo ABAP_UI_TOOL::GetCheckBox("NOHISTORY", $dtel['NOHISTORY']) ?>&nbsp;</td>
                                        <td>&nbsp;</td></tr>
                                    <tr><td class="sapds-gui-label"> Basic direction is set to LTR  </td>
                                        <td><?php echo ABAP_UI_TOOL::GetCheckBox("LTR", $dtel['LTRFLDDIS']) ?>&nbsp;</td>
                                        <td>&nbsp;</td></tr>
                                    <tr><td class="sapds-gui-label"> No BIDI Filtering </td>
                                        <td><?php echo ABAP_UI_TOOL::GetCheckBox("BI", $dtel['BIDICTRLC']) ?>&nbsp;</td>
                                        <td>&nbsp;</td></tr>
                                </tbody>
                            </table>

                            <h5 class="pt-4"><?php echo GLOBAL_ABAP_ICON::getIcon4DisplayText() ?> Field Label </h5>
                            <table>
                                <tbody>
                                    <tr><td> &nbsp; </td><td>Length &nbsp;</td><td>Field Label &nbsp;</td></tr>
                                    <tr><td class="sapds-gui-label"> Short   </td><td class="sapds-gui-field text-right"><?php echo intval($dtel['SCRLEN1']) ?>&nbsp;</td><td class="sapds-gui-field"><?php echo $dtel_label['SCRTEXT_S'] ?>&nbsp;</td></tr>
                                    <tr><td class="sapds-gui-label"> Medium  </td><td class="sapds-gui-field text-right"><?php echo intval($dtel['SCRLEN2']) ?>&nbsp;</td><td class="sapds-gui-field"><?php echo $dtel_label['SCRTEXT_M'] ?>&nbsp;</td></tr>
                                    <tr><td class="sapds-gui-label"> Long    </td><td class="sapds-gui-field text-right"><?php echo intval($dtel['SCRLEN3']) ?>&nbsp;</td><td class="sapds-gui-field"><?php echo $dtel_label['SCRTEXT_L'] ?>&nbsp;</td></tr>
                                    <tr><td class="sapds-gui-label"> Heading </td><td class="sapds-gui-field text-right"><?php echo intval($dtel['HEADLEN']) ?>&nbsp;</td><td class="sapds-gui-field"><?php echo $dtel_label['REPTEXT'] ?>&nbsp;</td></tr>
                                </tbody>
                            </table>
                            <?php if (empty($dok_de) === FALSE) { ?>
                                <h5 class="pt-4" id="<?php echo ABAP_UI_CONST::ANCHOR_DOCUMENT ?>"><?php echo GLOBAL_ABAP_ICON::getIcon4SystemHelp() ?> Documentation </h5>
                                <div class="sapds-f1doc"><?php echo $dok_de ?></div>
                            <?php } ?>
                            <?php
                            if (empty(array_filter($dok_dz)) === FALSE) {
                                foreach ($dok_dz as $dok_dz_item) {
                                    ?>
                                    <h5 class="pt-4"><?php echo GLOBAL_ABAP_ICON::getIcon4SystemHelp() ?> Supplementary Documentation - <?php echo $dok_dz_item['OBJECT'] ?> </h5>
                                    <div class="sapds-f1doc"><?php echo $dok_dz_item['HTMLTEXT'] ?></div>
                                    <?php
                                }
                            }
                            ?>

                            <h5 class="pt-4"><?php echo GLOBAL_ABAP_ICON::getIcon4History() ?> History </h5>
                            <table>
                                <tbody>
                                    <tr><td class="sapds-gui-label"> Last changed by/on      </td><td class="sapds-gui-field"><?php echo $dtel['AS4USER'] ?>&nbsp;</td><td> <?php echo $dtel['AS4DATE'] ?>&nbsp;</td></tr>
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

