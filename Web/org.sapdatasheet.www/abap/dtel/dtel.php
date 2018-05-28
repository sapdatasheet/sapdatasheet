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
        <title><?php echo $GLOBALS['TITLE_TEXT'] . GLOBAL_WEBSITE_SAPDS::TITLE ?> </title>
        <meta name="author" content="SAP Datasheet" />
        <meta name="description" content="<?php echo GLOBAL_WEBSITE_SAPDS::META_DESC; ?>" />
        <meta name="keywords" content="SAP,<?php echo GLOBAL_ABAP_OTYPE::DTEL_DESC ?>,<?php echo $dtel['ROLLNAME'] ?>,<?php echo $dtel_desc ?>" />

        <link rel="stylesheet" type="text/css"  href="/3rdparty/bootstrap/css/bootstrap.min.css"/>
        <link rel="stylesheet" type="text/css"  href="/sapdatasheet.css"/>

        <script type="application/ld+json"><?php echo $json_ld->toJson() ?></script>
    </head>
    <body>

        <!-- Header -->
        <?php require $__ROOT__ . '/include/header.php' ?>

        <!-- Left -->
        <div class="left">
            <h5>&nbsp;</h5>
            <h5>Object Hierarchy</h5>
            <table>
                <tbody>
                    <tr><td>Software Component</td></tr>
                    <tr><td><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeCVERS() ?>
                            <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Cvers($hier->DLVUNIT, $hier->DLVUNIT_T) ?>&nbsp;</td></tr>
                    <tr><td> Application Component ID</td></tr>
                    <tr><td><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeBMFR() ?>
                            <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Bmfr($hier->FCTR_ID, $hier->POSID, $hier->POSID_T) ?>&nbsp;</td></tr>
                    <tr><td> Package </td></tr>
                    <tr><td><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeDEVC() ?>
                            <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Devc($hier->DEVCLASS, $hier->DEVCLASS_T) ?></td></tr>
                    <tr><td> Object type </td></tr>
                    <tr><td><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeDTEL() ?>
                            <a href="/abap/dtel/"><?php echo GLOBAL_ABAP_OTYPE::DTEL_DESC ?></a></td></tr>
                    <tr><td> Object name </td></tr>
                    <tr><td><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeDTEL() ?>
                            <a href="#" title="<?php echo $dtel_desc ?>"><?php echo $dtel['ROLLNAME'] ?></a> </td></tr>
                </tbody>
            </table>

            <?php require $__ROOT__ . '/include/abap_oname_wul.php' ?>

            <h5>Used by Table/Structure</h5>
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

            <?php require $__ROOT__ . '/include/abap_relatedlinks.php' ?>
            <h5>&nbsp;</h5>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Content Navigator -->
            <div class="content_navi">
                <a href="/"><?php echo GLOBAL_ABAP_ICON::getIcon4Home() ?> Home page</a> &gt;
                <a href="/abap/">ABAP Object</a> &gt;
                <a href="/abap/dtel/"><?php echo GLOBAL_ABAP_OTYPE::DTEL_DESC ?></a> &gt;
                <a href="#"><?php echo $dtel['ROLLNAME'] ?></a>
            </div>

            <!-- Content Object -->
            <div class="content_obj_title"><span><?php echo $GLOBALS['TITLE_TEXT'] ?></span></div>
            <div class="content_obj">
                <div>
                    <?php include $__WS_ROOT__ . '/common-php/google/adsense-content-top.html' ?>
                </div>

                <?php require $__ROOT__ . '/include/abap_oname_hier.php' ?>

                <h5 class="pt-4"> Basic Data </h5>
                <table>
                    <tbody>
                        <tr><td class="sapds-gui-label"> Data Element      </td><td class="sapds-gui-field"> <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Dtel($dtel['ROLLNAME'], $dtel_desc) ?> </td></tr>
                        <tr><td class="sapds-gui-label"> Short Description </td><td class="sapds-gui-field"> <?php echo htmlentities($dtel_desc) ?> &nbsp;</td></tr>
                    </tbody>
                </table>

                <h4> Data Type </h4>
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
                            <td class="field_right"> <?php echo intval($dtel['LENG']) ?> &nbsp;</td>
                            <td>&nbsp;</td></tr>
                        <tr><td class="sapds-gui-label">Decimal Places </td>
                            <td class="field_right"> <?php echo intval($dtel['DECIMALS']) ?> &nbsp;</td>
                            <td>&nbsp;</td></tr>
                        <tr><td class="sapds-gui-label">Output Length </td>
                            <td class="field_right"> <?php echo intval($dtel['OUTPUTLEN']) ?> &nbsp;</td>
                            <td>&nbsp;</td></tr>
                        <tr><td class="sapds-gui-label">Value Table </td>
                            <td class="field_right"> <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Tabl($dtel['ENTITYTAB'], '') ?> &nbsp;</td>
                            <td>&nbsp;</td></tr>
                    </tbody>
                </table>

                <h4> Further Characteristics </h4>
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

                <h4> Field Label </h4>
                <table>
                    <tbody>
                        <tr><td> &nbsp; </td><td>Length &nbsp;</td><td>Field Label &nbsp;</td></tr>
                        <tr><td class="sapds-gui-label"> Short   </td><td class="field_right"><?php echo intval($dtel['SCRLEN1']) ?>&nbsp;</td><td class="sapds-gui-field"><?php echo $dtel_label['SCRTEXT_S'] ?>&nbsp;</td></tr>
                        <tr><td class="sapds-gui-label"> Medium  </td><td class="field_right"><?php echo intval($dtel['SCRLEN2']) ?>&nbsp;</td><td class="sapds-gui-field"><?php echo $dtel_label['SCRTEXT_M'] ?>&nbsp;</td></tr>
                        <tr><td class="sapds-gui-label"> Long    </td><td class="field_right"><?php echo intval($dtel['SCRLEN3']) ?>&nbsp;</td><td class="sapds-gui-field"><?php echo $dtel_label['SCRTEXT_L'] ?>&nbsp;</td></tr>
                        <tr><td class="sapds-gui-label"> Heading </td><td class="field_right"><?php echo intval($dtel['HEADLEN']) ?>&nbsp;</td><td class="sapds-gui-field"><?php echo $dtel_label['REPTEXT'] ?>&nbsp;</td></tr>
                    </tbody>
                </table>
                <?php if (empty($dok_de) === FALSE) { ?>
                    <h4 id="<?php echo ABAP_UI_CONST::ANCHOR_DOCUMENT ?>"> Documentation </h4>
                    <div class="f1doc"><?php echo $dok_de ?></div>
                <?php } ?>
                <?php
                if (empty(array_filter($dok_dz)) === FALSE) {
                    foreach ($dok_dz as $dok_dz_item) {
                        ?>
                        <h4> Supplementary Documentation - <?php echo $dok_dz_item['OBJECT'] ?> </h4>
                        <div class="f1doc"><?php echo $dok_dz_item['HTMLTEXT'] ?></div>
                        <?php
                    }
                }
                ?>

                <h4> History </h4>
                <table>
                    <tbody>
                        <tr><td class="sapds-gui-label"> Last changed by/on      </td><td class="sapds-gui-field"><?php echo $dtel['AS4USER'] ?>&nbsp;</td><td> <?php echo $dtel['AS4DATE'] ?>&nbsp;</td></tr>
                        <tr><td class="sapds-gui-label"> SAP Release Created in  </td><td class="sapds-gui-field"><?php echo $hier->CRELEASE ?>&nbsp;</td><td>&nbsp;</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Footer -->
        <?php require $__ROOT__ . '/include/footer.php' ?>

    </body>
</html>
<?php
// Close PDO Database Connection
ABAP_DB_TABLE::close_conn();

