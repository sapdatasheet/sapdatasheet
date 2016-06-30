<!DOCTYPE html>
<!-- IMG Activity object. -->
<?php
$__ROOT__ = dirname(dirname(dirname(__FILE__)));
require_once ($__ROOT__ . '/include/common/global.php');
require_once ($__ROOT__ . '/include/common/abap_db.php');
require_once ($__ROOT__ . '/include/common/abap_ui.php');
GLOBAL_UTIL::UpdateSAPDescLangu();

if (!isset($ObjID)) {
    $ObjID = filter_input(INPUT_GET, 'id');
}

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
?>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" href="/abap.css" type="text/css" />
        <title><?php echo $GLOBALS['TITLE_TEXT'] . GLOBAL_WEBSITE_SAPDS::TITLE ?> </title>
        <meta name="keywords" content="SAP,<?php echo GLOBAL_ABAP_OTYPE::MSAG_DESC ?>,<?php echo $ObjID ?>,<?php echo $msag_t ?>" />
        <meta name="description" content="<?php echo GLOBAL_WEBSITE_SAPDS::META_DESC; ?>" />
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
                    <tr><td class="left_value"><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeMSAG() ?>
                            <a href="#" title="<?php echo $msag_t ?>"><?php echo $ObjID ?></a> </td></tr>
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
                <a href="#"><?php echo $ObjID ?></a>
            </div>

            <!-- Content Object -->
            <div class="content_obj_title"><span><?php echo $GLOBALS['TITLE_TEXT'] ?></span></div>
            <div class="content_obj">
                <div>
                    <?php include $__ROOT__ . '/include/google/adsense-content-top.html' ?>
                </div>

                <?php require $__ROOT__ . '/include/abap_oname_hier.php' ?>

                <h4> <?php echo GLOBAL_ABAP_ICON::getIcon4Header() ?> Attributes </h4>
                <table class="content_obj">
                    <tbody>
                        <tr><td class="content_label"> Message class </td>
                            <td><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeMSAG() ?></td>
                            <td class="field"> <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Msag($ObjID, $msag_t, FALSE); ?> </td>
                        </tr>
                        <tr><td class="content_label"> Short Description</td>
                            <td><?php echo GLOBAL_ABAP_ICON::getIcon4Description() ?></td>
                            <td class="field"> <?php echo $msag_t ?> &nbsp;</td>
                        </tr>
                        <tr><td class="content_label"> Changed On</td>
                            <td><?php echo GLOBAL_ABAP_ICON::getIcon4Date() ?></td>
                            <td class="field"><?php echo $msag['LDATE'] ?>&nbsp;</td>
                        </tr>
                        <tr><td class="content_label"> Last Changed At </td>
                            <td><?php echo GLOBAL_ABAP_ICON::getIcon4Time() ?></td>
                            <td class="field"><?php echo $msag['LTIME'] ?>&nbsp;</td>
                        </tr>
                    </tbody>
                </table>

                <h4> <?php echo GLOBAL_ABAP_ICON::getIcon4Folder() ?> Messages </h4>
                <table class="alv">
                    <tr>
                        <th class="alv"> # </th>
                        <th class="alv"> Message </th>
                        <th class="alv"> Message Short Text </th>
                        <th class="alv"> Documentation status </th>
                        <th class="alv"> Authorization check </th>
                    </tr>
                    <?php
                    $count = 0;
                    foreach ($t100_list as $t100) {
                        $count++;
                        $t100u = ABAP_DB_TABLE_MSAG::T100U($ObjID, $t100['MSGNR']);
                        $t100u_t = ABAP_DB_TABLE_DOMA::DD07T(ABAP_DB_TABLE_MSAG::T100U_SELFDEF_DOMAIN, $t100u['SELFDEF']);
                        $t100x = ABAP_DB_TABLE_MSAG::T100X($ObjID, $t100['MSGNR']);
                        ?>
                        <tr><td class="alv" style="text-align: right;"><?php echo number_format($count) ?> </td>
                            <td class="alv"><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeNN() ?>
                                <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Msgnr($ObjID, $t100['MSGNR']) ?></td>
                            <td class="alv"><?php echo htmlentities($t100['TEXT']) ?></td>
                            <td class="alv"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4DomainValue(ABAP_DB_TABLE_MSAG::T100U_SELFDEF_DOMAIN, $t100u_t, $t100u['SELFDEF']) ?></td>
                            <td class="alv"><?php echo ABAP_UI_TOOL::GetCheckBox('AUTH_CHECK', $t100x['AUTH_CHECK'])  ?></td>
                        </tr>
                    <?php } ?>
                </table>

                <h4> <?php echo GLOBAL_ABAP_ICON::getIcon4History() ?> History </h4>
                <table class="content_obj">
                    <tbody>
                        <tr><td class="content_label"> Last changed on/by      </td>
                            <td><?php echo GLOBAL_ABAP_ICON::getIcon4Date() ?></td>
                            <td class="field"><?php echo $msag['LDATE'] ?>&nbsp;</td>
                            <td> <?php echo $msag['LASTUSER'] ?>&nbsp;</td></tr>
                        <tr><td class="content_label"> SAP Release Created in  </td>
                            <td>&nbsp;</td>
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
