<!DOCTYPE html>
<!-- Program object. -->
<?php
require_once '../../include/global.php';
require_once '../../include/abap_db.php';
require_once '../../include/abap_ui.php';

$progname = filter_input(INPUT_GET, 'id');
if (empty($progname)) {
    ABAP_UI_TOOL::Redirect404();
}
$prog = ABAP_DB_TABLE_PROG::YREPOSRCMETA($progname);
if (empty($prog['PROGNAME'])) {
    ABAP_UI_TOOL::Redirect404();
}
$prog_desc = ABAP_DB_TABLE_PROG::TRDIRT($prog['PROGNAME']);
$reposrc_subc_desc = ABAP_DB_TABLE_DOMA::DD07T(ABAP_DB_CONST::DOMAIN_REPOSRC_SUBC, $prog['SUBC']);
$reposrc_rstat_desc = ABAP_DB_TABLE_DOMA::DD07T(ABAP_DB_CONST::DOMAIN_REPOSRC_RSTAT, $prog['RSTAT']);
$reposrc_appl_desc = ABAP_DB_TABLE_PROG::YTAPLT($prog['APPL']);
$reposrc_ldbname_desc = ABAP_DB_TABLE_PROG::LDBT($prog['LDBNAME']);

$hier = ABAP_DB_TABLE_HIER::Hier(ABAP_DB_CONST::TADIR_PGMID_R3TR, ABAP_OTYPE::PROG_NAME, $prog['PROGNAME']);
$GLOBALS['TITLE_TEXT'] = 'SAP ABAP ' . ABAP_OTYPE::PROG_DESC . ' ' . $prog['PROGNAME'];
?>
<html>
    <head>
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" href="../../abap.css" type="text/css" />
        <title><?php echo $GLOBALS['TITLE_TEXT'] ?> <?php echo WEBSITE::TITLE ?> </title>
        <meta name="keywords" content="SAP,<?php echo ABAP_OTYPE::PROG_DESC ?>,<?php echo $prog['PROGNAME'] ?>,<?php echo $prog_desc ?>" />
        <meta name="description" content="<?php echo WEBSITE::META_DESC; ?>" />
        <meta name="author" content="SAP Datasheet" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
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
                    <tr><td class="left_value"><a href="/abap/prog/"><?php echo ABAP_OTYPE::PROG_DESC ?></a></td></tr>
                    <tr><td class="left_attribute"> Object name </td></tr>
                    <tr><td class="left_value"> <a href="#" title="<?php echo $prog_desc ?>"><?php echo $prog['PROGNAME'] ?></a> </td></tr>
                </tbody>
            </table>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Content Navigator -->
            <div class="content_navi">
                <a href="/">Home page</a> &gt; 
                <a href="/abap/">ABAP Object</a> &gt; 
                <a href="/abap/prog/"><?php echo ABAP_OTYPE::PROG_DESC ?></a> &gt; 
                <a href="#"><?php echo $prog['PROGNAME'] ?></a>
            </div>

            <!-- Content Object -->
            <div class="content_obj_title"><span><?php echo $GLOBALS['TITLE_TEXT'] ?></span></div>
            <div class="content_obj">

                <h4> Basic data </h4>
                <table class="content_obj">
                    <tbody>
                        <tr><td class="content_label"> Program </td>
                            <td class="field"> <?php echo ABAP_Navigation::GetURLProgram($prog['PROGNAME'], $prog_desc); ?> </td>
                            <td> <?php echo $prog_desc ?> &nbsp;</td>
                        </tr>
                        <tr><td class="content_label"> Program Type </td>
                            <td class="field"> <?php echo ABAP_Navigation::GetURLDomainValue(ABAP_DB_CONST::DOMAIN_REPOSRC_SUBC, $prog['SUBC'], $reposrc_subc_desc); ?> </td>
                            <td> <?php echo $reposrc_subc_desc ?> &nbsp;</td>
                        </tr>
                    </tbody>
                </table>

                <h4> Attributes </h4>
                <table class="content_obj">
                    <tbody>
                        <tr><td class="content_label"> Status </td>
                            <td class="field"> <?php echo ABAP_Navigation::GetURLDomainValue(ABAP_DB_CONST::DOMAIN_REPOSRC_RSTAT, $prog['RSTAT'], $reposrc_rstat_desc); ?> </td>
                            <td> <?php echo $reposrc_rstat_desc ?> &nbsp;</td>
                        </tr>
                        <tr><td class="content_label"> Application </td>
                            <td class="field"> <?php echo $prog['APPL'] ?> </td>
                            <td> <?php echo $reposrc_appl_desc ?> &nbsp;</td>
                        </tr>
                        <tr><td class="content_label"> Authorization Group </td>
                            <td class="field"> <?php echo $prog['SECU'] ?> </td> <!-- TODO: Add link -->
                            <td> &nbsp;</td>
                        </tr>
                        <tr><td class="content_label"> Logical database </td>
                            <td class="field"> <?php echo $prog['LDBNAME'] ?> </td> <!-- TODO: Add link -->
                            <td> <?php echo $reposrc_ldbname_desc ?> &nbsp;</td>
                        </tr>
                        <tr><td class="content_label">Selection screen </td>
                            <td class="field"> <?php echo $prog['TYPE'] ?> </td>
                            <td> &nbsp;</td>
                        </tr>
                        <tr>
                            <td class="content_label"> <?php echo ABAP_UI_TOOL::GetCheckBox("PROG", $prog['EDTX']) ?> Editor lock </td>
                            <td class="content_label"> <?php echo ABAP_UI_TOOL::GetCheckBox("PROG", $prog['FIXPT']) ?> Fixed point arithmetic </td>
                            <td> &nbsp;</td>
                        </tr>
                        <tr>
                            <td class="content_label"> <?php echo ABAP_UI_TOOL::GetCheckBox("PROG", $prog['UCCHECK']) ?> Unicode checks active</td>
                            <td class="content_label"> <?php echo ABAP_UI_TOOL::GetCheckBox("PROG", $prog['SSET']) ?> Start using variant </td>
                            <td> &nbsp;</td>
                        </tr>
                    </tbody>
                </table><!-- Attributes: End -->

                <h4>Transaction Code </h4>
                <h4>Function Group </h4>
                <h4>Screens </h4>
                <h4>GUI Status </h4>
                <h4>GUI Title </h4>

                
                <h4> Hierarchy </h4>
                <table class="content_obj">
                    <tbody>
                        <tr><td class="content_label"> Last changed by/on      </td><td class="field"><?php echo $prog['CNAM'] ?>&nbsp;</td><td> <?php echo $prog['CDAT'] ?>&nbsp;</td></tr>
                        <tr><td class="content_label"> Software Component      </td><td class="field"><?php echo ABAP_Navigation::GetURLSoftComp($hier->DLVUNIT, $hier->DLVUNIT_T) ?>&nbsp;</td><td> <?php echo $hier->DLVUNIT_T ?>&nbsp;</td></tr>
                        <tr><td class="content_label"> SAP Release Created in  </td><td class="field"><?php echo $hier->CRELEASE ?>&nbsp;</td><td>&nbsp;</td></tr>
                        <tr><td class="content_label"> Application Component   </td><td class="field"><?php echo ABAP_Navigation::GetURLAppComp($hier->FCTR_ID, $hier->POSID, $hier->POSID_T) ?>&nbsp;(<?php echo $hier->FCTR_ID ?>)</td><td> <?php echo $hier->POSID_T ?>&nbsp;</td></tr>
                        <tr><td class="content_label"> Package                 </td><td class="field"><?php echo ABAP_Navigation::GetURLPackage($hier->DEVCLASS, $hier->DEVCLASS_T) ?>&nbsp;</td><td> <?php echo $hier->DEVCLASS_T ?>&nbsp;</td></tr>
                    </tbody>
                </table>
            </div>
        </div>


        <!-- Footer -->
        <?php include '../../include/footer.html' ?>
    </body>
</html>
