<!DOCTYPE html>
<?php
$__ROOT__ = dirname(dirname(dirname(__FILE__)));
require_once ($__ROOT__ . '/include/global.php');
require_once ($__ROOT__ . '/include/abap_db.php');
require_once ($__ROOT__ . '/include/abap_ui.php');

if (!isset($ObjID)) {
    $ObjID = filter_input(INPUT_GET, 'id');
}

if (empty($ObjID)) {
    ABAP_UI_TOOL::Redirect404();
}
$tstc = ABAP_DB_TABLE_TRAN::TSTC(strtoupper($ObjID));
if (empty($tstc['TCODE'])) {
    ABAP_UI_TOOL::Redirect404();
}
$tstc_cinfo_desc = ABAP_UI_TOOL::GetTCodeTypeDesc($tstc['CINFO']);
$tstc_pgmna_desc = ABAP_DB_TABLE_PROG::TRDIRT($tstc['PGMNA']);
$tstc_desc = ABAP_DB_TABLE_TRAN::TSTCT($tstc['TCODE']);
$tstca_list = ABAP_DB_TABLE_TRAN::TSTCA_List($tstc['TCODE']);
$tstcc = ABAP_DB_TABLE_TRAN::TSTCC($tstc['TCODE']);
$tstcp = ABAP_DB_TABLE_TRAN::TSTCP($tstc['TCODE']);
$hier = ABAP_DB_TABLE_HIER::Hier(ABAP_DB_CONST::TADIR_PGMID_R3TR, ABAP_OTYPE::TRAN_NAME, $tstc['TCODE']);
$GLOBALS['TITLE_TEXT'] = 'SAP ABAP ' . ABAP_OTYPE::TRAN_DESC . ' ' . $tstc['TCODE'];
?>

<html>
    <head>
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" href="/abap.css" type="text/css" />
        <title><?php echo $GLOBALS['TITLE_TEXT'] ?> <?php echo WEBSITE::TITLE ?> </title>
        <meta name="keywords" content="SAP,<?php echo ABAP_OTYPE::TRAN_DESC ?>,<?php echo $tstc['TCODE']; ?>,<?php echo $tstc_desc ?>" />
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
                    <tr><td class="left_value"><?php echo ABAP_Navigation::GetURLSoftComp($hier->DLVUNIT, $hier->DLVUNIT_T) ?>&nbsp;</td></tr>
                    <tr><td class="left_attribute"> Application Component ID</td></tr>
                    <tr><td class="left_value"><?php echo ABAP_Navigation::GetURLAppComp($hier->FCTR_ID, $hier->POSID, $hier->POSID_T) ?>&nbsp;</td></tr>
                    <tr><td class="left_attribute"> Package </td></tr>
                    <tr><td class="left_value"><?php echo ABAP_Navigation::GetURLPackage($hier->DEVCLASS, $hier->DEVCLASS_T) ?></td></tr>
                    <tr><td class="left_attribute"> Object type </td></tr>
                    <tr><td class="left_value"><a href="/abap/tran/"><?php echo ABAP_OTYPE::TRAN_DESC ?></a></td></tr>
                    <tr><td class="left_attribute"> Object name </td></tr>
                    <tr><td class="left_value"> <a href="#" title="<?php echo $tstc_desc ?>"><?php echo $tstc['TCODE'] ?></a> </td></tr>
                </tbody>
            </table>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Content Navigator -->
            <div class="content_navi">
                <a href="/">Home page</a> &gt; 
                <a href="/abap/">ABAP Object</a> &gt; 
                <a href="/abap/tran/"><?php echo ABAP_OTYPE::TRAN_DESC ?></a> &gt; 
                <a href="#"><?php echo $tstc['TCODE'] ?></a>
            </div>

            <!-- Content Object -->
            <div class="content_obj_title"><span><?php echo $GLOBALS['TITLE_TEXT'] ?></span></div>
            <div class="content_obj">
                <h4> Basic Data </h4>
                <table class="content_obj">
                    <tbody>
                        <tr><td class="content_label"> Transaction Code        </td><td class="field"> <?php echo ABAP_Navigation::GetURLTransactionCode($tstc['TCODE'], $tstc_desc) ?> </td><td>&nbsp;</td></tr>
                        <tr><td class="content_label"> Transaction Description </td><td class="field"> <?php echo htmlentities($tstc_desc) ?> &nbsp;</td><td>&nbsp;</td></tr>
                        <tr><td class="content_label"> Transaction Type        </td><td class="field"> <?php echo $tstc['CINFO'] ?> </td><td><?php echo $tstc_cinfo_desc ?></td></tr>
                    </tbody>
                </table>

                <!-- Attributes - Screen Specific -->
                <h4> Attribute </h4>
                <table class="content_obj">
                    <tbody>
                        <tr><td class="content_label"> Program       </td>
                            <td class="field"><?php echo ABAP_Navigation::GetURLProgram($tstc['PGMNA'], $tstc_pgmna_desc) ?>&nbsp; </td>
                            <td><?php echo htmlentities($tstc_pgmna_desc) ?></td></tr>
                        <tr><td class="content_label"> Screen number </td>
                            <td class="field"><?php echo $tstc['DYPNO'] ?>&nbsp;</td>
                            <td>&nbsp;</td></tr>
                    </tbody>
                </table>

                <?php if ($tstca_list !== FALSE) { ?>
                    <h4>Authorization</h4>
                    <table class="alv">
                        <tbody>
                            <tr><th class="alv">Authorization Object</th><th class="alv">Authorization Field</th><th class="alv">Value</th></tr>
                            <?php while ($tstca_item = mysqli_fetch_array($tstca_list)) { ?>
                                <tr><td class="alv"><?php echo $tstca_item['OBJECT'] ?>&nbsp;</td>
                                    <td class="alv"><?php echo $tstca_item['FIELD'] ?></td>
                                    <td class="alv"><?php echo $tstca_item['VALUE'] ?>&nbsp;</td></tr>
                            <?php } ?>
                            <tr><td class="alv">&nbsp;</td><td class="alv">&nbsp;</td><td class="alv">&nbsp;</td></tr>
                        </tbody>
                    </table>
                <?php } ?>

                <h4>Parameter</h4>
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

                <h4>GUI Support</h4>
                <table class="content_obj">
                    <tbody>
                        <tr><td><?php echo ABAP_UI_TOOL::GetCheckBox("cb_sapgui_web", $tstcc['S_WEBGUI']) ?> SAPGUI for HTML</td></tr>
                        <tr><td><?php echo ABAP_UI_TOOL::GetCheckBox("cb_sapgui_java", $tstcc['S_PLATIN']) ?> SAPGUI for Java</td></tr>
                        <tr><td><?php echo ABAP_UI_TOOL::GetCheckBox("cb_sapgui_win", $tstcc['S_WIN32']) ?> SAPGUI for Windows</td></tr>
                    </tbody>
                </table>

                <h4> Hierarchy </h4>
                <table class="content_obj">
                    <tbody>
                        <tr><td class="content_label"> Software Component      </td><td class="field"><?php echo ABAP_Navigation::GetURLSoftComp($hier->DLVUNIT, $hier->DLVUNIT_T) ?>&nbsp;</td><td> <?php echo $hier->DLVUNIT_T ?>&nbsp;</td></tr>
                        <tr><td class="content_label"> SAP Release Created in  </td><td class="field"><?php echo $hier->CRELEASE ?>&nbsp;</td><td>&nbsp;</td></tr>
                        <tr><td class="content_label"> Application Component   </td><td class="field"><?php echo ABAP_Navigation::GetURLAppComp($hier->FCTR_ID, $hier->POSID, $hier->POSID_T) ?>&nbsp;(<?php echo $hier->FCTR_ID ?>)</td><td> <?php echo $hier->POSID_T ?>&nbsp;</td></tr>
                        <tr><td class="content_label"> Package                 </td><td class="field"><?php echo ABAP_Navigation::GetURLPackage($hier->DEVCLASS, $hier->DEVCLASS_T) ?>&nbsp;</td><td> <?php echo $hier->DEVCLASS_T ?>&nbsp;</td></tr>
                    </tbody>
                </table>

            </div>
        </div><!-- Content: End -->

        <!-- Footer -->
        <?php include $__ROOT__ . '/include/footer.html' ?>

    </body>
</html>
