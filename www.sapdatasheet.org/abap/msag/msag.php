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
$ObjID = strtoupper($ObjID);
$msag = ABAP_DB_TABLE_MSAG::T100A(strtoupper($ObjID));
if (empty($msag['ARBGB'])) {
    ABAP_UI_TOOL::Redirect404();
}

$msag_t = ABAP_DB_TABLE_MSAG::T100T($ObjID);
$t100_list = ABAP_DB_TABLE_MSAG::T100($ObjID);

$hier = ABAP_DB_TABLE_HIER::Hier(ABAP_DB_TABLE_HIER::TADIR_PGMID_R3TR, ABAP_OTYPE::MSAG_NAME, $ObjID);
$GLOBALS['TITLE_TEXT'] = 'SAP ABAP ' . ABAP_OTYPE::MSAG_DESC . ' ' . $ObjID . ' - ' . $msag_t;
?>
<html>
    <head>
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" href="/abap.css" type="text/css" />
        <title><?php echo $GLOBALS['TITLE_TEXT'] ?><?php echo WEBSITE::TITLE ?> </title>
        <meta name="keywords" content="SAP,<?php echo ABAP_OTYPE::MSAG_DESC ?>,<?php echo $ObjID ?>,<?php echo $msag_t ?>" />
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
                    <tr><td class="left_value"> <a href="#" title="<?php echo $msag_t ?>"><?php echo $ObjID ?></a> </td></tr>
                </tbody>
            </table>

            <h5>&nbsp;</h5>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Content Navigator -->
            <div class="content_navi">
                <a href="/">Home page</a> &gt;
                <a href="/abap/">ABAP Object</a> &gt;
                <a href="/abap/msag/"><?php echo ABAP_OTYPE::MSAG_DESC ?></a> &gt;
                <a href="#"><?php echo $ObjID ?></a>
            </div>

            <!-- Content Object -->
            <div class="content_obj_title"><span><?php echo $GLOBALS['TITLE_TEXT'] ?></span></div>
            <div class="content_obj">
                <div>
                    <?php include $__ROOT__ . '/include/google/adsense-content-top.html' ?>
                </div>

                <h4> Attributes </h4>
                <table class="content_obj">
                    <tbody>
                        <tr><td class="content_label"> Message class </td>
                            <td class="field"> <?php echo ABAP_Navigation::GetURLMessageClass($ObjID, $msag_t, FALSE); ?> </td>
                            <td> &nbsp;</td>
                        </tr>
                        <tr><td class="content_label"> Short Description</td>
                            <td class="field"> <?php echo $msag_t ?> &nbsp;</td>
                            <td> &nbsp; </td>
                        </tr>
                        <tr><td class="content_label"> Changed On</td>
                            <td class="field"><?php echo $msag['LDATE'] ?>&nbsp;</td>
                            <td>&nbsp; </td>
                        </tr>
                        <tr><td class="content_label"> Last Changed At </td>
                            <td class="field"><?php echo $msag['LTIME'] ?>&nbsp;</td>
                            <td>&nbsp; </td>
                        </tr>
                    </tbody>
                </table>

                <h4> Messages </h4>
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
                            <td class="alv"><?php echo ABAP_Navigation::GetURLMessageNumber($ObjID, $t100['MSGNR']) ?></td>
                            <td class="alv"><?php echo htmlentities($t100['TEXT']) ?></td>
                            <td class="alv"><?php echo ABAP_Navigation::GetURLDomainValue(ABAP_DB_TABLE_MSAG::T100U_SELFDEF_DOMAIN, $t100u_t, $t100u['SELFDEF']) ?></td>
                            <td class="alv"><?php echo ABAP_UI_TOOL::GetCheckBox('AUTH_CHECK', $t100x['AUTH_CHECK'])  ?></td>
                        </tr>
                    <?php } ?>
                </table>

                <h4> Hierarchy </h4>
                <table class="content_obj">
                    <tbody>
                        <tr><td class="content_label"> Last changed by/on      </td><td class="field"><?php echo $msag['LASTUSER'] ?>&nbsp;</td><td> <?php echo $msag['LDATE'] ?>&nbsp;</td></tr>
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
