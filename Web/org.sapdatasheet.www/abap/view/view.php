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
$dd25l = ABAP_DB_TABLE_VIEW::DD25L(strtoupper($ObjID));
if (empty($dd25l['VIEWNAME'])) {
    ABAP_UI_TOOL::Redirect404();
}
$dd25l_desc = ABAP_DB_TABLE_VIEW::DD25T($dd25l['VIEWNAME']);
$dd25l_roottab_desc = ABAP_DB_TABLE_TABL::DD02T($dd25l['ROOTTAB']);
$dd25l_viewclass_desc = ABAP_DB_TABLE_DOMA::DD07T(ABAP_DB_CONST::DOMAIN_DD25L_VIEWCLASS, $dd25l['VIEWCLASS']);
$dd26s_list = ABAP_DB_TABLE_VIEW::DD26S_List($dd25l['VIEWNAME']);
$dd27s_list = ABAP_DB_TABLE_VIEW::DD27S_List($dd25l['VIEWNAME']);
$dd28s_list = ABAP_DB_TABLE_VIEW::DD28S_List($dd25l['VIEWNAME']);
$dm25l = ABAP_DB_TABLE_VIEW::DM25L($dd25l['VIEWNAME']);
if (!empty($dm25l['ENTID'])) {
    $dm25l_entid_desc = ABAP_DB_TABLE_VIEW::DM02T($dm25l['ENTID']);
}

$wul_counter_list = ABAPANA_DB_TABLE::WULCOUNTER_List(GLOBAL_ABAP_OTYPE::VIEW_NAME, $dd25l['VIEWNAME']);
$wil_enabled = TRUE;
$wil_counter_list = ABAPANA_DB_TABLE::WILCOUNTER_List(GLOBAL_ABAP_OTYPE::VIEW_NAME, $dd25l['VIEWNAME']);

$hier = ABAP_DB_TABLE_HIER::Hier(ABAP_DB_TABLE_HIER::TADIR_PGMID_R3TR, GLOBAL_ABAP_OTYPE::VIEW_NAME, $dd25l['VIEWNAME']);
$GLOBALS['TITLE_TEXT'] = ABAP_UI_TOOL::GetObjectTitle(GLOBAL_ABAP_OTYPE::VIEW_NAME, $dd25l['VIEWNAME']);

$json_ld = new \OrgSchema\Thing();
$json_ld->name = $dd25l['VIEWNAME'];
$json_ld->alternateName = $dd25l_desc;
$json_ld->description = $GLOBALS['TITLE_TEXT'];
$json_ld->image = GLOBAL_ABAP_ICON::getIconURL(GLOBAL_ABAP_ICON::OTYPE_VIEW, TRUE);
$json_ld->url = ABAP_UI_DS_Navigation::GetObjectURL(GLOBAL_ABAP_OTYPE::VIEW_NAME, $json_ld->name);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <title><?php echo $GLOBALS['TITLE_TEXT'] . GLOBAL_WEBSITE_SAPDS::TITLE ?> </title>
        <meta name="author" content="SAP Datasheet" />
        <meta name="description" content="<?php echo GLOBAL_WEBSITE_SAPDS::META_DESC; ?>" />
        <meta name="keywords" content="SAP,<?php echo GLOBAL_ABAP_OTYPE::VIEW_DESC ?>,<?php echo $dd25l['VIEWNAME']; ?>,<?php echo $dd25l_desc ?>" />

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
                    <tr><td><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeVIEW() ?>
                            <a href="/abap/view/"><?php echo GLOBAL_ABAP_OTYPE::VIEW_DESC ?></a></td></tr>
                    <tr><td> Object name </td></tr>
                    <tr><td><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeVIEW() ?>
                            <a href="#" title="<?php echo $dd25l_desc ?>"><?php echo $dd25l['VIEWNAME'] ?></a> </td></tr>
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
                <a href="/abap/view/"><?php echo GLOBAL_ABAP_OTYPE::VIEW_DESC ?></a> &gt; 
                <a href="#"><?php echo $dd25l['VIEWNAME'] ?></a>
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
                        <tr><td class="sapds-gui-label"> View Type             </td>
                            <td class="sapds-gui-field"> <?php echo ABAP_UI_DS_Navigation::GetHyperlink4DomainValue(ABAP_DB_CONST::DOMAIN_DD25L_VIEWCLASS, $dd25l['VIEWCLASS'], $dd25l_viewclass_desc) ?> </td>
                            <td><?php echo htmlentities($dd25l_viewclass_desc) ?>&nbsp;</td>
                        </tr>
                        <tr><td class="sapds-gui-label"> <?php echo $dd25l_viewclass_desc ?></td>
                            <td class="sapds-gui-field"> <?php echo ABAP_UI_DS_Navigation::GetHyperlink4View($dd25l['VIEWNAME'], $dd25l_desc) ?> </td>
                            <td>&nbsp;</td></tr>
                        <tr><td class="sapds-gui-label"> Short Description     </td>
                            <td class="sapds-gui-field"> <?php echo htmlentities($dd25l_desc) ?> &nbsp;</td>
                            <td>&nbsp;</td></tr>
                        <tr><td class="sapds-gui-label"> Root table </td>
                            <td class="sapds-gui-field"> <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Tabl($dd25l['ROOTTAB'], $dd25l_roottab_desc) ?> &nbsp;</td>
                            <td><?php echo htmlentities($dd25l_roottab_desc) ?>&nbsp; </td></tr>
                    </tbody>
                </table>

                <?php if (!empty($dm25l['ENTID'])) { ?>
                    <table  class="content_obj">
                        <tbody>
                            <tr><td class="sapds-gui-label">Entity Type</td><td class="sapds-gui-field"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4Tabl("DM02L", $dm25l['ENTID']) ?>&nbsp;</td></tr>
                            <tr><td class="sapds-gui-label">Short text </td><td class="sapds-gui-field"><?php echo htmlentities($dm25l_entid_desc) ?></td></tr>
                        </tbody>
                    </table>
                <?php } ?>

                <!-- Table & Join Conditions -->
                <h4>Table</h4>
                <table class="table table-sm">
                    <thead>
                        <tr><th class="sapds-alv">#</th>
                            <th class="sapds-alv">Table Name</th>
                            <th class="sapds-alv">Foreign Table</th>
                            <th class="sapds-alv">Foreign Field</th>
                            <th class="sapds-alv">Foreign DIR</th></tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($dd26s_list as $dd26s) {
                            $dd26s_tabname_desc = ABAP_DB_TABLE_TABL::DD02T($dd26s['TABNAME']);
                            $dd26s_fortabname_desc = ABAP_DB_TABLE_TABL::DD02T($dd26s['FORTABNAME']);
                            ?>
                            <tr>
                                <td class="sapds-alv"><?php echo $dd26s['TABPOS'] ?></td>
                                <td class="sapds-alv"><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeTABL() ?>
                                    <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Tabl($dd26s['TABNAME'], $dd26s_tabname_desc) ?></td>
                                <td class="sapds-alv"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4Tabl($dd26s['FORTABNAME'], $dd26s_fortabname_desc) ?></td>
                                <td class="sapds-alv"><?php echo $dd26s['FORFIELD'] ?></td>
                                <td class="sapds-alv"><?php echo $dd26s['FORDIR'] ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>                

                <h4>Join Conditions</h4>
                <table class="table table-sm">
                    <thead>
                        <tr><th class="sapds-alv">#</th>
                            <th class="sapds-alv">Table Name</th>
                            <th class="sapds-alv">Field Name</th>
                            <th class="sapds-alv">Negation</th>
                            <th class="sapds-alv">Operator</th>
                            <th class="sapds-alv">Constants</th>
                            <th class="sapds-alv">Cont. line</th>
                            <th class="sapds-alv">AND/OR</th>
                            <th class="sapds-alv">Offset</th>
                            <th class="sapds-alv">F Length</th>
                            <th class="sapds-alv">Mco Field</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($dd28s_list as $dd28s) {
                            $dd28s_tabname_desc = ABAP_DB_TABLE_TABL::DD02T($dd28s['TABNAME']);
                            ?>
                            <tr>
                                <td class="sapds-alv"><?php echo $dd28s['POSITION'] ?></td>
                                <td class="sapds-alv"><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeTABL() ?>
                                    <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Tabl($dd28s['TABNAME'], $dd28s_tabname_desc) ?></td>
                                <td class="sapds-alv"><?php echo $dd28s['FIELDNAME'] ?></td>
                                <td class="sapds-alv"><?php echo $dd28s['NEGATION'] ?></td>
                                <td class="sapds-alv"><?php echo $dd28s['OPERATOR'] ?></td>
                                <td class="sapds-alv"><?php echo $dd28s['CONSTANTS'] ?></td>
                                <td class="sapds-alv"><?php echo $dd28s['CONTLINE'] ?></td>
                                <td class="sapds-alv"><?php echo $dd28s['AND_OR'] ?></td>
                                <td class="sapds-alv"><?php echo $dd28s['OFFSET'] ?></td>
                                <td class="sapds-alv"><?php echo $dd28s['FLENGTH'] ?></td>
                                <td class="sapds-alv"><?php echo $dd28s['MCOFIELD'] ?></td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td class="sapds-alv">&nbsp;</td>
                            <td class="sapds-alv">&nbsp;</td>
                            <td class="sapds-alv">&nbsp;</td>
                            <td class="sapds-alv">&nbsp;</td>
                            <td class="sapds-alv">&nbsp;</td>
                            <td class="sapds-alv">&nbsp;</td>
                            <td class="sapds-alv">&nbsp;</td>
                            <td class="sapds-alv">&nbsp;</td>
                            <td class="sapds-alv">&nbsp;</td>
                            <td class="sapds-alv">&nbsp;</td>
                            <td class="sapds-alv">&nbsp;</td>
                        </tr>
                    </tbody>
                </table>                  
                <!-- Table / Join Conditions: End -->

                <!-- View Fields -->
                <h4>View Fields </h4>
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th class="sapds-alv">#</th>
                            <th class="sapds-alv">View field</th>
                            <th class="sapds-alv">Table</th>
                            <th class="sapds-alv">Field</th>
                            <th class="sapds-alv">Maintenance Flag</th>
                            <th class="sapds-alv">Key</th>
                            <th class="sapds-alv">Data element</th>
                            <th class="sapds-alv">Mod</th>
                            <th class="sapds-alv">Short Description</th>
                            <!-- TODO: <th class="sapds-alv">Switch</th></tr> -->
                    </thead>
                    <tbody>
                        <?php
                        foreach ($dd27s_list as $dd27s) {
                            $dd27s_rollname_desc = ABAP_DB_TABLE_DTEL::DD04T($dd27s['ROLLNAME']);
                            ?>
                            <tr>
                                <td class="sapds-alv"><?php echo $dd27s['OBJPOS'] ?> </td>
                                <td class="sapds-alv"><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeDTF() ?>
                                    <?php echo $dd27s['VIEWFIELD'] ?> </td>
                                <td class="sapds-alv"><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeTABL() ?>
                                    <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Tabl($dd27s['TABNAME'], '') ?> </td>
                                <td class="sapds-alv"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4TablField($dd27s['TABNAME'], $dd27s['FIELDNAME']) ?> </td>
                                <td class="sapds-alv"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4DomainValue(ABAP_DB_CONST::DOMAIN_DD27S_RDONLY, $dd27s['RDONLY'], '') ?> </td>
                                <td class="sapds-alv"><?php echo ABAP_UI_TOOL::GetCheckBox("FELD_KEY_" . $dd27s['OBJPOS'], $dd27s['RDONLY']) ?> </td>
                                <td class="sapds-alv"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4Dtel($dd27s['ROLLNAME'], '') ?> </td>
                                <td class="sapds-alv"><?php echo ABAP_UI_TOOL::GetCheckBox("FELD_MOD_" . $dd27s['OBJPOS'], $dd27s['ROLLCHANGE']) ?> </td>
                                <td class="sapds-alv"><?php echo htmlentities($dd27s_rollname_desc) ?> </td>
                                <!-- TODO: <td class="sapds-alv">f.SWITCH_ID </td> -->
                            </tr>
                        <?php } ?>
                        <tr>
                            <td class="sapds-alv">&nbsp;</td>
                            <td class="sapds-alv">&nbsp;</td>
                            <td class="sapds-alv">&nbsp;</td>
                            <td class="sapds-alv">&nbsp;</td>
                            <td class="sapds-alv">&nbsp;</td>
                            <td class="sapds-alv">&nbsp;</td>
                            <td class="sapds-alv">&nbsp;</td>
                            <td class="sapds-alv">&nbsp;</td>
                            <td class="sapds-alv">&nbsp;</td>
                        <!-- TODO: <td class="sapds-alv">f.SWITCH_ID </td> -->
                        </tr>
                    </tbody>
                </table><!-- View Fields: End -->

                <!-- Maintenance Status -->
                <h4>Maintenance Status </h4>
                <table>
                    <caption class="sapds-alv">Access</caption>
                    <tbody>
                        <tr><td class="sapds-gui-field">
                                <?php echo ABAP_UI_TOOL::GetRadioBox("mtst_access", $dd25l['VIEWGRANT'] == ABAP_DB_CONST::DOMAINVALUE_VIEWGRANT_R) ?> &nbsp; 
                                <?php echo ABAP_DB_CONST::DOMAINVALUE_VIEWGRANT_R_DESC ?></td></tr>
                        <tr><td class="sapds-gui-field">
                                <?php echo ABAP_UI_TOOL::GetRadioBox("mtst_access", $dd25l['VIEWGRANT'] == ABAP_DB_CONST::DOMAINVALUE_VIEWGRANT_U) ?> &nbsp; 
                                <?php echo ABAP_DB_CONST::DOMAINVALUE_VIEWGRANT_U_DESC ?></td></tr>
                        <tr><td class="sapds-gui-field">
                                <?php echo ABAP_UI_TOOL::GetRadioBox("mtst_access", $dd25l['VIEWGRANT'] == ABAP_DB_CONST::DOMAINVALUE_VIEWGRANT_M) ?> &nbsp; 
                                <?php echo ABAP_DB_CONST::DOMAINVALUE_VIEWGRANT_M_DESC ?></td></tr>
                        <tr><td class="sapds-gui-field">
                                <?php echo ABAP_UI_TOOL::GetRadioBox("mtst_access", $dd25l['VIEWGRANT'] == ABAP_DB_CONST::DOMAINVALUE_VIEWGRANT_SPACE) ?> &nbsp; 
                                <?php echo ABAP_DB_CONST::DOMAINVALUE_VIEWGRANT_SPACE_DESC ?></td></tr>
                    </tbody>
                </table>
                <table>
                    <?php
                    $dd25l_customauth_desc = ABAP_DB_TABLE_DOMA::DD07T(ABAP_DB_CONST::DOMAIN_DD25L_CUSTOMAUTH, $dd25l['CUSTOMAUTH']);
                    $dd25l_globalflag_desc = ABAP_DB_TABLE_DOMA::DD07T(ABAP_DB_CONST::DOMAIN_DD25L_GLOBALFLAG, $dd25l['GLOBALFLAG']);
                    ?>
                    <tbody>
                        <tr>
                            <td class="sapds-gui-label"> Delivery Class </td>
                            <td class="sapds-gui-field"> <?php echo ABAP_UI_DS_Navigation::GetHyperlink4DomainValue(ABAP_DB_CONST::DOMAIN_DD25L_CUSTOMAUTH, $dd25l['CUSTOMAUTH'], $dd25l_customauth_desc) ?> &nbsp;</td>
                            <td> <?php echo htmlentities($dd25l_customauth_desc) ?>&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="sapds-gui-label"> Data Browser/Table View Maintenance </td>
                            <td class="sapds-gui-field"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4DomainValue(ABAP_DB_CONST::DOMAIN_DD25L_GLOBALFLAG, $dd25l['GLOBALFLAG'], $dd25l_globalflag_desc) ?>&nbsp;</td>
                            <td><?php echo htmlentities($dd25l_globalflag_desc) ?> &nbsp;</td></tr>
                    </tbody>
                </table><!-- Maintenance Status: End -->

                <!-- History -->
                <h4> History </h4>
                <table>
                    <tbody>
                        <tr><td class="sapds-gui-label"> Last changed by/on      </td><td class="sapds-gui-field"><?php echo $dd25l['AS4USER'] ?>&nbsp;</td><td> <?php echo $dd25l['AS4DATE'] ?>&nbsp;</td></tr>
                        <tr><td class="sapds-gui-label"> SAP Release Created in  </td><td class="sapds-gui-field"><?php echo $hier->CRELEASE ?>&nbsp;</td><td>&nbsp;</td></tr>
                    </tbody>
                </table><!-- Hierarchy: End -->

            </div>
        </div><!-- Content: End -->

        <!-- Footer -->
        <?php require $__ROOT__ . '/include/footer.php' ?>

    </body>
</html>
<?php
// Close PDO Database Connection
ABAP_DB_TABLE::close_conn();
