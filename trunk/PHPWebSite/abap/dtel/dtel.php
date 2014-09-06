<!DOCTYPE html>
<!-- DDIC Data Element object. -->
<?php
require_once '../../include/global.php';
require_once '../../include/abap_db.php';
require_once '../../include/abap_ui.php';

$DataElement = filter_input(INPUT_GET, 'id');
if (empty($DataElement)) {
    ABAP_UI_TOOL::Redirect404();
}
$dtel = ABAP_DB_TABLE_DTEL::DD04L(strtoupper($DataElement));
if (empty($dtel['ROLLNAME'])) {
    ABAP_UI_TOOL::Redirect404();
}
$dtel_desc = ABAP_DB_TABLE_DTEL::DD04T($dtel['ROLLNAME']);
$dtel_label = ABAP_DB_TABLE_DTEL::DD04T_ALL($dtel['ROLLNAME']);
$dtel_refkind_desc = ABAP_DB_TABLE_DOMA::DD07T(ABAP_DB_CONST::DOMAIN_DD04L_REFKIND, $dtel['REFKIND']);
$dtel_reftype_desc = ABAP_DB_TABLE_DOMA::DD07T(ABAP_DB_CONST::DOMAIN_DD04L_REFTYPE, $dtel['REFTYPE']);
$dtel_datatype_desc = ABAP_DB_TABLE_DOMA::DD07T(ABAP_DB_CONST::DOMAIN_DATATYPE, $dtel['DATATYPE']);
$hier = ABAP_DB_TABLE_HIER::Hier(ABAP_DB_CONST::TADIR_PGMID_R3TR, ABAP_OTYPE::DTEL_NAME, $dtel['ROLLNAME']);
$GLOBALS['TITLE_TEXT'] = 'SAP ABAP ' . ABAP_OTYPE::DTEL_DESC . ' ' . $dtel['ROLLNAME'];
?>
<html>
    <head>
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" href="../../abap.css" type="text/css" />
        <title><?php echo $GLOBALS['TITLE_TEXT'] ?> <?php echo WEBSITE::TITLE ?> </title>
        <meta name="keywords" content="SAP,<?php echo ABAP_OTYPE::DTEL_DESC ?>,<?php echo $dtel['ROLLNAME'] ?>,<?php echo $dtel_desc ?>" />
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
                    <tr><td class="left_value"><a href="/abap/dtel/"><?php echo ABAP_OTYPE::DTEL_DESC ?></a></td></tr>
                    <tr><td class="left_attribute"> Object name </td></tr>
                    <tr><td class="left_value"> <a href="#" title="<?php echo  $dtel_desc ?>"><?php echo $dtel['ROLLNAME'] ?></a> </td></tr>
                </tbody>
            </table>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Content Navigator -->
            <div class="content_navi">
                <a href="/">Home page</a> &gt; 
                <a href="/abap/">ABAP Object</a> &gt; 
                <a href="/abap/dtel/"><?php echo ABAP_OTYPE::DTEL_DESC ?></a> &gt; 
                <a href="#"><?php echo $dtel['ROLLNAME'] ?></a>
            </div>

            <!-- Content Object -->
            <div class="content_obj_title"><span><?php echo $GLOBALS['TITLE_TEXT'] ?></span></div>
            <div class="content_obj">
                <h4> Basic data </h4>
                <table class="content_obj">
                    <tbody>
                        <tr><td class="content_label"> Data Element      </td><td class="field"> <?php echo ABAP_Navigation::GetURLDtel($dtel['ROLLNAME'], $dtel_desc) ?> </td></tr>
                        <tr><td class="content_label"> Short Description </td><td class="field"> <?php echo $dtel_desc ?> &nbsp;</td></tr>
                    </tbody>
                </table>

                <h4> Data Type </h4>
                <table class="content_obj">
                    <tbody>
                        <tr><td class="content_label"> Category of Dictionary Type </td>
                            <td class="field"> <?php echo ABAP_Navigation::GetURLDomainValue(ABAP_DB_CONST::DOMAIN_DD04L_REFKIND, $dtel['REFKIND'], $dtel_refkind_desc); ?> &nbsp;</td>
                            <td><?php echo $dtel_refkind_desc ?></td></tr>
                        <tr><td class="content_label"> Type of Object Referenced  </td>
                            <td class="field"> <?php echo ABAP_Navigation::GetURLDomainValue(ABAP_DB_CONST::DOMAIN_DD04L_REFTYPE, $dtel['REFTYPE'], $dtel_reftype_desc); ?> &nbsp;</td>
                            <td><?php echo  $dtel_reftype_desc ?></td></tr>
                        <tr><td class="content_label">Domain </td>
                            <td class="field"> <?php echo ABAP_Navigation::GetURLDomain($dtel['DOMNAME'], ''); ?> &nbsp;</td>
                            <td>&nbsp;</td></tr>
                        <tr><td class="content_label">Name of Reference Type </td>
                            <td class="field"> <?php echo $dtel['REFTYPNAME'] ?> &nbsp;</td>
                            <td>&nbsp;</td></tr>
                        <tr><td class="content_label">Data Type </td>
                            <td class="field"> <?php echo ABAP_Navigation::GetURLDomainValue(ABAP_DB_CONST::DOMAIN_DATATYPE, $dtel['DATATYPE'], $dtel_datatype_desc) ?> &nbsp;</td>
                            <td><?php echo $dtel_datatype_desc ?>&nbsp;</td></tr>
                        <tr><td class="content_label">Length </td>
                            <td class="field" align="right"> <?php echo intval($dtel['LENG']) ?> &nbsp;</td>
                            <td>&nbsp;</td></tr>
                        <tr><td class="content_label">Decimal Places </td>
                            <td class="field" align="right"> <?php echo intval($dtel['DECIMALS']) ?> &nbsp;</td>
                            <td>&nbsp;</td></tr>
                        <tr><td class="content_label">Output Length </td>
                            <td class="field" align="right"> <?php echo intval($dtel['OUTPUTLEN']) ?> &nbsp;</td>
                            <td>&nbsp;</td></tr>
                        <tr><td class="content_label">Value Table </td>
                            <td class="field" align="right"> <?php echo ABAP_Navigation::GetURLTable($dtel['ENTITYTAB'], '') ?> &nbsp;</td>
                            <td>&nbsp;</td></tr>
                    </tbody>
                </table>

                <h4> Further Characteristics </h4>
                <table class="content_obj">
                    <tbody>
                        <tr><td class="content_label"> Search Help: Name       </td><td class="field"> <?php echo $dtel['SHLPNAME'] ?> &nbsp;</td><td>&nbsp;</td></tr>
                        <tr><td class="content_label"> Search Help: Parameters </td><td class="field"> <?php echo $dtel['SHLPFIELD'] ?>&nbsp;</td><td>&nbsp;</td></tr>
                        <tr><td class="content_label"> Parameter ID </td><td class="field"> <?php echo $dtel['MEMORYID'] ?>&nbsp;</td><td>&nbsp;</td></tr>
                        <tr><td class="content_label"> Default Component name </td><td class="field"> <?php echo $dtel['DEFFDNAME'] ?>&nbsp;</td><td>&nbsp;</td></tr>
                        <tr><td class="content_label"> Change document  </td><td> <?php echo ABAP_UI_TOOL::GetCheckBox('LOGFLAG', $dtel['LOGFLAG']) ?>&nbsp;</td><td>&nbsp;</td></tr>
                        <tr><td class="content_label"> No Input History </td><td> <?php echo ABAP_UI_TOOL::GetCheckBox("NOHISTORY",  $dtel['NOHISTORY']) ?>&nbsp;</td><td>&nbsp;</td></tr>
                        <tr><td class="content_label"> Basic direction is set to LTR  </td><td> <?php echo  ABAP_UI_TOOL::GetCheckBox("LTR", $dtel['LTRFLDDIS']) ?>&nbsp;</td><td>&nbsp;</td></tr>
                        <tr><td class="content_label"> No BIDI Filtering </td><td> <?php echo ABAP_UI_TOOL::GetCheckBox("BI", $dtel['BIDICTRLC']) ?>&nbsp;</td><td>&nbsp;</td></tr>
                    </tbody>
                </table>

                <h4> Field Label </h4>
                <table class="content_obj">
                    <tbody>
                        <tr><td> &nbsp; </td><td>Length &nbsp;</td><td>Field Label &nbsp;</td></tr>
                        <tr><td class="content_label"> Short   </td><td class="field" align="right"><?php echo intval($dtel['SCRLEN1']) ?>&nbsp;</td><td class="field"><?php echo $dtel_label['SCRTEXT_S'] ?>&nbsp;</td></tr>
                        <tr><td class="content_label"> Medium  </td><td class="field" align="right"><?php echo intval($dtel['SCRLEN2']) ?>&nbsp;</td><td class="field"><?php echo $dtel_label['SCRTEXT_M'] ?>&nbsp;</td></tr>
                        <tr><td class="content_label"> Long    </td><td class="field" align="right"><?php echo intval($dtel['SCRLEN3']) ?>&nbsp;</td><td class="field"><?php echo $dtel_label['SCRTEXT_L'] ?>&nbsp;</td></tr>
                        <tr><td class="content_label"> Heading </td><td class="field" align="right"><?php echo intval($dtel['HEADLEN'])  ?>&nbsp;</td><td class="field"><?php echo $dtel_label['REPTEXT'] ?>&nbsp;</td></tr>
                    </tbody>
                </table>

                <h4> Hierarchy </h4>
                <table class="content_obj">
                    <tbody>
                        <tr><td class="content_label"> Last changed by/on      </td><td class="field"><?php echo $dtel['AS4USER'] ?>&nbsp;</td><td> <?php echo  $dtel['AS4DATE'] ?>&nbsp;</td></tr>
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
