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

if (empty($ObjID)) {
    ABAP_UI_TOOL::Redirect404();
}
$imgach = ABAP_DB_TABLE_CUS0::CUS_IMGACH(strtoupper($ObjID));
if (empty($imgach['ACTIVITY'])) {
    ABAP_UI_TOOL::Redirect404();
}

$imgach_t = ABAP_DB_TABLE_CUS0::CUS_IMGACT($imgach['ACTIVITY']);

$hier = ABAP_DB_TABLE_HIER::Hier(ABAP_DB_CONST::TADIR_PGMID_R3TR, ABAP_OTYPE::CUS0_NAME, $imgach['ACTIVITY']);
$GLOBALS['TITLE_TEXT'] = 'SAP ABAP ' . ABAP_OTYPE::CUS0_DESC . ' ' . $imgach['ACTIVITY'];
?>
<html>
    <head>
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" href="/abap.css" type="text/css" />
        <title><?php echo $GLOBALS['TITLE_TEXT'] ?> <?php echo WEBSITE::TITLE ?> </title>
        <meta name="keywords" content="SAP,<?php echo ABAP_OTYPE::CUS0_DESC ?>,<?php echo $imgach['ACTIVITY'] ?>,<?php echo $imgach_t ?>" />
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
                    <tr><td class="left_value"><a href="/abap/cus0/"><?php echo ABAP_OTYPE::CUS0_DESC ?></a></td></tr>
                    <tr><td class="left_attribute"> Object name </td></tr>
                    <tr><td class="left_value"> <a href="#" title="<?php echo $imgach_t ?>"><?php echo $imgach['ACTIVITY'] ?></a> </td></tr>
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
                <a href="/abap/cus0/"><?php echo ABAP_OTYPE::CUS0_DESC ?></a> &gt;
                <a href="#"><?php echo $imgach['ACTIVITY'] ?></a>
            </div>

            <!-- Content Object -->
            <div class="content_obj_title"><span><?php echo $GLOBALS['TITLE_TEXT'] ?></span></div>
            <div class="content_obj">
                <div>
                    <?php include $__ROOT__ . '/include/google/adsense-content-top.html' ?>
                </div>

                <h4> IMG Activity </h4>
                <table class="content_obj">
                    <tbody>
                        <tr><td class="content_label"> ID </td>
                            <td class="field"> <?php echo ABAP_Navigation::GetURLSproIMGActivity($imgach['ACTIVITY'], $imgach_t, FALSE); ?> </td>
                            <td> <?php echo htmlentities($imgach_t) ?> &nbsp;</td>
                        </tr>
                        <tr><td class="content_label"> Transaction Code </td>
                            <td class="field"> <?php echo ABAP_Navigation::GetURLTransactionCode($imgach['TCODE'], null) ?> &nbsp;</td>
                            <td> <?php echo ABAP_DB_TABLE_TRAN::TSTCT($imgach['TCODE']) ?>&nbsp; </td>
                        </tr>
                        <tr><td class="content_label"> Created on </td>
                            <td class="field"> <?php echo $imgach['FDATE'] ?> &nbsp;</td>
                            <td> &nbsp;</td>
                        </tr>
                        <tr><td class="content_label"> Document Class </td>
                            <td class="field"> SIMG &nbsp;</td>
                            <td> Hypertext: Object Class - Class to which a document belongs.</td>
                        </tr>
                        <tr><td class="content_label"> Document Name </td>
                            <td class="field"> <?php echo $imgach['DOCU_ID'] ?> &nbsp;</td>
                            <td> &nbsp;</td>
                        </tr>
                    </tbody>
                </table>

                <h4> Hierarchy </h4>
                <table class="content_obj">
                    <tbody>
                        <tr><td class="content_label"> Last changed by/on      </td><td class="field"><?php echo $imgach['LUSER'] ?>&nbsp;</td><td> <?php echo $imgach['LDATE'] ?>&nbsp;</td></tr>
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
