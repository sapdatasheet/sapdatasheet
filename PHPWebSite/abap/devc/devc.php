<!DOCTYPE html>
<!-- Package object. -->
<?php
define('__ROOT__', dirname(dirname(dirname(__FILE__))));
require_once (__ROOT__ . '/include/global.php');
require_once (__ROOT__ . '/include/abap_db.php');
require_once (__ROOT__ . '/include/abap_ui.php');

if (!isset($ObjID)) {
    $ObjID = filter_input(INPUT_GET, 'id');
}

if (empty($ObjID)) {
    ABAP_UI_TOOL::Redirect404();
}
$tdevc = ABAP_DB_TABLE_HIER::TDEVC(strtoupper($ObjID));
if (empty($tdevc['DEVCLASS'])) {
    ABAP_UI_TOOL::Redirect404();
}

$GLOBALS['TITLE_TEXT'] = 'SAP ABAP ' . ABAP_OTYPE::DEVC_DESC . ' ' . $tdevc['DEVCLASS'];
$tdevc_desc = ABAP_DB_TABLE_HIER::TDEVCT($tdevc['DEVCLASS']);
$tdevc_parent_desc = ABAP_DB_TABLE_HIER::TDEVCT($tdevc['PARENTCL']);
$tdevc_mainpack_desc = ABAP_DB_TABLE_DOMA::DD07T(ABAP_DB_CONST::DOMAIN_TDEVC_MAINPACK, $tdevc['MAINPACK']);
$hier = ABAP_DB_TABLE_HIER::Hier(ABAP_DB_CONST::TADIR_PGMID_R3TR, ABAP_OTYPE::DEVC_NAME, $tdevc['DEVCLASS']);
$child_tabl = ABAP_DB_TABLE_HIER::TADIR_Child($tdevc['DEVCLASS'], ABAP_DB_CONST::TADIR_PGMID_R3TR, ABAP_OTYPE::TABL_NAME);
$child_tran = ABAP_DB_TABLE_HIER::TADIR_Child($tdevc['DEVCLASS'], ABAP_DB_CONST::TADIR_PGMID_R3TR, ABAP_OTYPE::TRAN_NAME);
?>
<html>
    <head>
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" href="/abap.css" type="text/css" />
        <title><?php echo $GLOBALS['TITLE_TEXT'] ?> <?php echo WEBSITE::TITLE ?> </title>
        <meta name="keywords" content="SAP,<?php echo ABAP_OTYPE::DEVC_DESC ?>,<?php echo $tdevc['DEVCLASS'] ?>,<?php echo $tdevc_desc ?>" />
        <meta name="description" content="<?php echo WEBSITE::META_DESC; ?>" />
        <meta name="author" content="SAP Datasheet" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    </head>
    <body>

        <!-- Header -->
        <?php require __ROOT__ . '/include/header.php' ?>

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
                    <tr><td class="left_value"><?php echo ABAP_Navigation::GetURLPackage($tdevc['DEVCLASS'], $tdevc_desc) ?></td></tr>
                </tbody>
            </table>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Content Navigator -->
            <div class="content_navi">
                <a href="/">Home page</a> &gt; 
                <a href="/abap/">ABAP Object</a> &gt; 
                <a href="/abap/devc/">ABAP <?php echo ABAP_OTYPE::DEVC_DESC ?></a> &gt; 
                <a href="#"><?php echo $tdevc['DEVCLASS'] ?></a>
            </div>

            <!-- Content Object -->
            <div class="content_obj_title"><span><?php echo $GLOBALS['TITLE_TEXT'] ?></span></div>
            <div class="content_obj">
                <h4> Basic Data </h4>
                <table class="content_obj">
                    <tbody>
                        <tr><td class="content_label"> Package                </td>
                            <td class="field"><a href="#"><?php echo $tdevc['DEVCLASS'] ?></a>&nbsp;</td>
                            <td>&nbsp;</td></tr>
                        <tr><td class="content_label"> Short Description      </td><td class="field"> <?php echo $tdevc_desc ?> &nbsp;</td><td>&nbsp;</td></tr>
                        <tr><td class="content_label"> Super package          </td>
                            <td class="field"><?php echo ABAP_Navigation::GetURLPackage($tdevc['PARENTCL'], $tdevc_parent_desc) ?> &nbsp;</td>
                            <td><?php echo $tdevc_parent_desc ?>&nbsp;</td></tr>
                        <tr><td class="content_label"> Main package indicator </td>
                            <td class="field"> <?php echo ABAP_Navigation::GetURLDomainValue(ABAP_DB_CONST::DOMAIN_TDEVC_MAINPACK, $tdevc['MAINPACK'], $tdevc_mainpack_desc) ?> &nbsp;</td>
                            <td><?php echo $tdevc_mainpack_desc ?>&nbsp;</td></tr>
                        <tr><td class="content_label"> Created by/on          </td><td class="field"><?php echo $tdevc['CREATED_BY'] ?>&nbsp;</td><td class="field"> <?php echo $tdevc['CREATED_ON'] ?>&nbsp;</td></tr>
                    </tbody>
                </table><!-- Basic Data: End -->

                <!-- Package Content -->
                <h4> Package Content</h4>
                <!-- Contained Tables or Views -->
                <?php if (mysqli_num_rows($child_tabl) > 0) { ?>
                    <table class="alv">
                        <caption>Contained Tables / Views</caption>
                        <tr>
                            <th class="alv"> Table Name </th>
                            <th class="alv"> Short Description </th>
                            <th class="alv"> Table Category </th>
                            <th class="alv"> Delivery Class </th>
                        </tr>                        
                        <?php
                        while ($child_tabl_item = mysqli_fetch_array($child_tabl)) {
                            $table_dd02l = ABAP_DB_TABLE_TABL::DD02L($child_tabl_item['OBJ_NAME']);
                            $child_tabl_item_t = ABAP_DB_TABLE_TABL::DD02T($child_tabl_item['OBJ_NAME']);
                            if ($table_dd02l['TABCLASS'] === ABAP_DB_CONST::DOMAINVALUE_TABCLASS_TRANSP || $table_dd02l['TABCLASS'] == ABAP_DB_CONST::DOMAINVALUE_TABCLASS_POOL || $table_dd02l['TABCLASS'] == ABAP_DB_CONST::DOMAINVALUE_TABCLASS_CLUSTER || $table_dd02l['TABCLASS'] == ABAP_DB_CONST::DOMAINVALUE_TABCLASS_VIEW
                            ) {
                                ?>
                                <tr><td class="alv"><?php echo ABAP_Navigation::GetURLTable($child_tabl_item['OBJ_NAME'], $child_tabl_item_t) ?></td>
                                    <td class="alv"><?php echo $child_tabl_item_t ?>&nbsp;</td>
                                    <td class="alv"><?php echo ABAP_Navigation::GetURLDomainValue(ABAP_DB_CONST::DOMAIN_DD02L_TABCLASS, $table_dd02l['TABCLASS'], '') ?> &nbsp;</td>
                                    <td class="alv"><?php echo ABAP_Navigation::GetURLDomainValue(ABAP_DB_CONST::DOMAIN_DD02L_CONTFLAG, $table_dd02l['CONTFLAG'], '') ?> &nbsp;</td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                        <tr><td class="alv">&nbsp;</td>
                            <td class="alv">&nbsp;</td>
                            <td class="alv">&nbsp;</td>
                            <td class="alv">&nbsp;</td>
                        </tr>
                    </table><!-- Contained Tables or Views: End -->
                <?php } ?>
                <!-- Contained T-Codes -->
                <?php if (mysqli_num_rows($child_tran) > 0) { ?>
                    <table class="alv">
                        <caption>Contained Transaction Codes</caption>
                        <tr>
                            <th class="alv"> Transaction Code </th>
                            <th class="alv"> Short Description </th>
                            <th class="alv"> Program </th>
                        </tr>                        
                        <?php
                        while ($child_tran_item = mysqli_fetch_array($child_tran)) {
                            $tcode_tstc = ABAP_DB_TABLE_TRAN::TSTC($child_tran_item['OBJ_NAME']);
                            $child_tran_item_t = ABAP_DB_TABLE_TRAN::TSTCT($child_tran_item['OBJ_NAME']);
                            ?>
                            <tr><td class="alv"><?php echo ABAP_Navigation::GetURLTransactionCode($child_tran_item['OBJ_NAME'], $child_tran_item_t) ?></td>
                                <td class="alv"><?php echo $child_tran_item_t ?>&nbsp;</td>
                                <td class="alv"><?php echo ABAP_Navigation::GetURLProgram($tcode_tstc['PGMNA'], '') ?> &nbsp;</td>
                            </tr>
                        <?php } ?>
                        <tr><td class="alv">&nbsp;</td>
                            <td class="alv">&nbsp;</td>
                            <td class="alv">&nbsp;</td>
                        </tr>
                    </table>
                <?php } ?><!-- Contained T-Codes: End -->
                <!-- Package Content: End -->

                <h4> Hierarchy </h4>
                <table class="content_obj">
                    <tbody>
                        <tr><td class="content_label"> Software Component      </td><td class="field"><?php echo ABAP_Navigation::GetURLSoftComp($hier->DLVUNIT, $hier->DLVUNIT_T) ?>&nbsp;</td><td> <?php echo $hier->DLVUNIT_T ?>&nbsp;</td></tr>
                        <tr><td class="content_label"> SAP Release Created in  </td><td class="field"><?php echo $hier->CRELEASE ?>&nbsp;</td><td>&nbsp;</td></tr>
                        <tr><td class="content_label"> Application Component   </td><td class="field"><?php echo ABAP_Navigation::GetURLAppComp($hier->FCTR_ID, $hier->POSID, $hier->POSID_T) ?>&nbsp;(<?php echo $hier->FCTR_ID ?>)</td><td> <?php echo $hier->POSID_T ?>&nbsp;</td></tr>
                        <tr><td class="content_label"> Package                 </td><td class="field"><?php echo ABAP_Navigation::GetURLPackage($hier->DEVCLASS, $hier->DEVCLASS_T); ?>&nbsp;</td><td> <?php echo $hier->DEVCLASS_T ?>&nbsp;</td></tr>
                    </tbody>
                </table><!-- Hierarchy: End -->

            </div>
        </div><!-- Content: End -->

        <!-- Footer -->
        <?php include __ROOT__ . '/include/footer.html' ?>

    </body>
</html>

