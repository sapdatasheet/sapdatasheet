<!DOCTYPE html>
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

$hier = ABAP_DB_TABLE_HIER::Hier(ABAP_DB_CONST::TADIR_PGMID_R3TR, ABAP_OTYPE::VIEW_NAME, $dd25l['VIEWNAME']);
$GLOBALS['TITLE_TEXT'] = 'SAP ABAP ' . ABAP_OTYPE::VIEW_DESC . ' ' . $dd25l['VIEWNAME'];
?>
<html>
    <head>
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" href="/abap.css" type="text/css" />
        <title><?php echo $GLOBALS['TITLE_TEXT'] ?> <?php echo WEBSITE::TITLE ?> </title>
        <meta name="keywords" content="SAP,<?php echo ABAP_OTYPE::VIEW_DESC ?>,<?php echo $dd25l['VIEWNAME']; ?>,<?php echo $dd25l_desc ?>" />
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
                    <tr><td class="left_value"><?php echo ABAP_Navigation::GetURLPackage($hier->DEVCLASS, $hier->DEVCLASS_T) ?></td></tr>
                    <tr><td class="left_attribute"> Object type </td></tr>
                    <tr><td class="left_value"><a href="/abap/view/"><?php echo ABAP_OTYPE::VIEW_DESC ?></a></td></tr>
                    <tr><td class="left_attribute"> Object name </td></tr>
                    <tr><td class="left_value"> <a href="#" title="<?php echo $dd25l_desc ?>"><?php echo $dd25l['VIEWNAME'] ?></a> </td></tr>
                </tbody>
            </table>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Content Navigator -->
            <div class="content_navi">
                <a href="/">Home page</a> &gt; 
                <a href="/abap/">ABAP Object</a> &gt; 
                <a href="/abap/view/"><?php echo ABAP_OTYPE::VIEW_DESC ?></a> &gt; 
                <a href="#"><?php echo $dd25l['VIEWNAME'] ?></a>
            </div>

            <!-- Content Object -->
            <div class="content_obj_title"><span><?php echo $GLOBALS['TITLE_TEXT'] ?></span></div>
            <div class="content_obj">
                <h4> Basic Data </h4>
                <table class="content_obj">
                    <tbody>
                        <tr><td class="content_label"> View Type             </td>
                            <td class="field"> <?php echo ABAP_Navigation::GetURLDomainValue(ABAP_DB_CONST::DOMAIN_DD25L_VIEWCLASS, $dd25l['VIEWCLASS'], $dd25l_viewclass_desc) ?> </td>
                            <td><?php echo $dd25l_viewclass_desc ?>&nbsp;</td>
                        </tr>
                        <tr><td class="content_label"> <?php echo $dd25l_viewclass_desc ?></td>
                            <td class="field"> <?php echo ABAP_Navigation::GetURLView($dd25l['VIEWNAME'], $dd25l_desc) ?> </td>
                            <td>&nbsp;</td></tr>
                        <tr><td class="content_label"> Short Description     </td>
                            <td class="field"> <?php echo $dd25l_desc ?> &nbsp;</td>
                            <td>&nbsp;</td></tr>
                        <tr><td class="content_label"> Root table </td>
                            <td class="field"> <?php echo ABAP_Navigation::GetURLTable($dd25l['ROOTTAB'], $dd25l_roottab_desc) ?> &nbsp;</td>
                            <td><?php echo $dd25l_roottab_desc ?>&nbsp; </td></tr>
                    </tbody>
                </table>

                <?php if (!empty($dm25l['ENTID'])) { ?>
                    <table  class="content_obj">
                        <tbody>
                            <tr><td class="content_label">Entity Type</td><td class="field"><?php echo ABAP_Navigation::GetURLTable("DM02L", $dm25l['ENTID']) ?>&nbsp;</td></tr>
                            <tr><td class="content_label">Short text </td><td class="field"><?php echo $dm25l_entid_desc ?></td></tr>
                        </tbody>
                    </table>
                <?php } ?>

                <!-- Table / Join Conditions -->
                <h4>Table</h4>
                <table class="alv">
                    <thead>
                        <tr><th class="alv">#</th>
                            <th class="alv">Table Name</th>
                            <th class="alv">Foreign Table</th>
                            <th class="alv">Foreign Field</th>
                            <th class="alv">Foreign DIR</th></tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($dd26s = mysqli_fetch_array($dd26s_list)) {
                            $dd26s_tabname_desc = ABAP_DB_TABLE_TABL::DD02T($dd26s['TABNAME']);
                            $dd26s_fortabname_desc = ABAP_DB_TABLE_TABL::DD02T($dd26s['FORTABNAME']);
                            ?>
                            <tr>
                                <td class="alv"><?php echo $dd26s['TABPOS'] ?></td>
                                <td class="alv"><?php echo ABAP_Navigation::GetURLTable($dd26s['TABNAME'], $dd26s_tabname_desc) ?></td>
                                <td class="alv"><?php echo ABAP_Navigation::GetURLTable($dd26s['FORTABNAME'], $dd26s_fortabname_desc) ?></td>
                                <td class="alv"><?php echo $dd26s['FORFIELD'] ?></td>
                                <td class="alv"><?php echo $dd26s['FORDIR'] ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>                

                <h4>Join Conditions</h4>
                <table class="alv">
                    <thead>
                        <tr><th class="alv">#</th>
                            <th class="alv">Table Name</th>
                            <th class="alv">Field Name</th>
                            <th class="alv">Negation</th>
                            <th class="alv">Operator</th>
                            <th class="alv">Constants</th>
                            <th class="alv">Cont. line</th>
                            <th class="alv">AND/OR</th>
                            <th class="alv">Offset</th>
                            <th class="alv">F Length</th>
                            <th class="alv">Mco Field</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($dd28s = mysqli_fetch_array($dd28s_list)) {
                            $dd28s_tabname_desc = ABAP_DB_TABLE_TABL::DD02T($dd28s['TABNAME']);
                            ?>
                            <tr>
                                <td class="alv"><?php echo $dd28s['POSITION'] ?></td>
                                <td class="alv"><?php echo ABAP_Navigation::GetURLTable($dd28s['TABNAME'], $dd28s_tabname_desc) ?></td>
                                <td class="alv"><?php echo $dd28s['FIELDNAME'] ?></td>
                                <td class="alv"><?php echo $dd28s['NEGATION'] ?></td>
                                <td class="alv"><?php echo $dd28s['OPERATOR'] ?></td>
                                <td class="alv"><?php echo $dd28s['CONSTANTS'] ?></td>
                                <td class="alv"><?php echo $dd28s['CONTLINE'] ?></td>
                                <td class="alv"><?php echo $dd28s['AND_OR'] ?></td>
                                <td class="alv"><?php echo $dd28s['OFFSET'] ?></td>
                                <td class="alv"><?php echo $dd28s['FLENGTH'] ?></td>
                                <td class="alv"><?php echo $dd28s['MCOFIELD'] ?></td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td class="alv">&nbsp;</td>
                            <td class="alv">&nbsp;</td>
                            <td class="alv">&nbsp;</td>
                            <td class="alv">&nbsp;</td>
                            <td class="alv">&nbsp;</td>
                            <td class="alv">&nbsp;</td>
                            <td class="alv">&nbsp;</td>
                            <td class="alv">&nbsp;</td>
                            <td class="alv">&nbsp;</td>
                            <td class="alv">&nbsp;</td>
                            <td class="alv">&nbsp;</td>
                        </tr>
                    </tbody>
                </table>                  
                <!-- Table / Join Conditions: End -->

                <!-- View Fields -->
                <h4>View Fields </h4>
                <table class="alv">
                    <thead>
                        <tr>
                            <th class="alv">#</th>
                            <th class="alv">View field</th>
                            <th class="alv">Table</th>
                            <th class="alv">Field</th>
                            <th class="alv">Maintenance Flag</th>
                            <th class="alv">Key</th>
                            <th class="alv">Data element</th>
                            <th class="alv">Mod</th>
                            <th class="alv">Data Type</th>
                            <th class="alv">Length</th>
                            <th class="alv">Short Description</th>
                            <!-- TODO: <th class="alv">Switch</th></tr> -->
                    </thead>
                    <tbody>
                        <?php
                        while ($dd27s = mysqli_fetch_array($dd27s_list)) {
                            $dd27s_rollname_desc = ABAP_DB_TABLE_DTEL::DD04T($dd27s['ROLLNAME']);
                            ?>
                            <tr>
                                <td class="alv"><?php echo $dd27s['OBJPOS'] ?> </td>
                                <td class="alv"><?php echo $dd27s['VIEWFIELD'] ?> </td>
                                <td class="alv"><?php echo ABAP_Navigation::GetURLTable($dd27s['TABNAME'], '') ?> </td>
                                <td class="alv"><?php echo $dd27s['FIELDNAME'] ?> </td>
                                <td class="alv"><?php echo ABAP_Navigation::GetURLDomainValue(ABAP_DB_CONST::DOMAIN_DD27S_RDONLY, $dd27s['RDONLY'], '') ?> </td>
                                <td class="alv"><?php echo ABAP_UI_TOOL::GetCheckBox("FELD_KEY_" . $dd27s['OBJPOS'], $dd27s['RDONLY']) ?> </td>
                                <td class="alv"><?php echo ABAP_Navigation::GetURLDtel($dd27s['ROLLNAME'], '') ?> </td>
                                <td class="alv"><?php echo ABAP_UI_TOOL::GetCheckBox("FELD_MOD_" . $dd27s['OBJPOS'], $dd27s['ROLLCHANGE']) ?> </td>
                                <td class="alv"><?php echo ABAP_Navigation::GetURLDomainValue(ABAP_DB_CONST::DOMAIN_DATATYPE, $dd27s['DATATYPE'], $dd27s_rollname_desc) ?> </td>
                                <td class="alv" align="right"><?php echo ABAP_UI_TOOL::CheckInt($dd27s['LENG']) ?>&nbsp; </td>
                                <td class="alv"><?php echo $dd27s_rollname_desc ?> </td>
                                <!-- TODO: <td class="alv">f.SWITCH_ID </td> -->
                            </tr>
                        <?php } ?>
                        <tr>
                            <td class="alv">&nbsp;</td>
                            <td class="alv">&nbsp;</td>
                            <td class="alv">&nbsp;</td>
                            <td class="alv">&nbsp;</td>
                            <td class="alv">&nbsp;</td>
                            <td class="alv">&nbsp;</td>
                            <td class="alv">&nbsp;</td>
                            <td class="alv">&nbsp;</td>
                            <td class="alv">&nbsp;</td>
                            <td class="alv">&nbsp;</td>
                            <td class="alv">&nbsp;</td>
                        <!-- TODO: <td class="alv">f.SWITCH_ID </td> -->
                        </tr>
                    </tbody>
                </table><!-- View Fields: End -->

                <!-- Maintenance Status -->
                <h4>Maintenance Status </h4>
                <table class="content_obj">
                    <caption>Access</caption>
                    <tbody>
                        <tr><td class="field">
                                <?php echo ABAP_UI_TOOL::GetRadioBox("mtst_access", $dd25l['VIEWGRANT'] == ABAP_DB_CONST::DOMAINVALUE_VIEWGRANT_R) ?> &nbsp; 
                                <?php echo ABAP_DB_CONST::DOMAINVALUE_VIEWGRANT_R_DESC ?></td></tr>
                        <tr><td class="field">
                                <?php echo ABAP_UI_TOOL::GetRadioBox("mtst_access", $dd25l['VIEWGRANT'] == ABAP_DB_CONST::DOMAINVALUE_VIEWGRANT_U) ?> &nbsp; 
                                <?php echo ABAP_DB_CONST::DOMAINVALUE_VIEWGRANT_U_DESC ?></td></tr>
                        <tr><td class="field">
                                <?php echo ABAP_UI_TOOL::GetRadioBox("mtst_access", $dd25l['VIEWGRANT'] == ABAP_DB_CONST::DOMAINVALUE_VIEWGRANT_M) ?> &nbsp; 
                                <?php echo ABAP_DB_CONST::DOMAINVALUE_VIEWGRANT_M_DESC ?></td></tr>
                        <tr><td class="field">
                                <?php echo ABAP_UI_TOOL::GetRadioBox("mtst_access", $dd25l['VIEWGRANT'] == ABAP_DB_CONST::DOMAINVALUE_VIEWGRANT_SPACE) ?> &nbsp; 
                                <?php echo ABAP_DB_CONST::DOMAINVALUE_VIEWGRANT_SPACE_DESC ?></td></tr>
                    </tbody>
                </table>
                <table class="content_obj">
                    <?php
                    $dd25l_customauth_desc = ABAP_DB_TABLE_DOMA::DD07T(ABAP_DB_CONST::DOMAIN_DD25L_CUSTOMAUTH, $dd25l['CUSTOMAUTH']);
                    $dd25l_globalflag_desc = ABAP_DB_TABLE_DOMA::DD07T(ABAP_DB_CONST::DOMAIN_DD25L_GLOBALFLAG, $dd25l['GLOBALFLAG']);
                    ?>
                    <tbody>
                        <tr>
                            <td class="content_label"> Delivery Class </td>
                            <td class="field"> <?php echo ABAP_Navigation::GetURLDomainValue(ABAP_DB_CONST::DOMAIN_DD25L_CUSTOMAUTH, $dd25l['CUSTOMAUTH'], $dd25l_customauth_desc) ?> &nbsp;</td>
                            <td> <?php echo $dd25l_customauth_desc ?>&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="content_label"> Data Browser/Table View Maintenance </td>
                            <td class="field"><?php echo ABAP_Navigation::GetURLDomainValue(ABAP_DB_CONST::DOMAIN_DD25L_GLOBALFLAG, $dd25l['GLOBALFLAG'], $dd25l_globalflag_desc) ?>&nbsp;</td>
                            <td><?php echo $dd25l_globalflag_desc ?> &nbsp;</td></tr>
                    </tbody>
                </table><!-- Maintenance Status: End -->

                <!-- Hierarchy -->
                <h4> Hierarchy </h4>
                <table class="content_obj">
                    <tbody>
                        <tr><td class="content_label"> Last changed by/on      </td><td class="field"><?php echo $dd25l['AS4USER'] ?>&nbsp;</td><td> <?php echo $dd25l['AS4DATE'] ?>&nbsp;</td></tr>
                        <tr><td class="content_label"> Software Component      </td><td class="field"><?php echo ABAP_Navigation::GetURLSoftComp($hier->DLVUNIT, $hier->DLVUNIT_T) ?>&nbsp;</td><td> <?php echo $hier->DLVUNIT_T ?>&nbsp;</td></tr>
                        <tr><td class="content_label"> SAP Release Created in  </td><td class="field"><?php echo $hier->CRELEASE ?>&nbsp;</td><td>&nbsp;</td></tr>
                        <tr><td class="content_label"> Application Component   </td><td class="field"><?php echo ABAP_Navigation::GetURLAppComp($hier->FCTR_ID, $hier->POSID, $hier->POSID_T) ?>&nbsp;(<?php echo $hier->FCTR_ID ?>)</td><td> <?php echo $hier->POSID_T ?>&nbsp;</td></tr>
                        <tr><td class="content_label"> Package                 </td><td class="field"><?php echo ABAP_Navigation::GetURLPackage($hier->DEVCLASS, $hier->DEVCLASS_T) ?>&nbsp;</td><td> <?php echo $hier->DEVCLASS_T ?>&nbsp;</td></tr>
                    </tbody>
                </table><!-- Hierarchy: End -->

            </div>
        </div><!-- Content: End -->

        <!-- Footer -->
        <?php include __ROOT__ . '/include/footer.html' ?>

    </body>
</html>
