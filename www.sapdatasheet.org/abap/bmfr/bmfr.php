<!DOCTYPE html>
<!-- Application component object. -->
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
$df14l = ABAP_DB_TABLE_HIER::DF14L(strtoupper($ObjID));
if (empty($df14l['FCTR_ID'])) {
    ABAP_UI_TOOL::Redirect404();
}

$GLOBALS['TITLE_TEXT'] = 'SAP ABAP ' . ABAP_OTYPE::BMFR_DESC . ' ' . $df14l['PS_POSID'] . ' (' . $df14l['FCTR_ID'] . ')';
$df14l_desc = ABAP_DB_TABLE_HIER::DF14T($ObjID);
$hier = ABAP_DB_TABLE_HIER::Hier(ABAP_DB_CONST::TADIR_PGMID_R3TR, ABAP_OTYPE::BMFR_NAME, $df14l['FCTR_ID']);
$child_bmfr = ABAP_DB_TABLE_HIER::DF14L_Child($df14l['PS_POSID'], $df14l['FCTR_ID']);
$child_tdevc = ABAP_DB_TABLE_HIER::TDEVC_DEVCLASS($df14l['FCTR_ID']);
?>
<html>
    <head>
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" href="/abap.css" type="text/css" />
        <title><?php echo $GLOBALS['TITLE_TEXT'] ?> <?php echo WEBSITE::TITLE ?> </title>
        <meta name="keywords" content="SAP,<?php echo ABAP_OTYPE::BMFR_DESC ?>,<?php echo $df14l['FCTR_ID'] ?>,<?php echo $df14l['PS_POSID'] ?>,<?php echo $df14l_desc ?>" />
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
                </tbody>
            </table>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Content Navigator -->
            <div class="content_navi">
                <a href="/">Home page</a> &gt;
                <a href="/abap/">ABAP Object</a> &gt;
                <a href="/abap/bmfr/">ABAP <?php echo ABAP_OTYPE::BMFR_DESC ?></a> &gt;
                <a href="#"><?php echo $df14l['PS_POSID'] ?></a>
            </div>

            <!-- Content Object -->
            <div class="content_obj_title"><span><?php echo $GLOBALS['TITLE_TEXT'] ?></span></div>
            <div class="content_obj">
                <h4> Basic Data </h4>
                <table class="content_obj">
                    <tbody>
                        <tr><td class="content_label"> Application Component    </td><td class="field"><?php echo $df14l['FCTR_ID'] ?> &nbsp;</td></tr>
                        <tr><td class="content_label"> Application Component ID </td><td class="field"><?php echo $df14l['PS_POSID'] ?> &nbsp;</td></tr>
                        <tr><td class="content_label"> Short Description        </td><td class="field"><?php echo $df14l_desc ?> &nbsp;</td></tr>
                        <tr><td class="content_label"> First Release Date       </td><td class="field"><?php echo $df14l['FSTDATE'] ?>&nbsp;</td></tr>
                        <tr><td class="content_label"> First Release            </td><td class="field"><?php echo $df14l['RELE'] ?>&nbsp;</td></tr>
                    </tbody>
                </table><!-- Basic Data: End -->

                <!-- Application Component Content -->
                <?php if (!empty($child_bmfr) || !empty($child_tdevc)) { ?>
                    <h4> Content </h4>
                    <!-- Contained Application Component -->
                    <?php if (!empty($child_bmfr)) { ?>
                        <table class="alv">
                            <caption>Contained Application Component</caption>
                            <tr>
                                <th class="alv"> Application Component ID</th>
                                <th class="alv"> Short Description </th>
                                <th class="alv"> Application Component</th></tr>
                            <?php
                            while ($child_bmfr_item = mysqli_fetch_array($child_bmfr)) {
                                $child_bmfr_item_desc = ABAP_DB_TABLE_HIER::DF14T($child_bmfr_item['FCTR_ID'])
                                ?>
                                <tr><td class="alv"><?php echo ABAP_Navigation::GetURLAppComp($child_bmfr_item['FCTR_ID'], $child_bmfr_item['PS_POSID'], $child_bmfr_item_desc) ?></td>
                                    <td class="alv"><?php echo htmlentities($child_bmfr_item_desc) ?>&nbsp;</td>
                                    <td class="alv"><?php echo $child_bmfr_item['FCTR_ID'] ?>&nbsp;</td>
                                </tr>
                            <?php } ?>
                        </table>
                    <?php } ?><!-- Contained Application Component: End -->

                    <!-- Contained Packages -->
                    <?php if (!empty($child_tdevc)) { ?>
                        <table class="alv">
                            <caption>Contained Package</caption>
                            <tr>
                                <th class="alv"> Package </th>
                                <th class="alv"> Short Description </th></tr>
                            <?php
                            while ($child_tdevc_item = mysqli_fetch_array($child_tdevc)) {
                                $child_tdevc_item_desc = ABAP_DB_TABLE_HIER::TDEVCT($child_tdevc_item['DEVCLASS']);
                                ?>
                                <tr><td class="alv"><?php echo ABAP_Navigation::GetURLPackage($child_tdevc_item['DEVCLASS'], $child_tdevc_item_desc) ?></td>
                                    <td class="alv"><?php echo htmlentities($child_tdevc_item_desc) ?>&nbsp;</td></tr>
                            <?php } ?>
                        </table>
                    <?php } ?><!-- Contained Packages: End -->

                <?php } ?><!-- Application Component Content: End -->

                <h4> Hierarchy </h4>
                <table class="content_obj">
                    <tbody>
                        <tr><td class="content_label"> Software Component      </td><td class="field"><?php echo ABAP_Navigation::GetURLSoftComp($hier->DLVUNIT, $hier->DLVUNIT_T) ?>&nbsp;</td><td> <?php echo $hier->DLVUNIT_T ?>&nbsp;</td></tr>
                        <tr><td class="content_label"> SAP Release Created in  </td><td class="field"><?php echo $hier->CRELEASE ?>&nbsp;</td><td>&nbsp;</td></tr>
                    </tbody>
                </table><!-- Hierarchy: End -->

            </div>
        </div><!-- Content: End -->

        <!-- Footer -->
        <?php include $__ROOT__ . '/include/footer.html' ?>

    </body>
</html>