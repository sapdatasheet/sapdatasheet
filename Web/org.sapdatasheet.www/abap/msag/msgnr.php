<?php
$__ROOT__ = dirname(dirname(dirname(__FILE__)));

require_once ($__ROOT__ . '/include/common/global.php');
require_once ($__ROOT__ . '/include/common/abap_db.php');
require_once ($__ROOT__ . '/include/common/abap_ui.php');
require_once ($__ROOT__ . '/include/common/schemaorg.php');
GLOBAL_UTIL::UpdateSAPDescLangu();

if (!isset($ObjID)) {
    $ObjID = filter_input(INPUT_GET, 'id');
}
if (!isset($MsgNr)) {
    $MsgNr = strtoupper(filter_input(INPUT_GET, 'msgnr'));
}

if (empty($ObjID) || empty($MsgNr)) {
    ABAP_UI_TOOL::Redirect404();
}
$ObjID = trim($ObjID);
$MsgNr = trim($MsgNr);
if (strlen($ObjID) == 0 || strlen($MsgNr) == 0) {
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
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" href="/abap.css" type="text/css" />
        <title><?php echo $GLOBALS['TITLE_TEXT'] . GLOBAL_WEBSITE_SAPDS::TITLE ?> </title>
        <meta name="keywords" content="SAP,<?php echo GLOBAL_ABAP_OTYPE::MSAG_DESC ?>,<?php echo $ObjID ?>,<?php echo $MsgNr ?>,<?php echo $t100t ?>,<?php echo $t100_nr_text ?>" />
        <meta name="description" content="<?php echo GLOBAL_WEBSITE_SAPDS::META_DESC; ?>" />
        <meta name="author" content="SAP Datasheet" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <script type="application/ld+json"><?php echo $json_ld->toJson() ?></script>
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
                    <tr><td class="left_attribute">Software Component</td></tr>
                    <tr><td class="left_value"><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeCVERS() ?>
                            <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Cvers($hier->DLVUNIT, $hier->DLVUNIT_T) ?>&nbsp;</td></tr>
                    <tr><td class="left_attribute"> Application Component ID</td></tr>
                    <tr><td class="left_value"><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeBMFR() ?>
                            <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Bmfr($hier->FCTR_ID, $hier->POSID, $hier->POSID_T) ?>&nbsp;</td></tr>
                    <tr><td class="left_attribute"> Package </td></tr>
                    <tr><td class="left_value"><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeDEVC() ?>
                            <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Devc($hier->DEVCLASS, $hier->DEVCLASS_T) ?></td></tr>
                    <tr><td class="left_attribute"> Object type </td></tr>
                    <tr><td class="left_value"><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeMSAG() ?>
                            <a href="/abap/msag/"><?php echo GLOBAL_ABAP_OTYPE::MSAG_DESC ?></a></td></tr>
                    <tr><td class="left_attribute"> Object name </td></tr>
                    <tr><td class="left_value"><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeNN() ?>
                            <a href="#" title="<?php echo $t100_nr_text ?>"><?php echo $ObjID . '-' . $MsgNr ?></a> </td></tr>
                </tbody>
            </table>

            <?php require $__ROOT__ . '/include/abap_oname_wul.php' ?>
            <?php require $__ROOT__ . '/include/abap_relatedlinks.php' ?>
            <h5>&nbsp;</h5>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Content Navigator -->
            <div class="content_navi">
                <a href="/"><?php echo GLOBAL_ABAP_ICON::getIcon4Home() ?> Home page</a> &gt;
                <a href="/abap/">ABAP Object</a> &gt;
                <a href="/abap/msag/"><?php echo GLOBAL_ABAP_OTYPE::MSAG_DESC ?></a> &gt;
                <a href="/abap/msag/<?php echo $ObjID ?>.html"><?php echo $ObjID ?></a> &gt;
                <a href="#"><?php echo $ObjID . '-' . $MsgNr ?></a>
            </div>

            <!-- Content Object -->
            <div class="content_obj_title"><span><?php echo $GLOBALS['TITLE_TEXT'] ?></span></div>
            <div class="content_obj">
                <div>
                    <?php include $__WS_ROOT__ . '/common-php/google/adsense-content-top.html' ?>
                </div>

                <?php require $__ROOT__ . '/include/abap_oname_hier.php' ?>

                <h4> <?php echo GLOBAL_ABAP_ICON::getIcon4Header() ?> Attribute </h4>
                <table class="content_obj">
                    <tbody>
                        <tr><td class="content_label"> Message class </td>
                            <td><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeMSAG() ?></td>
                            <td class="field"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4Msag($ObjID, $t100t, FALSE); ?> </td>
                            <td> &nbsp;</td>
                        </tr>
                        <tr><td class="content_label"> Short Description</td>
                            <td><?php echo GLOBAL_ABAP_ICON::getIcon4Description() ?></td>
                            <td class="field"><?php echo $t100t ?> &nbsp;</td>
                            <td> &nbsp; </td>
                        </tr>
                        <tr><td class="content_label"> Message Number </td>
                            <td> <?php echo GLOBAL_ABAP_ICON::getIcon4OtypeNN() ?></td>
                            <td class="field"><a href="#" title="<?php echo $t100_nr_text ?>"><?php echo $MsgNr ?></a> </td>
                            <td> &nbsp;</td>
                        </tr>
                        <tr><td class="content_label"> Documentation status</td>
                            <td> &nbsp;</td>
                            <td class="field"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4DomainValue(ABAP_DB_TABLE_MSAG::T100U_SELFDEF_DOMAIN, $t100u['SELFDEF'], $t100u_t) ?> &nbsp;</td>
                            <td><?php echo GLOBAL_ABAP_ICON::getIcon4Description() ?> <?php echo $t100u_t ?> </td>
                        </tr>
                        <tr><td class="content_label"> Authorization check Error Message</td>
                            <td> &nbsp;</td>
                            <td> <?php echo ABAP_UI_TOOL::GetCheckBox('AUTH_CHECK', $t100x['AUTH_CHECK']) ?> &nbsp;</td>
                            <td> &nbsp; </td>
                        </tr>
                        <tr><td class="content_label"> Changed On</td>
                            <td><?php echo GLOBAL_ABAP_ICON::getIcon4Date() ?></td>
                            <td class="field"><?php echo $t100u['DATUM'] ?>&nbsp;</td>
                            <td>&nbsp; </td>
                        </tr>
                    </tbody>
                </table>

                <h4> <?php echo GLOBAL_ABAP_ICON::getIcon4DisplayText() ?> Message Text </h4>
                <div class="f1doc"><?php echo $t100_nr_text ?></div>
                <?php if (empty(trim($dok_na)) === FALSE) { ?>
                    <h4> Help Document </h4>
                    <div class="f1doc"><?php echo $dok_na ?></div>
                <?php } ?>

                <h4> <?php echo GLOBAL_ABAP_ICON::getIcon4History() ?>  History </h4>
                <table class="content_obj">
                    <tbody>
                        <tr><td class="content_label"> Last changed on/by      </td>
                            <td><?php echo GLOBAL_ABAP_ICON::getIcon4Date() ?></td>
                            <td class="field"><?php echo $t100a['LDATE'] ?>&nbsp;</td>
                            <td> <?php echo $t100a['LASTUSER'] ?>&nbsp;</td></tr>
                        <tr><td class="content_label"> SAP Release Created in  </td>
                            <td>&nbsp; </td>
                            <td class="field"><?php echo $hier->CRELEASE ?>&nbsp;</td>
                            <td>&nbsp;</td></tr>
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
