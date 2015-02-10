<!DOCTYPE html>
<!-- Program object. -->
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
$prog = ABAP_DB_TABLE_PROG::YREPOSRCMETA(strtoupper($ObjID));
if (empty($prog['PROGNAME'])) {
    ABAP_UI_TOOL::Redirect404();
}
$prog_desc = ABAP_DB_TABLE_PROG::TRDIRT($prog['PROGNAME']);
$reposrc_subc_desc = ABAP_DB_TABLE_DOMA::DD07T(ABAP_DB_CONST::DOMAIN_REPOSRC_SUBC, $prog['SUBC']);
$reposrc_rstat_desc = ABAP_DB_TABLE_DOMA::DD07T(ABAP_DB_CONST::DOMAIN_REPOSRC_RSTAT, $prog['RSTAT']);
$reposrc_appl_desc = ABAP_DB_TABLE_PROG::YTAPLT($prog['APPL']);
$reposrc_ldbname_desc = ABAP_DB_TABLE_PROG::LDBT($prog['LDBNAME']);

$tcode_list = ABAP_DB_TABLE_TRAN::TSTC_PGMNA($prog['PROGNAME']);
$dynr_list = ABAP_DB_TABLE_PROG::D020S_PROG($prog['PROGNAME']);
$rsmptexts_list = ABAP_DB_TABLE_PROG::RSMPTEXTS($prog['PROGNAME']);

$hier = ABAP_DB_TABLE_HIER::Hier(ABAP_DB_CONST::TADIR_PGMID_R3TR, ABAP_OTYPE::PROG_NAME, $prog['PROGNAME']);
$GLOBALS['TITLE_TEXT'] = 'SAP ABAP ' . ABAP_OTYPE::PROG_DESC . ' ' . $prog['PROGNAME'];
?>
<html>
    <head>
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" href="/abap.css" type="text/css" />
        <title><?php echo $GLOBALS['TITLE_TEXT'] ?> <?php echo WEBSITE::TITLE ?> </title>
        <meta name="keywords" content="SAP,<?php echo ABAP_OTYPE::PROG_DESC ?>,<?php echo $prog['PROGNAME'] ?>,<?php echo $prog_desc ?>" />
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
                    <tr><td class="left_value"><a href="/abap/prog/"><?php echo ABAP_OTYPE::PROG_DESC ?></a></td></tr>
                    <tr><td class="left_attribute"> Object name </td></tr>
                    <tr><td class="left_value"> <a href="#" title="<?php echo $prog_desc ?>"><?php echo $prog['PROGNAME'] ?></a> </td></tr>
                </tbody>
            </table>

            <!-- Google Adsense: left -->
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
                            <td> <?php echo htmlentities($prog_desc) ?> &nbsp;</td>
                        </tr>
                        <tr><td class="content_label"> Program Type </td>
                            <td class="field"> <?php echo ABAP_Navigation::GetURLDomainValue(ABAP_DB_CONST::DOMAIN_REPOSRC_SUBC, $prog['SUBC'], $reposrc_subc_desc); ?> </td>
                            <td> <?php echo htmlentities($reposrc_subc_desc) ?> &nbsp;</td>
                        </tr>
                    </tbody>
                </table>

                <h4> Attributes </h4>
                <table class="content_obj">
                    <tbody>
                        <tr><td class="content_label"> Status </td>
                            <td class="field"> <?php echo ABAP_Navigation::GetURLDomainValue(ABAP_DB_CONST::DOMAIN_REPOSRC_RSTAT, $prog['RSTAT'], $reposrc_rstat_desc); ?> </td>
                            <td> <?php echo htmlentities($reposrc_rstat_desc) ?> &nbsp;</td>
                        </tr>
                        <tr><td class="content_label"> Application </td>
                            <td class="field"> <?php echo $prog['APPL'] ?> </td>
                            <td> <?php echo htmlentities($reposrc_appl_desc) ?> &nbsp;</td>
                        </tr>
                        <tr><td class="content_label"> Authorization Group </td>
                            <td class="field"> <?php echo $prog['SECU'] ?> </td> <!-- TODO: Add link -->
                            <td> &nbsp;</td>
                        </tr>
                        <tr><td class="content_label"> Logical database </td>
                            <td class="field"> <?php echo $prog['LDBNAME'] ?> </td> <!-- TODO: Add link -->
                            <td> <?php echo htmlentities($reposrc_ldbname_desc) ?> &nbsp;</td>
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

                <!-- Function Group -->
                <?php
                if ($prog['SUBC'] == ABAP_DB_CONST::DOMAINVALUE_SUBC_F) {
                    $tfdir_list = ABAP_DB_TABLE_FUNC::TFDIR_PGMNA($prog['PROGNAME']);
                    ?>
                    <h4>Function Group </h4>
                    <table class="alv">
                        <thead>
                            <tr><th class="alv"> Include </th>
                                <th class="alv"> Function Module </th>
                                <th class="alv"> Short Description </th>
                                <th class="alv"> Mode </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($tfdir = mysqli_fetch_array($tfdir_list)) {
                                $tfdir_desc = ABAP_DB_TABLE_FUNC::TFTIT($tfdir['FUNCNAME']);
                                ?>
                                <tr>
                                    <td class="alv"> <?php echo $tfdir['INCLUDE'] ?> &nbsp;</td>
                                    <td class="alv"> <?php echo ABAP_Navigation::GetURLFuncModule($tfdir['FUNCNAME'], $tfdir_desc) ?> &nbsp;</td>
                                    <td class="alv"> <?php echo htmlentities($tfdir_desc) ?> &nbsp;</td>
                                    <td class="alv"> <?php echo $tfdir['FMODE'] ?> &nbsp;</td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td class="alv"> &nbsp; </td>
                                <td class="alv"> &nbsp; </td>
                                <td class="alv"> &nbsp; </td>
                                <td class="alv"> &nbsp; </td>
                            </tr>
                        </tbody>
                    </table>
                <?php } ?>
                <!-- Function Group: End -->

                <!-- Transaction Code -->
                <h4>Transaction Code </h4>
                <?php if (mysqli_num_rows($tcode_list) > 0) { ?>
                    <table class="alv">
                        <caption>Transactions reference to this program</caption>
                        <tr>
                            <th class="alv"> Transaction Code </th>
                            <th class="alv"> Short Description </th>
                        </tr>                        
                        <?php
                        while ($tcode = mysqli_fetch_array($tcode_list)) {
                            $tcode_desc = ABAP_DB_TABLE_TRAN::TSTCT($tcode['TCODE']);
                            ?>
                            <tr><td class="alv"><?php echo ABAP_Navigation::GetURLTransactionCode($tcode['TCODE'], $tcode_desc) ?></td>
                                <td class="alv"><?php echo htmlentities($tcode_desc) ?>&nbsp;</td>
                            </tr>
                        <?php } ?>
                        <tr><td class="alv">&nbsp;</td>
                            <td class="alv">&nbsp;</td>
                        </tr>
                    </table>
                <?php } else { ?>
                    <table class="alv">
                        <caption>There is no transaction reference to this program &nbsp;</caption>
                    </table>
                <?php } ?>
                <!-- Transaction Code: End -->

                <!-- Screen -->
                <?php if (mysqli_num_rows($dynr_list) > 0) { ?>
                    <h4>Screens </h4>
                    <table class="alv">
                        <tr>
                            <th class="alv"> Screen </th>
                            <th class="alv"> Short Description </th>
                        </tr>
                        <?php
                        while ($dynr = mysqli_fetch_array($dynr_list)) {
                            $dynr_desc = ABAP_DB_TABLE_PROG::D020T($prog['PROGNAME'], $dynr['DNUM']);
                            ?>
                            <tr><td class="alv"><?php echo $dynr['DNUM'] ?>&nbsp;</td>
                                <td class="alv"><?php echo htmlentities($dynr_desc) ?>&nbsp;</td>
                            </tr>
                        <?php } ?>
                        <tr><td class="alv">&nbsp;</td>
                            <td class="alv">&nbsp;</td>
                        </tr>
                    </table>
                <?php } ?>
                <!-- Screen: End -->

                <!-- Report Texts  -->
                <?php if (mysqli_num_rows($rsmptexts_list) > 0) { ?>
                    <h4>GUI Status </h4>
                    <table class="alv">
                        <tr>
                            <th class="alv"> GUI Status </th>
                            <th class="alv"> Short Description </th>
                        </tr>
                        <?php
                        foreach ($rsmptexts_list as $rsmptexts) {
                            if ($rsmptexts['OBJ_TYPE'] == ABAP_DB_CONST::DOMAINVALUE_MP_OBJTYPE_C) {
                                ?>
                                <tr><td class="alv"><?php echo $rsmptexts['OBJ_CODE'] ?>&nbsp;</td>
                                    <td class="alv"><?php echo htmlentities($rsmptexts['TEXT']) ?>&nbsp;</td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                        <tr><td class="alv">&nbsp;</td>
                            <td class="alv">&nbsp;</td>
                        </tr>
                    </table>
                    <h4>GUI Title </h4>
                    <table class="alv">
                        <tr>
                            <th class="alv"> GUI Status </th>
                            <th class="alv"> Short Description </th>
                        </tr>
                        <?php
                        foreach ($rsmptexts_list as $rsmptexts) {
                            if ($rsmptexts['OBJ_TYPE'] == ABAP_DB_CONST::DOMAINVALUE_MP_OBJTYPE_T) {
                                ?>
                                <tr><td class="alv"><?php echo $rsmptexts['OBJ_CODE'] ?>&nbsp;</td>
                                    <td class="alv"><?php echo htmlentities($rsmptexts['TEXT']) ?>&nbsp;</td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                        <tr><td class="alv">&nbsp;</td>
                            <td class="alv">&nbsp;</td>
                        </tr>
                    </table>
                <?php } ?>
                <!-- Report Texts: End  -->

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

            <!-- Google Adsense: bottom -->
            <div>
                <?php include $__ROOT__ . '/include/google/adsense-bottom.html' ?>
            </div>
        </div>


        <!-- Footer -->
        <?php include $__ROOT__ . '/include/footer.html' ?>

    </body>
</html>
