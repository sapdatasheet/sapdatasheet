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
$sqlt = ABAP_DB_TABLE_TABL::DD06L(strtoupper($ObjID));
if (empty($sqlt['SQLTAB'])) {
    ABAP_UI_TOOL::Redirect404();
}
$sqlt_desc = ABAP_DB_TABLE_TABL::DD06T($sqlt['SQLTAB']);
$sqlt_sqlcalss_desc = ABAP_UI_TOOL::GetSqltDesc($sqlt['SQLCLASS']);
$dd16s = ABAP_DB_TABLE_TABL::DD16S($sqlt['SQLTAB']);

$wul_counter_list = ABAPANA_DB_TABLE::WULCOUNTER_List(GLOBAL_ABAP_OTYPE::SQLT_NAME, $sqlt['SQLTAB']);
$hier = ABAP_DB_TABLE_HIER::Hier(ABAP_DB_TABLE_HIER::TADIR_PGMID_R3TR, GLOBAL_ABAP_OTYPE::SQLT_NAME, $sqlt['SQLTAB']);
$GLOBALS['TITLE_TEXT'] = ABAP_UI_TOOL::GetObjectTitle(GLOBAL_ABAP_OTYPE::SQLT_NAME, $sqlt['SQLTAB']);

$json_ld = new \OrgSchema\Thing();
$json_ld->name = $sqlt['SQLTAB'];
$json_ld->alternateName = $sqlt_desc;
$json_ld->description = $GLOBALS['TITLE_TEXT'];
$json_ld->image = GLOBAL_ABAP_ICON::getIconURL(GLOBAL_ABAP_ICON::OTYPE_SQLT, TRUE);
$json_ld->url = ABAP_UI_DS_Navigation::GetObjectURL(GLOBAL_ABAP_OTYPE::SQLT_NAME, $json_ld->name);
?>
<!DOCTYPE html>
<!-- DDIC Cluster/Pool table object. -->
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <title><?php echo $GLOBALS['TITLE_TEXT'] . GLOBAL_WEBSITE_SAPDS::TITLE ?> </title>
        <meta name="author" content="SAP Datasheet" />
        <meta name="description" content="<?php echo GLOBAL_WEBSITE_SAPDS::META_DESC; ?>" />
        <meta name="keywords" content="SAP,<?php echo GLOBAL_ABAP_OTYPE::SQLT_DESC ?>,<?php echo $sqlt_sqlcalss_desc ?>,<?php echo $sqlt['SQLTAB'] ?>,<?php echo $sqlt_desc ?>" />

        <link rel="stylesheet" type="text/css"  href="/3rdparty/bootstrap/css/bootstrap.min.css"/>
        <link rel="stylesheet" type="text/css"  href="/sapdatasheet.css"/>

        <script type="application/ld+json"><?php echo $json_ld->toJson() ?></script>
    </head>
    <body>

        <!-- Header -->
        <?php require $__ROOT__ . '/include/header.php' ?>

        <!-- Left -->
        <div class="left">
            <h5>&nbsp;</h5>
            <h5>Object Hierarchy</h5>
            <table>
                <tbody>
                    <tr><td>Software Component</td></tr>
                    <tr><td><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeCVERS() ?>
                        <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Cvers($hier->DLVUNIT, $hier->DLVUNIT_T) ?>&nbsp;</td></tr>
                    <tr><td> Application Component ID</td></tr>
                    <tr><td><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeBMFR() ?>
                        <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Bmfr($hier->FCTR_ID, $hier->POSID, $hier->POSID_T) ?>&nbsp;</td></tr>
                    <tr><td> Package </td></tr>
                    <tr><td><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeDEVC() ?>
                        <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Devc($hier->DEVCLASS, $hier->DEVCLASS_T) ?></td></tr>
                    <tr><td> Object type </td></tr>
                    <tr><td><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeSQLT() ?>
                            <a href="/abap/sqlt/"><?php echo $sqlt_sqlcalss_desc; ?></a></td></tr>
                    <tr><td> Object name </td></tr>
                    <tr><td><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeSQLT() ?>
                            <a href="#" title="<?php echo $sqlt_desc ?>"><?php echo $sqlt['SQLTAB'] ?></a> </td></tr>
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
                <a href="/abap/sqlt/">ABAP <?php echo $sqlt_sqlcalss_desc ?></a> &gt; 
                <a href="#"><?php echo $sqlt['SQLTAB'] ?></a>
            </div>

            <!-- Content Object -->
            <div class="content_obj_title"><span><?php echo $GLOBALS['TITLE_TEXT'] ?></span></div>
            <div class="content_obj">
                <div>
                    <?php include $__WS_ROOT__ . '/common-php/google/adsense-content-top.html' ?>
                </div>

                <?php require $__ROOT__ . '/include/abap_oname_hier.php' ?>

                <h5 class="pt-4"> Basic Data </h5>
                <table>
                    <tbody>
                        <tr><td class="sapds-gui-label"> Category              </td><td class="sapds-gui-field"> <?php echo ABAP_UI_DS_Navigation::GetHyperlink4DomainValue(ABAP_DB_TABLE_TABL::DD06L_SQLCLASS_DOMAIN, $sqlt['SQLCLASS'], $sqlt_sqlcalss_desc) ?> &nbsp;</td><td><?php echo $sqlt_sqlcalss_desc ?>&nbsp;</td></tr>
                        <tr><td class="sapds-gui-label"> <?php echo $sqlt_sqlcalss_desc; ?> </td><td class="sapds-gui-field"> <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Sqlt($sqlt['SQLTAB'], $sqlt_desc) ?> &nbsp;</td><td>&nbsp;</td></tr>
                        <tr><td class="sapds-gui-label"> Short Description     </td><td class="sapds-gui-field"> <?php echo htmlentities($sqlt_desc) ?> &nbsp;</td><td>&nbsp;</td></tr>
                    </tbody>
                </table>

                <!-- Components -->
                <h4> Components </h4>
                <table class="sapds-alv">
                    <thead>
                        <tr><th class="sapds-alv">#</th>
                            <th class="sapds-alv">Field name</th>
                            <th class="sapds-alv">Key</th>
                            <th class="sapds-alv">Data type</th>
                            <th class="sapds-alv">Length</th>
                            <th class="sapds-alv">Internal type</th>
                            <th class="sapds-alv">Internal length</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $count = 0;
                        foreach ($dd16s as $dd16s_item) { 
                            $count++;
                            ?>
                            <tr><td class="sapds-alv" style="text-align: right;"><?php echo number_format($count) ?> </td>
                                <td class="sapds-alv"><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeDTF() ?>
                                    <?php echo $dd16s_item['FIELDNAME'] ?></td>
                                <td class="sapds-alv"><?php echo ABAP_UI_TOOL::GetCheckBox($dd16s_item['FIELDNAME'], $dd16s_item['KEYFLAG']) ?></td>
                                <td class="sapds-alv"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4DomainValue(ABAP_DB_CONST::DOMAIN_DATATYPE, $dd16s_item['DATATYPE'], '') ?></td>
                                <td class="sapds-alv"><?php echo intval($dd16s_item['LENG']) ?></td>
                                <td class="sapds-alv"><?php echo $dd16s_item['INTTYPE'] ?></td>
                                <td class="sapds-alv"><?php echo intval($dd16s_item['INTLEN']) ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

                <!-- Contained table -->
                <h4> Contained table </h4>
                <table class="sapds-alv">
                    <thead>
                        <tr><th class="sapds-alv">Table name</th>
                            <th class="sapds-alv">Short description</th>
                            <th class="sapds-alv">Date of Last Change</th></tr>
                    </thead>
                    <tbody>
                        <?php
                        $dd02l_sqlt = ABAP_DB_TABLE_TABL::DD02L_SQLTAB($sqlt['SQLTAB']);
                        foreach ($dd02l_sqlt as $dd02l_sqlt_item) {
                            $dd02l_sqlt_item_desc = ABAP_DB_TABLE_TABL::DD02T($dd02l_sqlt_item['TABNAME']);
                            ?>
                            <tr>
                                <td class="sapds-alv"><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeTABL() ?>
                                    <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Tabl($dd02l_sqlt_item['TABNAME'], $dd02l_sqlt_item_desc) ?></td>
                                <td class="sapds-alv"><?php echo htmlentities($dd02l_sqlt_item_desc) ?></td>
                                <td class="sapds-alv"><?php echo $dd02l_sqlt_item['AS4DATE'] ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

                <h4> History </h4>
                <table>
                    <tbody>
                        <tr><td class="sapds-gui-label"> Last changed by/on      </td><td class="sapds-gui-field"><?php echo $sqlt['AS4USER'] ?>&nbsp;</td><td> <?php echo $sqlt['AS4DATE'] ?>&nbsp;</td></tr>
                        <tr><td class="sapds-gui-label"> SAP Release Created in  </td><td class="sapds-gui-field"><?php echo $hier->CRELEASE ?>&nbsp;</td><td>&nbsp;</td></tr>
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
