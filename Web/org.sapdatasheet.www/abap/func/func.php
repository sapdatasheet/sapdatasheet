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
$func = ABAP_DB_TABLE_FUNC::TFDIR(strtoupper($ObjID));
if (empty($func['FUNCNAME'])) {
    ABAP_UI_TOOL::Redirect404();
}
$func_desc = ABAP_DB_TABLE_FUNC::TFTIT($func['FUNCNAME']);
$fupararef = ABAP_DB_TABLE_FUNC::FUPARAREF($func['FUNCNAME']);
$ptype = ABAP_DB_TABLE_FUNC::TFDIR_PTYPE($func['FMODE'], $func['UTASK']);

$enlfdir = ABAP_DB_TABLE_FUNC::ENLFDIR($func['FUNCNAME']);
$funcgrp_desc = ABAP_DB_TABLE_FUNC::TLIBT($enlfdir['AREA']);
$prog_desc = htmlentities(ABAP_DB_TABLE_PROG::TRDIRT($func['PNAME']));

$include = ABAP_DB_TABLE_FUNC::GET_INCLUDE($enlfdir['AREA'], $func['INCLUDE']);
$progmeta = ABAP_DB_TABLE_PROG::YREPOSRCMETA($include);

$wul_counter_list = ABAPANA_DB_TABLE::WULCOUNTER_List(GLOBAL_ABAP_OTYPE::FUNC_NAME, $func['FUNCNAME']);
$wil_enabled = TRUE;
$wil_counter_list = ABAPANA_DB_TABLE::WILCOUNTER_List(GLOBAL_ABAP_OTYPE::FUNC_NAME, $func['FUNCNAME']);

$hier = ABAP_DB_TABLE_HIER::Hier(ABAP_DB_TABLE_HIER::TADIR_PGMID_R3TR, GLOBAL_ABAP_OTYPE::FUGR_NAME, $enlfdir['AREA']);
$GLOBALS['TITLE_TEXT'] = ABAP_UI_TOOL::GetObjectTitle(GLOBAL_ABAP_OTYPE::FUNC_NAME, $func['FUNCNAME']);

$json_ld = new \OrgSchema\Thing();
$json_ld->name = $func['FUNCNAME'];
$json_ld->alternateName = $func_desc;
$json_ld->description = $GLOBALS['TITLE_TEXT'];
$json_ld->image = GLOBAL_ABAP_ICON::getIconURL(GLOBAL_ABAP_ICON::OTYPE_FUNC, TRUE);
$json_ld->url = ABAP_UI_DS_Navigation::GetObjectURL(GLOBAL_ABAP_OTYPE::FUNC_NAME, $json_ld->name);
?>
<!DOCTYPE html>
<!-- Function Module object. -->
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <title><?php echo $GLOBALS['TITLE_TEXT'] . GLOBAL_WEBSITE_SAPDS::TITLE ?> </title>
        <meta name="author" content="SAP Datasheet" />
        <meta name="description" content="<?php echo GLOBAL_WEBSITE_SAPDS::META_DESC; ?>" />
        <meta name="keywords" content="SAP,<?php echo GLOBAL_ABAP_OTYPE::FUNC_DESC ?>,<?php echo $func['FUNCNAME'] ?>,<?php echo $func_desc ?>" />

        <link rel="stylesheet" type="text/css"  href="/3rdparty/bootstrap/css/bootstrap.min.css"/>
        <link rel="stylesheet" type="text/css"  href="/sapdatasheet.css"/>

        <script type="application/ld+json"><?php echo $json_ld->toJson() ?></script>
    </head>
    <body>

        <!-- Header -->
        <?php require $__ROOT__ . '/include/header.php' ?>

        <div class="container-fluid">
            <div class="row">
                <div  class="col-xl-2 col-lg-2 col-md-3  col-sm-3    bd-sidebar bg-light">
                    <!-- Left Side bar -->
                    <h6 class="pt-4">Object Hierarchy</h6>
                    <table>
                        <tbody>
                            <tr><td><small><strong>Software Component</strong></small></td></tr>
                            <tr><td><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeCVERS() ?>
                                    <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Cvers($hier->DLVUNIT, $hier->DLVUNIT_T) ?>&nbsp;</td></tr>
                            <tr><td><small><strong> Application Component ID</strong></small></td></tr>
                            <tr><td><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeBMFR() ?>
                                    <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Bmfr($hier->FCTR_ID, $hier->POSID, $hier->POSID_T) ?>&nbsp;</td></tr>
                            <tr><td><small><strong> Package </strong></small></td></tr>
                            <tr><td><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeDEVC() ?>
                                    <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Devc($hier->DEVCLASS, $hier->DEVCLASS_T) ?></td></tr>
                            <tr><td><small><strong> Object type </strong></small></td></tr>
                            <tr><td><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeFUNC() ?>
                                    <a href="/abap/func/"><?php echo GLOBAL_ABAP_OTYPE::FUNC_DESC ?></a></td></tr>
                            <tr><td><small><strong>Object name </strong></small></td></tr>
                            <tr><td><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeFUNC() ?>
                                    <a href="#" title="<?php echo $func_desc ?>"><?php echo $func['FUNCNAME'] ?></a> </td></tr>
                        </tbody>
                    </table>

                    <?php require $__ROOT__ . '/include/abap_oname_wul.php' ?>
                </div>

                <main class="col-xl-8 col-lg-8 col-md-6  col-sm-9    col-12 bd-content" role="main">
                    <nav class="pt-3" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/"><?php echo GLOBAL_ABAP_ICON::getIcon4Home() ?> Home</a></li>
                            <li class="breadcrumb-item"><a href="/abap/">ABAP Object Types</a></li>
                            <li class="breadcrumb-item"><a href="/abap/func/"><?php echo GLOBAL_ABAP_OTYPE::FUNC_DESC ?></a></li>
                            <li class="breadcrumb-item active"><a href="#"><?php echo $func['FUNCNAME'] ?></a></li>
                        </ol>
                    </nav>

                    <div class="card shadow">
                        <div class="card-header sapds-card-header"><?php echo $GLOBALS['TITLE_TEXT'] ?></div>
                        <div class="card-body table-responsive sapds-card-body">
                            <div class="align-content-start"><?php include $__WS_ROOT__ . '/common-php/google/adsense-content-top.html' ?></div>
                            <?php require $__ROOT__ . '/include/abap_desc_language.php' ?>
                            <?php require $__ROOT__ . '/include/abap_oname_hier.php' ?>

                            <h5 class="pt-4"><?php echo GLOBAL_ABAP_ICON::getIcon4Header() ?> Basic Data </h5>
                            <table>
                                <tbody>
                                    <tr><td class="sapds-gui-label"> Function Module </td>
                                        <td class="sapds-gui-field"> <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Func($func['FUNCNAME'], $func_desc); ?> </td>
                                        <td> <?php echo htmlentities($func_desc) ?> &nbsp;</td>
                                    </tr>
                                    <tr><td class="sapds-gui-label"> Function Group </td>
                                        <td class="sapds-gui-field"> <?php echo $enlfdir['AREA'] ?> &nbsp;</td>
                                        <td> <?php echo htmlentities($funcgrp_desc) ?> &nbsp;</td>
                                    </tr>
                                    <tr><td class="sapds-gui-label"> Program Name </td>
                                        <td class="sapds-gui-field"> <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Prog($func['PNAME'], $prog_desc); ?> &nbsp;</td>
                                        <td> <?php echo $prog_desc ?>&nbsp;</td>
                                    </tr>
                                    <tr><td class="sapds-gui-label"> INCLUDE Name </td>
                                        <td class="sapds-gui-field"> <?php echo $include ?> &nbsp;</td>
                                        <td> &nbsp;</td>
                                    </tr>
                                </tbody>
                            </table>


                            <!-- Parameters: Import, Export, Changing, Tables, Exceptions -->
                            <h5 class="pt-4"><?php echo GLOBAL_ABAP_ICON::getIcon4Parameter() ?> Parameters </h5>
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th class="sapds-alv"> Type </th>
                                        <th class="sapds-alv"> Parameter Name </th>
                                        <th class="sapds-alv"> Typing </th>
                                        <th class="sapds-alv"> Associated Type </th>
                                        <th class="sapds-alv"> Default value </th>
                                        <th class="sapds-alv"> Optional </th>
                                        <th class="sapds-alv"> Pass Value </th>
                                        <th class="sapds-alv"> Short text </th>
                                        <!-- <th class="sapds-alv"> Long Text </th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($fupararef as $fupararef_item) {
                                        // Reverse the TRLE / FALSE value
                                        $para_passvalue = ABAP_DB_CONST::FLAG_TRUE;
                                        if ($fupararef_item['REFERENCE'] == ABAP_DB_CONST::FLAG_TRUE) {
                                            $para_passvalue = ABAP_DB_CONST::FLAG_FALSE;
                                        }
                                        $param_link = ABAP_UI_TOOL::GetFuncParamLink($fupararef_item['PARAMTYPE'], $fupararef_item['STRUCTURE']);
                                        // Load Parameter text
                                        $param_stext = ABAP_DB_TABLE_FUNC::FUNCT($fupararef_item['FUNCNAME'], $fupararef_item['PARAMETER'], $fupararef_item['PARAMTYPE']);
                                        ?>
                                        <tr>
                                            <td class="sapds-alv"> <?php echo ABAP_UI_TOOL::GetFunctionModuleParameterType($fupararef_item['PARAMTYPE']) ?> </td>
                                            <td class="sapds-alv"> <?php echo $fupararef_item['PARAMETER'] ?> </td>
                                            <td class="sapds-alv"> <?php echo ABAP_UI_TOOL::GetFunctionModuleTyping($fupararef_item['REF_CLASS']) ?> </td>
                                            <td class="sapds-alv"> <?php echo $param_link ?> </td>
                                            <td class="sapds-alv"> <?php echo $fupararef_item['DEFAULTVAL'] ?> </td>
                                            <td class="sapds-alv"> <?php echo ABAP_UI_TOOL::GetCheckBox("optional", $fupararef_item['OPTIONAL']) ?> </td>
                                            <td class="sapds-alv"> <?php echo ABAP_UI_TOOL::GetCheckBox("passval", $para_passvalue) ?> </td>
                                            <td class="sapds-alv"> <?php echo htmlentities($param_stext) ?> </td>
                                            <!-- <td class="sapds-alv"> Long Text </td> -->
                                        </tr>
                                    <?php } ?>
                                    <tr>
                                        <td class="sapds-alv"> &nbsp; </td>
                                        <td class="sapds-alv"> &nbsp; </td>
                                        <td class="sapds-alv"> &nbsp; </td>
                                        <td class="sapds-alv"> &nbsp; </td>
                                        <td class="sapds-alv"> &nbsp; </td>
                                        <td class="sapds-alv"> &nbsp; </td>
                                        <td class="sapds-alv"> &nbsp; </td>
                                        <td class="sapds-alv"> &nbsp; </td>
                                        <!-- <td class="sapds-alv"> &nbsp; </td> -->
                                    </tr>
                                </tbody>
                            </table>

                            <h5 class="pt-4"><?php echo GLOBAL_ABAP_ICON::getIcon4ProcessType() ?> Processing Type </h5>
                            <table>
                                <tbody>
                                    <tr><td class="sapds-gui-field"> <?php echo ABAP_UI_TOOL::GetRadioBox("pType", $ptype->CHK_NORMAL) ?> Normal Function Module </td>
                                        <td> &nbsp; </td>
                                    </tr>
                                    <tr><td class="sapds-gui-field"> <?php echo ABAP_UI_TOOL::GetRadioBox("pType", $ptype->CHK_REMOTE) ?><?php echo GLOBAL_ABAP_ICON::getIcon4Rfc() ?> Remote-Enabled Module </td>
                                        <td class="sapds-gui-field"> <?php echo ABAP_UI_TOOL::GetCheckBox("BaseXML", $ptype->CHK_BASXML_ENABLED) ?> BaseXML supported </td>
                                    </tr>
                                    <tr><td class="field" rowspan="4"> <?php echo ABAP_UI_TOOL::GetRadioBox("pType", $ptype->CHK_VERBUCHER) ?> Update Module </td>
                                        <td class="sapds-gui-field"> <?php echo ABAP_UI_TOOL::GetRadioBox("updateType", $ptype->CHK_UKIND1) ?> Start immediately </td>
                                    </tr>
                                    <tr><td class="sapds-gui-field"> <?php echo ABAP_UI_TOOL::GetRadioBox("updateType", $ptype->CHK_UKIND3) ?> Immediate Start, No Restart </td>
                                    </tr>
                                    <tr><td class="sapds-gui-field"> <?php echo ABAP_UI_TOOL::GetRadioBox("updateType", $ptype->CHK_UKIND2) ?> Start Delayed </td>
                                    </tr>
                                    <tr><td class="sapds-gui-field"> <?php echo ABAP_UI_TOOL::GetRadioBox("updateType", $ptype->CHK_UKIND4) ?> Coll.run </td>
                                    </tr>
                                    <tr><td class="sapds-gui-field"> <?php echo ABAP_UI_TOOL::GetRadioBox("pType", $ptype->CHK_ABAP2JAVA) ?> JAVA Module Callable from ABAP </td>
                                        <td> &nbsp; </td>
                                    </tr>
                                    <tr><td class="sapds-gui-field"> <?php echo ABAP_UI_TOOL::GetRadioBox("pType", $ptype->CHK_REMOTE_JAVA) ?> Remote-Enabled JAVA Module </td>
                                        <td> &nbsp; </td>
                                    </tr>
                                    <tr><td class="sapds-gui-field"> <?php echo ABAP_UI_TOOL::GetRadioBox("pType", $ptype->CHK_JAVA2ABAP) ?> Module Callable from JAVA </td>
                                        <td> &nbsp; </td>
                                    </tr>
                                </tbody>
                            </table>

                            <h5 class="pt-4"><?php echo GLOBAL_ABAP_ICON::getIcon4History() ?> History </h5>
                            <table>
                                <tbody>
                                    <tr><td class="sapds-gui-label"> Last changed by/on      </td><td class="sapds-gui-field"><?php echo $progmeta['CNAM'] ?>&nbsp;</td><td> <?php echo $progmeta['CDAT'] ?>&nbsp;</td></tr>
                                    <tr><td class="sapds-gui-label"> SAP Release Created in  </td><td class="sapds-gui-field"><?php echo $hier->CRELEASE ?>&nbsp;</td><td>&nbsp;</td></tr>
                                </tbody>
                            </table>

                        </div> 
                    </div><!-- End Card -->
                </main>

                <div  class="col-xl-2 col-lg-2 d-md-3    col-sm-none" >
                    <!-- Right Side bar -->
                    <?php require $__ROOT__ . '/include/abap_relatedlinks.php' ?>
                </div>
            </div><!-- End of row -->
            <hr>
        </div><!-- End container-fluid, main content -->

        <!-- Footer -->
        <?php require $__ROOT__ . '/include/footer.php' ?>
    </body>
</html>
<?php
// Close PDO Database Connection
ABAP_DB_TABLE::close_conn();
