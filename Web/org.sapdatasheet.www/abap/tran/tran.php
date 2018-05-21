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
$tstc = ABAP_DB_TABLE_TRAN::TSTC(strtoupper($ObjID));
if (empty($tstc['TCODE'])) {
    ABAP_UI_TOOL::Redirect404();
}
$tstc_cinfo_desc = ABAP_UI_TOOL::GetTCodeTypeDesc($tstc['CINFO']);
$tstc_pgmna_desc = ABAP_DB_TABLE_PROG::TRDIRT($tstc['PGMNA']);
$tstc_desc = htmlentities(ABAP_DB_TABLE_TRAN::TSTCT($tstc['TCODE']));
$tstca_list = ABAP_DB_TABLE_TRAN::TSTCA_List($tstc['TCODE']);
$tstcc = ABAP_DB_TABLE_TRAN::TSTCC($tstc['TCODE']);
$tstcp = ABAP_DB_TABLE_TRAN::TSTCP($tstc['TCODE']);

$wul_counter_list = ABAPANA_DB_TABLE::WULCOUNTER_List(GLOBAL_ABAP_OTYPE::TRAN_NAME, $tstc['TCODE']);
$wil_enabled = TRUE;
$wil_counter_list = ABAPANA_DB_TABLE::WILCOUNTER_List(GLOBAL_ABAP_OTYPE::TRAN_NAME, $tstc['TCODE']);

$hier = ABAP_DB_TABLE_HIER::Hier(ABAP_DB_TABLE_HIER::TADIR_PGMID_R3TR, GLOBAL_ABAP_OTYPE::TRAN_NAME, $tstc['TCODE']);
$GLOBALS['TITLE_TEXT'] = ABAP_UI_TOOL::GetObjectTitle(GLOBAL_ABAP_OTYPE::TRAN_NAME, $tstc['TCODE']);

$json_ld = new \OrgSchema\Thing();
$json_ld->name = $tstc['TCODE'];
$json_ld->alternateName = $tstc_desc;
$json_ld->description = $GLOBALS['TITLE_TEXT'];
$json_ld->image = GLOBAL_ABAP_ICON::getIconURL(GLOBAL_ABAP_ICON::OTYPE_TRAN, TRUE);
$json_ld->url = ABAP_UI_DS_Navigation::GetObjectURL(GLOBAL_ABAP_OTYPE::TRAN_NAME, $json_ld->name);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" href="/abap.css" type="text/css" />
        <title><?php echo $GLOBALS['TITLE_TEXT'] . GLOBAL_WEBSITE_SAPDS::TITLE ?> </title>
        <meta name="keywords" content="SAP,<?php echo GLOBAL_ABAP_OTYPE::TRAN_DESC ?>,<?php echo $tstc['TCODE']; ?>,<?php echo $tstc_desc ?>" />
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
                    <tr><td class="left_attribute"> Application Component</td></tr>
                    <tr><td class="left_value"><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeBMFR() ?>
                            <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Bmfr($hier->FCTR_ID, $hier->POSID, $hier->POSID_T) ?>&nbsp;</td></tr>
                    <tr><td class="left_attribute"> Package </td></tr>
                    <tr><td class="left_value"><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeDEVC() ?>
                            <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Devc($hier->DEVCLASS, $hier->DEVCLASS_T) ?></td></tr>
                    <tr><td class="left_attribute"> Object type </td></tr>
                    <tr><td class="left_value"><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeTRAN() ?>
                            <a href="/abap/tran/"><?php echo GLOBAL_ABAP_OTYPE::TRAN_DESC ?></a></td></tr>
                    <tr><td class="left_attribute"> Object name </td></tr>
                    <tr><td class="left_value"><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeTRAN() ?>
                            <a href="#" title="<?php echo $tstc_desc ?>"><?php echo $tstc['TCODE'] ?></a> </td></tr>
                </tbody>
            </table>

            <h5>Analytics</h5>
            <table class="content_obj">
                <tbody>
                    <tr><td class="left_value">
                            <?php echo GLOBAL_ABAP_ICON::getIcon4Analytics() ?>
                            <?php echo ABAP_UI_TCODES_Navigation::TCodeHyperlink($tstc['TCODE'], TRUE) ?> Analytics
                        </td></tr>
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
                <a href="/abap/tran/"><?php echo GLOBAL_ABAP_OTYPE::TRAN_DESC ?></a> &gt;
                <a href="#"><?php echo $tstc['TCODE'] ?></a>
            </div>

            <!-- Content Object -->
            <div class="content_obj_title"><span><?php echo $GLOBALS['TITLE_TEXT'] ?></span></div>
            <div class="content_obj">
                <div>
                    <?php include $__WS_ROOT__ . '/common-php/google/adsense-content-top.html' ?>
                </div>

                <?php require $__ROOT__ . '/include/abap_oname_hier.php' ?>

                <h4> <?php echo GLOBAL_ABAP_ICON::getIcon4Header() ?> Basic Data </h4>
                <table class="content_obj">
                    <tbody>
                        <tr><td class="content_label"> Transaction Code        </td>
                            <td><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeTRAN() ?> </td>
                            <td class="field"> <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Tran($tstc['TCODE'], $tstc_desc) ?> </td>
                            <td><?php echo GLOBAL_ABAP_ICON::getIcon4Analytics() ?> <a href="<?php echo ABAP_UI_TCODES_Navigation::TCode($tstc['TCODE'], TRUE) ?>" title="<?php echo $tstc_desc ?>" target="_blank">TCode <?php echo $tstc['TCODE'] ?> Analytics</a> <sup>&nearhk;</sup></td></tr>
                        <tr><td class="content_label"> Transaction Description </td>
                            <td><?php echo GLOBAL_ABAP_ICON::getIcon4Description() ?> </td>
                            <td class="field"> <?php echo $tstc_desc ?> &nbsp;</td>
                            <td>&nbsp;</td></tr>
                        <tr><td class="content_label"> Transaction Type        </td>
                            <td>&nbsp;</td>
                            <td class="field"> <?php echo $tstc['CINFO'] ?> </td>
                            <td><?php echo $tstc_cinfo_desc ?></td></tr>
                    </tbody>
                </table>

                <!-- Attributes - Screen Specific -->
                <h4> <?php echo GLOBAL_ABAP_ICON::getIcon4Header() ?> Attribute </h4>
                <table class="content_obj">
                    <tbody>
                        <tr><td class="content_label"> Program       </td>
                            <td><?php echo GLOBAL_ABAP_ICON::getIcon4OtypePROG() ?> </td>
                            <td class="field"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4Prog($tstc['PGMNA'], $tstc_pgmna_desc) ?>&nbsp; </td>
                            <td><?php echo htmlentities($tstc_pgmna_desc) ?></td></tr>
                        <tr><td class="content_label"> Screen number </td>
                            <td>&nbsp;</td>
                            <td class="field"><?php echo $tstc['DYPNO'] ?>&nbsp;</td>
                            <td>&nbsp;</td></tr>
                    </tbody>
                </table>

                <?php if (count($tstca_list) > 0) { ?>
                    <h4><?php echo GLOBAL_ABAP_ICON::getIcon4OtypePFCG() ?> Authorization</h4>
                    <table class="alv">
                        <tbody>
                            <tr><th class="alv">Authorization Object</th><th class="alv">Authorization Field</th><th class="alv">Value</th></tr>
                            <?php foreach ($tstca_list as $tstca_item) { ?>
                                <tr><td class="alv"><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeSU21() ?> 
                                        <?php echo $tstca_item['OBJCT'] ?>&nbsp;</td>
                                    <td class="alv"><?php echo $tstca_item['FIELD'] ?></td>
                                    <td class="alv"><?php echo $tstca_item['VALUE'] ?>&nbsp;</td></tr>
                            <?php } ?>
                            <tr><td class="alv">&nbsp;</td><td class="alv">&nbsp;</td><td class="alv">&nbsp;</td></tr>
                        </tbody>
                    </table>
                <?php } ?>

                <h4> <?php echo GLOBAL_ABAP_ICON::getIcon4Parameter() ?> Parameter</h4>
                <table class="content_obj">
                    <tbody>
                        <tr><td class="content_label"> Transaction Code Parameter </td>
                            <td class="field"> <?php
                                $param = $tstcp['PARAM'];
                                if (!empty($param)) {
                                    $param_s1 = explode(' ', $param);
                                    foreach ($param_s1 as $param_s1_value) {
                                        $param_s2 = explode(';', $param_s1_value);
                                        foreach ($param_s2 as $param_s2_value) {
                                            echo $param_s2_value;
                                            echo '<br />';
                                        }
                                    }
                                }
                                ?>
                            </td></tr>
                    </tbody>
                </table>

                <h4><?php echo GLOBAL_ABAP_ICON::getIcon4Sapgui() ?> GUI Support</h4>
                <table class="content_obj">
                    <tbody>
                        <tr><td><?php echo ABAP_UI_TOOL::GetCheckBox("cb_sapgui_web", $tstcc['S_WEBGUI']) ?> SAPGUI for HTML</td></tr>
                        <tr><td><?php echo ABAP_UI_TOOL::GetCheckBox("cb_sapgui_java", $tstcc['S_PLATIN']) ?> SAPGUI for Java</td></tr>
                        <tr><td><?php echo ABAP_UI_TOOL::GetCheckBox("cb_sapgui_win", $tstcc['S_WIN32']) ?> SAPGUI for Windows</td></tr>
                    </tbody>
                </table>

                <h4> <?php echo GLOBAL_ABAP_ICON::getIcon4History() ?> History </h4>
                <table class="content_obj">
                    <tbody>
                        <tr><td class="content_label"> SAP Release Created in  </td><td class="field"><?php echo $hier->CRELEASE ?>&nbsp;</td><td>&nbsp;</td></tr>
                    </tbody>
                </table>

            </div>
        </div><!-- Content: End -->

        <!-- Footer -->
        <?php require $__ROOT__ . '/include/footer.php' ?>

    </body>
</html>
<?php
// Close PDO Database Connection
ABAP_DB_TABLE::close_conn();
