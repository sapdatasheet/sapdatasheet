<!DOCTYPE html>
<?php
require_once '../../include/global.php';
require_once '../../include/abap_db.php';
require_once '../../include/abap_ui.php';

$ViewName = filter_input(INPUT_GET, 'id');
if (empty($ViewName)) {
    ABAP_UI_TOOL::Redirect404();
}
$dd25l = ABAP_DB_TABLE_VIEW::DD25L($ViewName);
if (empty($dd25l['VIEWNAME'])) {
    ABAP_UI_TOOL::Redirect404();
}
$dd25l_desc = ABAP_DB_TABLE_VIEW::DD25T($dd25l['VIEWNAME']);

$hier = ABAP_DB_TABLE_HIER::Hier(ABAP_DB_CONST::TADIR_PGMID_R3TR, ABAP_OTYPE::VIEW_NAME, $dd25l['VIEWNAME']);
$GLOBALS['TITLE_TEXT'] = 'SAP ABAP ' . ABAP_OTYPE::VIEW_DESC . ' ' . $dd25l['VIEWNAME'];
?>
<html>
    <head>
        <link rel="stylesheet" href="../../abap.css" type="text/css" >
        <title><?php echo $GLOBALS['TITLE_TEXT'] ?> <?php echo WEBSITE::TITLE ?> </title>
        <meta name="keywords" content="SAP,<?php echo ABAP_OTYPE::VIEW_DESC ?>,<?php echo $dd25l['VIEWNAME']; ?>,<?php echo $dd25l_desc ?>">
        <meta name="description" content="<?php echo WEBSITE::META_DESC; ?>">
        <meta name="author" content="SAP Datasheet">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
    </head>
    <body>

        <!-- Header -->
        <?php require '../../include/header.php' ?>

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
                            <td class="field"> <?php echo  Navigation.GetDomainValueURL(VIEW.VIEWCLASS_DOMA, view.VIEWCLASS, view.VIEWCLASS_T) ?> </td>
                            <td><?php echo  view.VIEWCLASS_T ?>&nbsp;</td>
                        </tr>
                        <tr><td class="content_label"> <?php echo  view.VIEWCLASS_T ?></td><td class="field"> <?php echo  Navigation.GetDomaURL(view.VIEWNAME) ?> </td><td>&nbsp;</td></tr>
                        <tr><td class="content_label"> Short Description     </td><td class="field"> <?php echo  view.DDTEXT ?> &nbsp;</td><td>&nbsp;</td></tr>
                    </tbody>
                </table>

                <!-- Attributes -->
                <?php  if (VIEWCLASS.VALUE_A == view.VIEWCLASS) { ?>
                <table class="content_obj">
                    <tbody>
                        <tr><td class="content_label">Appending view</td><td class="field"><?php echo  Navigation.GetViewURL(view.ATTR.ROOTTAB) ?>&nbsp;</td></tr>
                        <!-- TODO: <tr><td>Switch</td><td>????&nbsp;</td></tr> -->
                    </tbody>
                </table>
                <?php  }             ?>
                <?php  if (!Constant.IsInitial(view.ATTR.UDENTITY)) { ?>
                <table  class="content_obj">
                    <tbody>
                        <tr><td class="content_label">Entity Type</td><td class="field"><?php echo  Navigation.GetTablURL("DM02L", view.ATTR.UDENTITY) ?>&nbsp;</td></tr>
                        <tr><td class="content_label">Short text </td><td class="field"><?php echo  view.ATTR.UDENTITY_T ?></td></tr>
                    </tbody>
                </table>
                <?php  } ?>

                <!-- Table / Join Conditions -->
                <h4>Table / Join Conditions </h4>
                <table  class="content_obj">
                    <tbody>
                        <tr><td valign="top">
                                <table class="alv">
                                    <caption>Tables</caption>
                                    <thead>
                                        <tr><th class="alv"> # </th><th class="alv"> Table </th></tr>
                                    </thead>
                                    <tbody>
                                        <?php  for (VIEW.Table t : view.TABL) { ?>
                                        <tr>
                                            <td class="alv"><?php echo  t.TABPOS ?> </td>
                                            <td class="alv"><?php echo  Navigation.GetTablURL(t.TABNAME) ?> </td>
                                        </tr>
                                        <?php  } ?>
                                    </tbody>
                                </table>
                            </td>
                            <td valign="top">
                                <table  class="alv">
                                    <caption>Join conditions</caption>
                                    <thead>
                                        <tr><th class="alv">#</th><th class="alv">Table</th><th class="alv">Field name</th><th class="alv">=</th><th class="alv">Table</th><th class="alv">Field name</th><th class="alv">Join</th><th class="alv">#</th></tr>
                                    </thead>
                                    <tbody>
                                        <?php  for (VIEW.JoinCondition jc : view.JNCD) { ?>
                                        <tr>
                                            <td class="alv"><?php echo  jc.LPOSITION ?> </td>
                                            <td class="alv"><?php echo  Navigation.GetTablURL(jc.LTAB) ?> </td>
                                            <td class="alv"><?php echo  jc.LFIELD ?> </td>
                                            <td class="alv"><?php echo  Navigation.GetDomainValueURL(VIEW.JoinCondition.OPERATOR_DOMA, jc.LOPERATOR) ?> </td>
                                            <td class="alv"><?php echo  Navigation.GetTablURL(jc.RTAB) ?> </td>
                                            <td class="alv"><?php echo  jc.RFIELD ?> </td>
                                            <td class="alv"><?php echo  Navigation.GetDomainValueURL(VIEW.SelectionCondition.AND_OR_DOMA, jc.RAND_OR) ?> </td>
                                            <td class="alv"><?php echo  jc.RPOSITION ?> </td>
                                        </tr>
                                        <?php  } ?>
                                        <tr><td class="alv">&nbsp;</td><td class="alv">&nbsp;</td><td class="alv">&nbsp;</td><td class="alv">&nbsp;</td><td class="alv">&nbsp;</td><td class="alv">&nbsp;</td><td class="alv">&nbsp;</td><td class="alv">&nbsp;</td></tr>
                                    </tbody>
                                </table>
                            </td></tr>
                    </tbody>
                </table><!-- Table / Join Conditions: End -->

                <!-- View Fields -->
                <h4>View Fields </h4>
                <table class="content_obj">
                    <tbody>
                        <tr><td class="content_label">Basis Table</td><td class="field"><?php echo  Navigation.GetTablURL(view.ATTR.ROOTTAB) ?>&nbsp;</td></tr>
                    </tbody>
                </table>
                <table class="alv">
                    <thead>
                        <tr>
                            <th class="alv">#</th>
                            <th class="alv">View field</th>
                            <th class="alv">Table</th>
                            <th class="alv">Field</th>
                            <th class="alv">Flag</th>
                            <th class="alv">Key</th>
                            <th class="alv">Data element</th>
                            <th class="alv">Mod</th>
                            <th class="alv">Data Type</th>
                            <th class="alv">Length</th>
                            <th class="alv">Short Description</th>
                            <!-- TODO: <th class="alv">Switch</th></tr> -->
                    </thead>
                    <tbody>
                        <?php  for (VIEW.Field f : view.FELD) { ?>
                        <tr>
                            <td class="alv"><?php echo  f.OBJPOS ?> </td>
                            <td class="alv"><?php echo  f.VIEWFIELD ?> </td>
                            <td class="alv"><?php echo  Navigation.GetTablURL(f.TABNAME) ?> </td>
                            <td class="alv"><?php echo  f.FIELDNAME ?> </td>
                            <td class="alv"><?php echo  Navigation.GetDomainValueURL(VIEW.Field.RDONLY_DOMA, f.RDONLY) ?> </td>
                            <td class="alv"><?php echo  Navigation.getCheckBox("FELD_KEY_" + f.OBJPOS, f.KEYFLAG) ?> </td>
                            <td class="alv"><?php echo  Navigation.GetDtelURL(f.ROLLNAME) ?> </td>
                            <td class="alv"><?php echo  Navigation.getCheckBox("FELD_MOD_" + f.OBJPOS, f.ROLLCHANGE) ?> </td>
                            <td class="alv"><?php echo  Navigation.GetDomainValueURL(VIEW.Field.DATATYPE_DOMA, f.DATATYPE) ?> </td>
                            <td class="alv" align="right"><?php echo  f.LENG ?>&nbsp; </td>
                            <td class="alv"><?php echo  f.ROLLNAME_T ?> </td>
                            <!-- TODO: <td class="alv">f.SWITCH_ID </td> -->
                        </tr>
                        <?php  } ?>
                    </tbody>
                </table><!-- View Fields: End -->

                <!-- Selection Conditions -->
                <?php  if (!view.STCD.isEmpty()) {   ?>
                <h4>Selection Conditions </h4>
                <table class="alv">
                    <thead>
                        <tr>
                            <th class="alv">#</th>
                            <th class="alv">Table</th>
                            <th class="alv">Field name</th>
                            <th class="alv">Operator</th>
                            <th class="alv">Comparison Value</th>
                            <th class="alv">AND/OR</th>
                    </thead>
                    <tbody>
                        <?php  for (VIEW.SelectionCondition sc : view.STCD) { ?>
                        <tr>
                            <td class="alv"><?php echo  sc.POSITION ?> </td>
                            <td class="alv"><?php echo  Navigation.GetTablURL(sc.TABNAME) ?> </td>
                            <td class="alv"><?php echo  sc.FIELDNAME ?> </td>
                            <td class="alv"><?php echo  Navigation.GetDomainValueURL(VIEW.JoinCondition.OPERATOR_DOMA, sc.OPERATOR) ?> </td>
                            <td class="alv"><?php echo  sc.CONSTANTS ?> </td>
                            <td class="alv"><?php echo  Navigation.GetDomainValueURL(VIEW.SelectionCondition.AND_OR_DOMA, sc.AND_OR) ?> </td>
                        </tr>
                        <?php  } ?>
                    </tbody>
                </table>
                <?php  }   ?><!-- Selection Conditions: End -->

                <!-- Maintenance Status -->
                <h4>Maintenance Status </h4>
                <table class="content_obj">
                    <caption>Access</caption>
                    <tbody>
                        <?php  for (DomainValue.TypeString v : VIEWGRANT.VALUES) { ?>
                        <tr><td class="field"><?php echo  Navigation.getRadioButton("mtst_access", v.value.equalsIgnoreCase(view.MTST.VIEWGRANT)) ?> &nbsp; <?php echo  v.desc ?></td></tr>
                        <?php  } ?>
                    </tbody>
                </table>
                <table class="content_obj">
                    <tbody>
                        <tr>
                            <td class="content_label"> Delivery Class </td>
                            <td class="field"> <?php echo  Navigation.GetDomainValueURL(VIEW.MaintStatus.CUSTOMAUTH_DOMA, view.MTST.CUSTOMAUTH) ?> &nbsp;</td>
                            <td> <?php echo  view.MTST.CUSTOMAUTH_T ?>&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="content_label"> Data Browser/Table View Maintenance </td>
                            <td class="field"><?php echo  Navigation.GetDomainValueURL(VIEW.MaintStatus.GLOBALFLAG_DOMA, view.MTST.GLOBALFLAG) ?>&nbsp;</td>
                            <td><?php echo  view.MTST.GLOBALFLAG_T ?> &nbsp;</td></tr>
                    </tbody>
                </table><!-- Maintenance Status: End -->

                <!-- Hierarchy -->
                <h4> Hierarchy </h4>
                <table class="content_obj">
                    <tbody>
                        <tr><td class="content_label"> Last changed by/on      </td><td class="field"><?php echo  view.ATTR.AS4USER ?>&nbsp;</td><td> <?php echo  view.ATTR.AS4DATE.toText() ?>&nbsp;</td></tr>
                        <tr><td class="content_label"> Software Component      </td><td class="field"><?php echo  Navigation.GetSoftCompURL(view.HIER.DLVUNIT, view.HIER.DLVUNIT_T) ?>&nbsp;</td><td> <?php echo  view.HIER.DLVUNIT_T ?>&nbsp;</td></tr>
                        <tr><td class="content_label"> SAP Release Created in  </td><td class="field"><?php echo  view.HIER.CRELEASE ?>&nbsp;</td><td>&nbsp;</td></tr>
                        <tr><td class="content_label"> Application Component ID</td><td class="field"><?php echo  Navigation.GetAppCompURL(view.HIER.FCTR_ID, view.HIER.POSID, view.HIER.POSID_T) ?>&nbsp;</td><td> <?php echo  view.HIER.POSID_T ?>&nbsp;</td></tr>
                        <tr><td class="content_label"> Application Component   </td><td class="field"><?php echo  Navigation.GetAppCompURL(view.HIER.FCTR_ID, view.HIER.FCTR_ID, view.HIER.POSID_T) ?>&nbsp;</td><td>&nbsp;</td></tr>
                        <tr><td class="content_label"> Package                 </td><td class="field"><?php echo  Navigation.GetPackageURL(view.HIER.DEVCLASS, view.HIER.DEVCLASS_T) ?>&nbsp;</td><td> <?php echo  view.HIER.DEVCLASS_T ?>&nbsp;</td></tr>
                    </tbody>
                </table><!-- Hierarchy: End -->

            </div>
        </div><!-- Content: End -->

        <!-- Footer -->
        <?php include '../../include/footer.html' ?>

    </body>
</html>
