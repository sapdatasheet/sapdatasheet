<!DOCTYPE html>
<!-- Function Module object. -->
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
$func = ABAP_DB_TABLE_FUNC::TFDIR(strtoupper($ObjID));
if (empty($func['FUNCNAME'])) {
    ABAP_UI_TOOL::Redirect404();
}
$func_desc = ABAP_DB_TABLE_FUNC::TFTIT($func['FUNCNAME']);
$fupararef = ABAP_DB_TABLE_FUNC::FUPARAREF($func['FUNCNAME']);
$ptype = ABAP_DB_TABLE_FUNC::TFDIR_PTYPE($func['FMODE'], $func['UTASK']);

$enlfdir = ABAP_DB_TABLE_FUNC::ENLFDIR($func['FUNCNAME']);
$funcgrp_desc = ABAP_DB_TABLE_FUNC::TLIBT($enlfdir['AREA']);

$include = ABAP_DB_TABLE_FUNC::GET_INCLUDE($enlfdir['AREA'], $func['INCLUDE']);
$progmeta = ABAP_DB_TABLE_PROG::YREPOSRCMETA($include);

$hier = ABAP_DB_TABLE_HIER::Hier(ABAP_DB_CONST::TADIR_PGMID_R3TR, ABAP_OTYPE::FUGR_NAME, $enlfdir['AREA']);
$GLOBALS['TITLE_TEXT'] = 'SAP ABAP ' . ABAP_OTYPE::FUNC_DESC . ' ' . $func['FUNCNAME'];
?>
<html>
    <head>
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" href="/abap.css" type="text/css" />
        <title><?php echo $GLOBALS['TITLE_TEXT'] ?> <?php echo WEBSITE::TITLE ?> </title>
        <meta name="keywords" content="SAP,<?php echo ABAP_OTYPE::FUNC_DESC ?>,<?php echo $func['FUNCNAME'] ?>,<?php echo $func_desc ?>" />
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
                    <tr><td class="left_value"><a href="/abap/func/"><?php echo ABAP_OTYPE::FUNC_DESC ?></a></td></tr>
                    <tr><td class="left_attribute"> Object name </td></tr>
                    <tr><td class="left_value"> <a href="#" title="<?php echo $func_desc ?>"><?php echo $func['FUNCNAME'] ?></a> </td></tr>
                </tbody>
            </table>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Content Navigator -->
            <div class="content_navi">
                <a href="/">Home page</a> &gt;
                <a href="/abap/">ABAP Object</a> &gt;
                <a href="/abap/func/"><?php echo ABAP_OTYPE::FUNC_DESC ?></a> &gt;
                <a href="#"><?php echo $func['FUNCNAME'] ?></a>
            </div>

            <!-- Content Object -->
            <div class="content_obj_title"><span><?php echo $GLOBALS['TITLE_TEXT'] ?></span></div>
            <div class="content_obj">

                <h4> Basic data </h4>
                <table class="content_obj">
                    <tbody>
                        <tr><td class="content_label"> Function Module </td>
                            <td class="field"> <?php echo ABAP_Navigation::GetURLFuncModule($func['FUNCNAME'], $func_desc); ?> </td>
                            <td> <?php echo $func_desc ?> &nbsp;</td>
                        </tr>
                        <tr><td class="content_label"> Function Group </td>
                            <td class="field"> <?php echo $enlfdir['AREA'] ?> &nbsp;</td>
                            <td> <?php echo $funcgrp_desc ?> &nbsp;</td>
                        </tr>
                        <tr><td class="content_label"> Program Name </td>
                            <td class="field"> <?php echo $func['PNAME'] ?> &nbsp;</td>
                            <td> &nbsp;</td>
                        </tr>
                        <tr><td class="content_label"> INCLUDE Name </td>
                            <td class="field"> <?php echo $include ?> &nbsp;</td>
                            <td> &nbsp;</td>
                        </tr>
                    </tbody>
                </table>


                <!-- Parameters: Import, Export, Changing, Tables, Exceptions -->
                <h4> Parameters </h4>
                <table class="alv">
                    <thead>
                        <tr>
                            <th class="alv"> Type </th>
                            <th class="alv"> Parameter Name </th>
                            <th class="alv"> Typing </th>
                            <th class="alv"> Associated Type </th>
                            <th class="alv"> Default value </th>
                            <th class="alv"> Optional </th>
                            <th class="alv"> Pass Value </th>
                            <th class="alv"> Short text </th>
                            <!-- <th class="alv"> Long Text </th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($fupararef_item = mysqli_fetch_array($fupararef)) {
                            // Reverse the TRLE / FALSE value
                            $para_passvalue = ABAP_DB_CONST::FLAG_TRUE;
                            if ($fupararef_item['REFERENCE'] == ABAP_DB_CONST::FLAG_TRUE) {
                                $para_passvalue = ABAP_DB_CONST::FLAG_FALSE;
                            }
                            // Load Parameter text
                            $para_stext = ABAP_DB_TABLE_FUNC::FUNCT($fupararef_item['FUNCNAME'], $fupararef_item['PARAMETER'], $fupararef_item['PARAMTYPE']);
                            ?>
                            <tr>
                                <td class="alv"> <?php echo ABAP_UI_TOOL::GetFunctionModuleParameterType($fupararef_item['PARAMTYPE']) ?> </td>
                                <td class="alv"> <?php echo $fupararef_item['PARAMETER'] ?> </td>
                                <td class="alv"> <?php echo ABAP_UI_TOOL::GetFunctionModuleTyping($fupararef_item['REF_CLASS']) ?> </td>
                                <td class="alv"> <?php echo $fupararef_item['STRUCTURE'] ?> </td>
                                <td class="alv"> <?php echo $fupararef_item['DEFAULTVAL'] ?> </td>
                                <td class="alv"> <?php echo ABAP_UI_TOOL::GetCheckBox("optional", $fupararef_item['OPTIONAL']) ?> </td>
                                <td class="alv"> <?php echo ABAP_UI_TOOL::GetCheckBox("passval", $para_passvalue) ?> </td>
                                <td class="alv"> <?php echo $para_stext ?> </td>
                                <!-- <td class="alv"> Long Text </td> -->
                            </tr>
                        <?php } ?>
                        <tr>
                            <td class="alv"> &nbsp; </td>
                            <td class="alv"> &nbsp; </td>
                            <td class="alv"> &nbsp; </td>
                            <td class="alv"> &nbsp; </td>
                            <td class="alv"> &nbsp; </td>
                            <td class="alv"> &nbsp; </td>
                            <td class="alv"> &nbsp; </td>
                            <td class="alv"> &nbsp; </td>
                            <!-- <td class="alv"> &nbsp; </td> -->
                        </tr>
                    </tbody>
                </table>


                <h4> Processing Type </h4>
                <table class="content_obj">
                    <tbody>
                        <tr><td class="field"> <?php echo ABAP_UI_TOOL::GetRadioBox("pType", $ptype->CHK_NORMAL) ?> Normal Function Module </td>
                            <td> &nbsp; </td>
                        </tr>
                        <tr><td class="field"> <?php echo ABAP_UI_TOOL::GetRadioBox("pType", $ptype->CHK_REMOTE) ?> Remote-Enabled Module </td>
                            <td class="field"> <?php echo ABAP_UI_TOOL::GetCheckBox("BaseXML", $ptype->CHK_BASXML_ENABLED) ?> BaseXML supported </td>
                        </tr>
                        <tr><td class="field" rowspan="4"> <?php echo ABAP_UI_TOOL::GetRadioBox("pType", $ptype->CHK_VERBUCHER) ?> Update Module </td>
                            <td class="field"> <?php echo ABAP_UI_TOOL::GetRadioBox("updateType", $ptype->CHK_UKIND1) ?> Start immediately </td>
                        </tr>
                        <tr><td class="field"> <?php echo ABAP_UI_TOOL::GetRadioBox("updateType", $ptype->CHK_UKIND3) ?> Immediate Start, No Restart </td>
                        </tr>
                        <tr><td class="field"> <?php echo ABAP_UI_TOOL::GetRadioBox("updateType", $ptype->CHK_UKIND2) ?> Start Delayed </td>
                        </tr>
                        <tr><td class="field"> <?php echo ABAP_UI_TOOL::GetRadioBox("updateType", $ptype->CHK_UKIND4) ?> Coll.run </td>
                        </tr>
                        <tr><td class="field"> <?php echo ABAP_UI_TOOL::GetRadioBox("pType", $ptype->CHK_ABAP2JAVA) ?> JAVA Module Callable from ABAP </td>
                            <td> &nbsp; </td>
                        </tr>
                        <tr><td class="field"> <?php echo ABAP_UI_TOOL::GetRadioBox("pType", $ptype->CHK_REMOTE_JAVA) ?> Remote-Enabled JAVA Module </td>
                            <td> &nbsp; </td>
                        </tr>
                        <tr><td class="field"> <?php echo ABAP_UI_TOOL::GetRadioBox("pType", $ptype->CHK_JAVA2ABAP) ?> Module Callable from JAVA </td>
                            <td> &nbsp; </td>
                        </tr>
                    </tbody>
                </table>

                <h4> Hierarchy </h4>
                <table class="content_obj">
                    <tbody>
                        <tr><td class="content_label"> Last changed by/on      </td><td class="field"><?php echo $progmeta['CNAM'] ?>&nbsp;</td><td> <?php echo $progmeta['CDAT'] ?>&nbsp;</td></tr>
                        <tr><td class="content_label"> Software Component      </td><td class="field"><?php echo ABAP_Navigation::GetURLSoftComp($hier->DLVUNIT, $hier->DLVUNIT_T) ?>&nbsp;</td><td> <?php echo $hier->DLVUNIT_T ?>&nbsp;</td></tr>
                        <tr><td class="content_label"> SAP Release Created in  </td><td class="field"><?php echo $hier->CRELEASE ?>&nbsp;</td><td>&nbsp;</td></tr>
                        <tr><td class="content_label"> Application Component   </td><td class="field"><?php echo ABAP_Navigation::GetURLAppComp($hier->FCTR_ID, $hier->POSID, $hier->POSID_T) ?>&nbsp;(<?php echo $hier->FCTR_ID ?>)</td><td> <?php echo $hier->POSID_T ?>&nbsp;</td></tr>
                        <tr><td class="content_label"> Package                 </td><td class="field"><?php echo ABAP_Navigation::GetURLPackage($hier->DEVCLASS, $hier->DEVCLASS_T) ?>&nbsp;</td><td> <?php echo $hier->DEVCLASS_T ?>&nbsp;</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Footer -->
        <?php include __ROOT__ . '/include/footer.html' ?>

    </body>
</html>
