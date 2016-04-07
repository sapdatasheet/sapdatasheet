<!DOCTYPE html>
<!-- DDIC Data Element object. -->
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

$wul_counter_list = ABAPANA_DB_TABLE::WULCOUNTER_List(ABAP_OTYPE::DTEL_NAME, $dtel['ROLLNAME']);
$wul_list = ABAP_DB_TABLE_TABL::DD03L_ROLLNAME($ObjID);
$wil_enabled = TRUE;
$wil_counter_list = ABAPANA_DB_TABLE::WILCOUNTER_List(ABAP_OTYPE::DTEL_NAME, $dtel['ROLLNAME']);

$hier = ABAP_DB_TABLE_HIER::Hier(ABAP_DB_TABLE_HIER::TADIR_PGMID_R3TR, ABAP_OTYPE::DTEL_NAME, $dtel['ROLLNAME']);
$GLOBALS['TITLE_TEXT'] = ABAP_UI_TOOL::GetObjectTitle(ABAP_OTYPE::DTEL_NAME, $dtel['ROLLNAME']);
?>
<html>
    <head>
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" href="/abap.css" type="text/css" />
        <title><?php echo $GLOBALS['TITLE_TEXT'] . WEBSITE::TITLE ?> </title>
        <meta name="keywords" content="SAP,<?php echo ABAP_OTYPE::DTEL_DESC ?>,<?php echo $dtel['ROLLNAME'] ?>,<?php echo $dtel_desc ?>" />
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
                    <tr><td class="left_value"><?php echo ABAP_Navigation::GetURL4Cvers($hier->DLVUNIT, $hier->DLVUNIT_T) ?>&nbsp;</td></tr>
                    <tr><td class="left_attribute"> Application Component ID</td></tr>
                    <tr><td class="left_value"><?php echo ABAP_Navigation::GetURL4Bmfr($hier->FCTR_ID, $hier->POSID, $hier->POSID_T) ?>&nbsp;</td></tr>
                    <tr><td class="left_attribute"> Package </td></tr>
                    <tr><td class="left_value"><?php echo ABAP_Navigation::GetURL4Devc($hier->DEVCLASS, $hier->DEVCLASS_T) ?></td></tr>
                    <tr><td class="left_attribute"> Object type </td></tr>
                    <tr><td class="left_value"><a href="/abap/dtel/"><?php echo ABAP_OTYPE::DTEL_DESC ?></a></td></tr>
                    <tr><td class="left_attribute"> Object name </td></tr>
                    <tr><td class="left_value"> <a href="#" title="<?php echo $dtel_desc ?>"><?php echo $dtel['ROLLNAME'] ?></a> </td></tr>
                </tbody>
            </table>

            <?php require $__ROOT__ . '/include/abap_oname_wul.php' ?>

            <h5>Used by Table/Structure</h5>
            <table class="content_obj">
                <tbody>
                    <?php if (empty($wul_list) === FALSE) { ?>
                        <?php foreach ($wul_list as $wul_item) { ?>
                            <tr><td class="left_value"><?php echo ABAP_Navigation::GetURL4Tabl($wul_item['TABNAME'], ABAP_DB_TABLE_TABL::DD02T($wul_item['TABNAME'])) ?>&nbsp;</td></tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr><td class="left_value">Not Used by Anyone</td></tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Content Navigator -->
            <div class="content_navi">
                <a href="/">Home page</a> &gt;
                <a href="/abap/">ABAP Object</a> &gt;
                <a href="/abap/dtel/"><?php echo ABAP_OTYPE::DTEL_DESC ?></a> &gt;
                <a href="#"><?php echo $dtel['ROLLNAME'] ?></a>
            </div>

            <!-- Content Object -->
            <div class="content_obj_title"><span><?php echo $GLOBALS['TITLE_TEXT'] ?></span></div>
            <div class="content_obj">
                <div>
                    <?php include $__ROOT__ . '/include/google/adsense-content-top.html' ?>
                </div>

                <?php require $__ROOT__ . '/include/abap_oname_hier.php' ?>

                <h4> Basic data </h4>
                <table class="content_obj">
                    <tbody>
                        <tr><td class="content_label"> Data Element      </td><td class="field"> <?php echo ABAP_Navigation::GetURL4Dtel($dtel['ROLLNAME'], $dtel_desc) ?> </td></tr>
                        <tr><td class="content_label"> Short Description </td><td class="field"> <?php echo htmlentities($dtel_desc) ?> &nbsp;</td></tr>
                    </tbody>
                </table>

                <h4> Data Type </h4>
                <table class="content_obj">
                    <tbody>
                        <tr><td class="content_label"> Category of Dictionary Type </td>
                            <td class="field"> <?php echo ABAP_Navigation::GetURL4DomainValue(ABAP_DB_CONST::DOMAIN_DD04L_REFKIND, $dtel['REFKIND'], $dtel_refkind_desc); ?> &nbsp;</td>
                            <td><?php echo $dtel_refkind_desc ?></td></tr>
                        <tr><td class="content_label"> Type of Object Referenced  </td>
                            <td class="field"> <?php echo ABAP_Navigation::GetURL4DomainValue(ABAP_DB_CONST::DOMAIN_DD04L_REFTYPE, $dtel['REFTYPE'], $dtel_reftype_desc); ?> &nbsp;</td>
                            <td><?php echo $dtel_reftype_desc ?></td></tr>
                        <tr><td class="content_label">Domain / Name of Reference Type</td>
                            <td class="field"> <?php echo ABAP_Navigation::GetURL4Doma($dtel['DOMNAME'], ''); ?> &nbsp;</td>
                            <td>&nbsp;</td></tr>
                        <tr><td class="content_label">Data Type </td>
                            <td class="field"> <?php echo ABAP_Navigation::GetURL4DomainValue(ABAP_DB_CONST::DOMAIN_DATATYPE, $dtel['DATATYPE'], $dtel_datatype_desc) ?> &nbsp;</td>
                            <td><?php echo htmlentities($dtel_datatype_desc) ?>&nbsp;</td></tr>
                        <tr><td class="content_label">Length </td>
                            <td class="field_right"> <?php echo intval($dtel['LENG']) ?> &nbsp;</td>
                            <td>&nbsp;</td></tr>
                        <tr><td class="content_label">Decimal Places </td>
                            <td class="field_right"> <?php echo intval($dtel['DECIMALS']) ?> &nbsp;</td>
                            <td>&nbsp;</td></tr>
                        <tr><td class="content_label">Output Length </td>
                            <td class="field_right"> <?php echo intval($dtel['OUTPUTLEN']) ?> &nbsp;</td>
                            <td>&nbsp;</td></tr>
                        <tr><td class="content_label">Value Table </td>
                            <td class="field_right"> <?php echo ABAP_Navigation::GetURL4Tabl($dtel['ENTITYTAB'], '') ?> &nbsp;</td>
                            <td>&nbsp;</td></tr>
                    </tbody>
                </table>

                <h4> Further Characteristics </h4>
                <table class="content_obj">
                    <tbody>
                        <tr><td class="content_label"> Search Help: Name       </td>
                            <td class="field"> <?php echo $dtel['SHLPNAME'] ?> &nbsp;</td>
                            <td>&nbsp;</td></tr>
                        <tr><td class="content_label"> Search Help: Parameters </td>
                            <td class="field"> <?php echo $dtel['SHLPFIELD'] ?>&nbsp;</td>
                            <td>&nbsp;</td></tr>
                        <tr><td class="content_label"> Parameter ID </td><td class="field"> <?php echo $dtel['MEMORYID'] ?>&nbsp;</td><td>&nbsp;</td></tr>
                        <tr><td class="content_label"> Default Component name </td>
                            <td class="field"> <?php echo $dtel['DEFFDNAME'] ?>&nbsp;</td>
                            <td>&nbsp;</td></tr>
                        <tr><td class="content_label"> Change document  </td>
                            <td><?php echo ABAP_UI_TOOL::GetCheckBox('LOGFLAG', $dtel['LOGFLAG']) ?>&nbsp;</td>
                            <td>&nbsp;</td></tr>
                        <tr><td class="content_label"> No Input History </td>
                            <td><?php echo ABAP_UI_TOOL::GetCheckBox("NOHISTORY", $dtel['NOHISTORY']) ?>&nbsp;</td>
                            <td>&nbsp;</td></tr>
                        <tr><td class="content_label"> Basic direction is set to LTR  </td>
                            <td><?php echo ABAP_UI_TOOL::GetCheckBox("LTR", $dtel['LTRFLDDIS']) ?>&nbsp;</td>
                            <td>&nbsp;</td></tr>
                        <tr><td class="content_label"> No BIDI Filtering </td>
                            <td><?php echo ABAP_UI_TOOL::GetCheckBox("BI", $dtel['BIDICTRLC']) ?>&nbsp;</td>
                            <td>&nbsp;</td></tr>
                    </tbody>
                </table>

                <h4> Field Label </h4>
                <table class="content_obj">
                    <tbody>
                        <tr><td> &nbsp; </td><td>Length &nbsp;</td><td>Field Label &nbsp;</td></tr>
                        <tr><td class="content_label"> Short   </td><td class="field_right"><?php echo intval($dtel['SCRLEN1']) ?>&nbsp;</td><td class="field"><?php echo $dtel_label['SCRTEXT_S'] ?>&nbsp;</td></tr>
                        <tr><td class="content_label"> Medium  </td><td class="field_right"><?php echo intval($dtel['SCRLEN2']) ?>&nbsp;</td><td class="field"><?php echo $dtel_label['SCRTEXT_M'] ?>&nbsp;</td></tr>
                        <tr><td class="content_label"> Long    </td><td class="field_right"><?php echo intval($dtel['SCRLEN3']) ?>&nbsp;</td><td class="field"><?php echo $dtel_label['SCRTEXT_L'] ?>&nbsp;</td></tr>
                        <tr><td class="content_label"> Heading </td><td class="field_right"><?php echo intval($dtel['HEADLEN']) ?>&nbsp;</td><td class="field"><?php echo $dtel_label['REPTEXT'] ?>&nbsp;</td></tr>
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
                <table class="content_obj">
                    <tbody>
                        <tr><td class="content_label"> Last changed by/on      </td><td class="field"><?php echo $dtel['AS4USER'] ?>&nbsp;</td><td> <?php echo $dtel['AS4DATE'] ?>&nbsp;</td></tr>
                        <tr><td class="content_label"> SAP Release Created in  </td><td class="field"><?php echo $hier->CRELEASE ?>&nbsp;</td><td>&nbsp;</td></tr>
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

