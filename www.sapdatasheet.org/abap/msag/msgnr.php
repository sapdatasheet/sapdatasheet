<!DOCTYPE html>
<!-- IMG Activity object. -->
<?php
$__ROOT__ = dirname(dirname(dirname(__FILE__)));
require_once ($__ROOT__ . '/include/global.php');
require_once ($__ROOT__ . '/include/abap_db.php');
require_once ($__ROOT__ . '/include/abap_ui.php');
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
$t100_nr = ABAP_DB_TABLE_MSAG::T100_NR($ObjID, $MsgNr);
if (empty($t100_nr) === TRUE) {
    $t100_nr = ABAP_DB_TABLE_MSAG::T100_NR($ObjID, $MsgNr, ABAP_DB_CONST::LANGU_EN);
}
if (empty($t100_nr) === TRUE) {
    $t100_nr = ABAP_DB_TABLE_MSAG::T100_NR($ObjID, $MsgNr, ABAP_DB_CONST::LANGU_DE);
}

$t100u = ABAP_DB_TABLE_MSAG::T100U($ObjID, $MsgNr);
$t100u_t = ABAP_DB_TABLE_DOMA::DD07T(ABAP_DB_TABLE_MSAG::T100U_SELFDEF_DOMAIN, $t100u['SELFDEF']);
$t100x = ABAP_DB_TABLE_MSAG::T100X($ObjID, $MsgNr);

$dok_na = ABAP_DB_TABLE_MSAG::YDOK_NA($ObjID, $MsgNr);
if (empty($dok_na) === TRUE) {
    $dok_na = ABAP_DB_TABLE_MSAG::YDOK_NA($ObjID, $MsgNr, ABAP_DB_CONST::LANGU_EN);
}
if (empty($dok_na) === TRUE) {
    $dok_na = ABAP_DB_TABLE_MSAG::YDOK_NA($ObjID, $MsgNr, ABAP_DB_CONST::LANGU_DE);
}


$hier = ABAP_DB_TABLE_HIER::Hier(ABAP_DB_TABLE_HIER::TADIR_PGMID_R3TR, ABAP_OTYPE::MSAG_NAME, $ObjID);
$GLOBALS['TITLE_TEXT'] = $t100_nr['TEXT'] . ' - ' . 'SAP ABAP ' . ABAP_OTYPE::MSAG_DESC . ' ' . $ObjID . ' Message Number ' . $MsgNr;
?>
<html>
    <head>
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" href="/abap.css" type="text/css" />
        <title><?php echo $GLOBALS['TITLE_TEXT'] ?><?php echo WEBSITE::TITLE ?> </title>
        <meta name="keywords" content="SAP,<?php echo ABAP_OTYPE::MSAG_DESC ?>,<?php echo $ObjID ?>,<?php echo $MsgNr ?>,<?php echo $t100t ?>,<?php echo $t100_nr['TEXT'] ?>" />
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
                    <tr><td class="left_value"><a href="/abap/msag/"><?php echo ABAP_OTYPE::MSAG_DESC ?></a></td></tr>
                    <tr><td class="left_attribute"> Object name </td></tr>
                    <tr><td class="left_value"> <a href="#" title="<?php echo $t100_nr['TEXT'] ?>"><?php echo $ObjID . '-' . $MsgNr ?></a> </td></tr>
                </tbody>
            </table>

            <!-- Google Adsense: left -->
            <h5>&nbsp;</h5>
            <div>
                <?php include $__ROOT__ . '/include/google/adsense-left.html' ?>
            </div>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Content Navigator -->
            <div class="content_navi">
                <a href="/">Home page</a> &gt;
                <a href="/abap/">ABAP Object</a> &gt;
                <a href="/abap/msag/"><?php echo ABAP_OTYPE::MSAG_DESC ?></a> &gt;
                <a href="/abap/msag/<?php echo $ObjID ?>.html"><?php echo $ObjID ?></a> &gt;
                <a href="#"><?php echo $ObjID . '-' . $MsgNr ?></a>
            </div>

            <!-- Content Object -->
            <div class="content_obj_title"><span><?php echo $GLOBALS['TITLE_TEXT'] ?></span></div>
            <div class="content_obj">
                <div>
                    <?php include $__ROOT__ . '/include/google/adsense-content-top.html' ?>
                </div>

                <h4> Attribute </h4>
                <table class="content_obj">
                    <tbody>
                        <tr><td class="content_label"> Message class </td>
                            <td class="field"> <?php echo ABAP_Navigation::GetURLMessageClass($ObjID, $t100t, FALSE); ?> </td>
                            <td> &nbsp;</td>
                        </tr>
                        <tr><td class="content_label"> Short Description</td>
                            <td class="field"> <?php echo $t100t ?> &nbsp;</td>
                            <td> &nbsp; </td>
                        </tr>
                        <tr><td class="content_label"> Message Number </td>
                            <td class="field"> <a href="#" title="<?php echo $t100_nr['TEXT'] ?>"><?php echo $MsgNr ?></a> </td>
                            <td> &nbsp;</td>
                        </tr>
                        <tr><td class="content_label"> Documentation status</td>
                            <td class="field"> <?php echo ABAP_Navigation::GetURLDomainValue(ABAP_DB_TABLE_MSAG::T100U_SELFDEF_DOMAIN, $t100u['SELFDEF'], $t100u_t) ?> &nbsp;</td>
                            <td> <?php echo $t100u_t ?> </td>
                        </tr>
                        <tr><td class="content_label"> Authorization check Error Message</td>
                            <td> <?php echo ABAP_UI_TOOL::GetCheckBox('AUTH_CHECK', $t100x['AUTH_CHECK']) ?> &nbsp;</td>
                            <td> &nbsp; </td>
                        </tr>
                        <tr><td class="content_label"> Changed On</td>
                            <td class="field"><?php echo $t100u['DATUM'] ?>&nbsp;</td>
                            <td>&nbsp; </td>
                        </tr>
                    </tbody>
                </table>

                <h4> Message Text </h4>
                <div class="f1doc"><?php echo $t100_nr['TEXT'] ?></div>
                <?php if (empty($dok_na) === FALSE) { ?>
                    <h4> Help Document </h4>
                    <div class="f1doc"><?php echo $dok_na ?></div>
                <?php } ?>

                <h4> Hierarchy </h4>
                <table class="content_obj">
                    <tbody>
                        <tr><td class="content_label"> Last changed by/on      </td><td class="field"><?php echo $t100a['LASTUSER'] ?>&nbsp;</td><td> <?php echo $t100a['LDATE'] ?>&nbsp;</td></tr>
                        <tr><td class="content_label"> Software Component      </td><td class="field"><?php echo ABAP_Navigation::GetURLSoftComp($hier->DLVUNIT, $hier->DLVUNIT_T) ?>&nbsp;</td><td> <?php echo $hier->DLVUNIT_T ?>&nbsp;</td></tr>
                        <tr><td class="content_label"> SAP Release Created in  </td><td class="field"><?php echo $hier->CRELEASE ?>&nbsp;</td><td>&nbsp;</td></tr>
                        <tr><td class="content_label"> Application Component   </td><td class="field"><?php echo ABAP_Navigation::GetURLAppComp($hier->FCTR_ID, $hier->POSID, $hier->POSID_T) ?>&nbsp;(<?php echo $hier->FCTR_ID ?>)</td><td> <?php echo $hier->POSID_T ?>&nbsp;</td></tr>
                        <tr><td class="content_label"> Package                 </td><td class="field"><?php echo ABAP_Navigation::GetURLPackage($hier->DEVCLASS, $hier->DEVCLASS_T) ?>&nbsp;</td><td> <?php echo $hier->DEVCLASS_T ?>&nbsp;</td></tr>
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
?>
<?php ?>
