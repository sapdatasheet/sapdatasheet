<!DOCTYPE html>
<!-- IMG Activity object. -->
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
$imgach = ABAP_DB_TABLE_CUS0::CUS_IMGACH(strtoupper($ObjID));
if (empty($imgach['ACTIVITY'])) {
    ABAP_UI_TOOL::Redirect404();
}

$imgach_t = ABAP_DB_TABLE_CUS0::CUS_IMGACT($imgach['ACTIVITY']);
$atrh = ABAP_DB_TABLE_CUS0::CUS_ATRH($imgach['ATTRIBUTES']);
$dok_clas = substr($imgach['DOCU_ID'], 0, 4);
$dok_name = substr($imgach['DOCU_ID'], 4);
$dok_html = ABAP_DB_TABLE_CUS0::YDOK_HY($imgach['DOCU_ID']);
$tfm18_list = ABAP_DB_TABLE_CUS0::TFM18($dok_clas, $dok_name);
$atrcou_list = ABAP_DB_TABLE_CUS0::CUS_ATRCOU($imgach['ACTIVITY']);
$acth = ABAP_DB_TABLE_CUS0::CUS_ACTH($imgach['C_ACTIVITY']);
$actobj_list = ABAP_DB_TABLE_CUS0::CUS_ACTOBJ($imgach['C_ACTIVITY']);

$hier = ABAP_DB_TABLE_HIER::Hier(ABAP_DB_TABLE_HIER::TADIR_PGMID_R3TR, GLOBAL_ABAP_OTYPE::CUS0_NAME, $imgach['ACTIVITY']);
$GLOBALS['TITLE_TEXT'] = ABAP_UI_TOOL::GetObjectTitle(GLOBAL_ABAP_OTYPE::CUS0_NAME, $imgach['ACTIVITY']);

$json_ld = new \OrgSchema\Thing();
$json_ld->name = $imgach['ACTIVITY'];
$json_ld->alternateName = $imgach_t;
$json_ld->description = $GLOBALS['TITLE_TEXT'];
$json_ld->image = GLOBAL_ABAP_ICON::getIconURL(GLOBAL_ABAP_ICON::OTYPE_CUS0, TRUE);
$json_ld->url = ABAP_UI_DS_Navigation::GetObjectURL(GLOBAL_ABAP_OTYPE::CUS0_NAME, $imgach['ACTIVITY']);
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <title><?php echo $GLOBALS['TITLE_TEXT'] . GLOBAL_WEBSITE::SAPDS_ORG_TITLE ?> </title>
        <meta name="author" content="SAP Datasheet" />
        <meta name="description" content="<?php echo $GLOBALS['TITLE_TEXT'] . GLOBAL_WEBSITE::SAPDS_ORG_TITLE ?>" />
        <meta name="keywords" content="SAP,<?php echo GLOBAL_ABAP_OTYPE::CUS0_DESC ?>,<?php echo $imgach['ACTIVITY'] ?>,<?php echo $imgach_t ?>" />

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
                            <tr><td><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeCUS0() ?>
                                    <a href="/abap/cus0/"><?php echo GLOBAL_ABAP_OTYPE::CUS0_DESC ?></a></td></tr>
                            <tr><td><small><strong>Object name </strong></small></td></tr>
                            <tr><td><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeCUS0() ?>
                                    <a href="#" title="<?php echo $imgach_t ?>"><?php echo $imgach['ACTIVITY'] ?></a> </td></tr>
                        </tbody>
                    </table>

                    <?php require $__ROOT__ . '/include/abap_oname_wul.php' ?>
                    <?php require $__ROOT__ . '/include/abap_ads_side.php' ?>
                </div>

                <main class="col-xl-8 col-lg-8 col-md-6  col-sm-9    col-12 bd-content" role="main">
                    <nav class="pt-3" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/"><?php echo GLOBAL_ABAP_ICON::getIcon4Home() ?> Home</a></li>
                            <li class="breadcrumb-item"><a href="/abap/">ABAP Object Types</a></li>
                            <li class="breadcrumb-item"><a href="/abap/cus0/"><?php echo GLOBAL_ABAP_OTYPE::CUS0_DESC ?></a></li>
                            <li class="breadcrumb-item active"><a href="#"><?php echo $imgach['ACTIVITY'] ?></a></li>
                        </ol>
                    </nav>

                    <div class="card shadow">
                        <div class="card-header sapds-card-header"><?php echo $GLOBALS['TITLE_TEXT'] ?></div>
                        <div class="card-body table-responsive sapds-card-body">
                            <div class="align-content-start"><?php include $__WS_ROOT__ . '/common-php/google/adsense-content-top.html' ?></div>
                            <?php require $__ROOT__ . '/include/abap_desc_language.php' ?>
                            <?php require $__ROOT__ . '/include/abap_oname_hier.php' ?>

                            <!-- TODO: to implement
                            <h5> IMG Tree </h5>
                            -->

                            <h5 class="pt-4"><?php echo GLOBAL_ABAP_ICON::getIcon4Header() ?> IMG Activity </h5>
                            <table>
                                <tbody>
                                    <tr><td class="sapds-gui-label"> ID </td>
                                        <td class="sapds-gui-field"> <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Cus0IMGActivity($imgach['ACTIVITY'], $imgach_t, FALSE); ?> </td>
                                        <td> <?php echo htmlentities($imgach_t) ?> &nbsp;</td>
                                    </tr>
                                    <tr><td class="sapds-gui-label"> Transaction Code </td>
                                        <td class="sapds-gui-field"> <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Tran($imgach['TCODE'], null) ?> &nbsp;</td>
                                        <td> <?php echo ABAP_DB_TABLE_TRAN::TSTCT($imgach['TCODE']) ?>&nbsp; </td>
                                    </tr>
                                    <tr><td class="sapds-gui-label"> Created on </td>
                                        <td class="sapds-gui-field"> <?php echo $imgach['FDATE'] ?> &nbsp;</td>
                                        <td> &nbsp;</td>
                                    </tr>
                                    <tr><td class="sapds-gui-label"> Customizing Attributes </td>
                                        <td class="sapds-gui-field"> <?php echo $imgach['ATTRIBUTES'] ?> &nbsp;</td>
                                        <td> <?php echo ABAP_DB_TABLE_CUS0::CUS_ATRT($imgach['ATTRIBUTES']) ?>&nbsp;</td>
                                    </tr>
                                    <tr><td class="sapds-gui-label"> Customizing Activity </td>
                                        <td class="sapds-gui-field"> <?php echo $imgach['C_ACTIVITY'] ?> &nbsp;</td>
                                        <td> <?php echo ABAP_DB_TABLE_CUS0::CUS_ACTT($imgach['C_ACTIVITY']) ?>&nbsp;</td>
                                    </tr>
                                </tbody>
                            </table>

                            <h5 class="pt-4"><?php echo GLOBAL_ABAP_ICON::getIcon4SystemHelp() ?> Document </h5>
                            <table>
                                <tbody>
                                    <tr><td class="sapds-gui-label"> Document Class </td>
                                        <td class="sapds-gui-field"> <?php echo $dok_clas ?> &nbsp;</td>
                                        <td> Hypertext: Object Class - Class to which a document belongs.</td>
                                    </tr>
                                    <tr><td class="sapds-gui-label"> Document Name </td>
                                        <td class="sapds-gui-field"> <?php echo $dok_name ?> &nbsp;</td>
                                        <td> &nbsp;</td>
                                    </tr>
                                </tbody>
                            </table>
                            <?php if (empty($dok_html) === FALSE) { ?>
                                <div class="sapds-f1doc"><?php echo $dok_html ?></div>
                            <?php } ?>

                            <h5 class="pt-4"> Business Attributes </h5>
                            <table>
                                <tbody>
                                    <tr><td class="sapds-gui-label"> ASAP Roadmap ID </td>
                                        <td class="sapds-gui-field"> <?php echo $atrh['ROADMAP_ID'] ?> &nbsp;</td>
                                        <td> <?php echo ABAP_DB_TABLE_CUS0::TROADMAPT($atrh['ROADMAP_ID']) ?>&nbsp;</td>
                                    </tr>
                                    <tr><td class="sapds-gui-label"> Mandatory / Optional </td>
                                        <td class="sapds-gui-field"> <?php echo $atrh['ACTIVITY'] ?> &nbsp;</td>
                                        <td> <?php echo ABAP_DB_TABLE_DOMA::DD07T(ABAP_DB_CONST::DOMAIN_CUS_ATRH_ACTIVITY, $atrh['ACTIVITY']) ?>&nbsp;</td>
                                    </tr>
                                    <tr><td class="sapds-gui-label"> Critical / Non-Critical </td>
                                        <td class="sapds-gui-field"> <?php echo $atrh['CRITICAL'] ?> &nbsp;</td>
                                        <td> <?php echo ABAP_DB_TABLE_DOMA::DD07T(ABAP_DB_CONST::DOMAIN_CUS_ATRH_CRITICAL, $atrh['CRITICAL']) ?>&nbsp;</td>
                                    </tr>
                                    <tr><td class="sapds-gui-label"> Country-Dependency </td>
                                        <td class="sapds-gui-field"> <?php echo $atrh['COUNTRY'] ?> &nbsp;</td>
                                        <td> <?php echo ABAP_DB_TABLE_DOMA::DD07T(ABAP_DB_CONST::DOMAIN_CUS_ATRH_COUNTRY, $atrh['COUNTRY']) ?>&nbsp;</td>
                                    </tr>
                                </tbody>
                            </table>
                            <?php if (count($atrcou_list) > 0) { ?>
                                <table class="table table-sm">
                                    <tr>
                                        <th class="sapds-alv"> Customizing Attributes </th>
                                        <th class="sapds-alv"> Country Key </th>
                                        <th class="sapds-alv"> Country Name </th>
                                    </tr>
                                    <?php foreach ($atrcou_list as $atrcou) { ?>
                                        <tr><td class="sapds-alv"><?php echo $atrcou['ATTR_ID'] ?> </td>
                                            <td class="sapds-alv"><?php echo $atrcou['COUNTRY'] ?> </td>
                                            <td class="sapds-alv"><?php echo ABAP_DB_TABLE_CUS0::T005T($atrcou['COUNTRY']) ?> </td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            <?php } ?>


                            <?php if (count($tfm18_list) > 0) { ?>
                                <h5 class="pt-4"><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeBMFR() ?> Assigned Application Components</h5>
                                <table class="table table-sm">
                                    <tr>
                                        <th class="sapds-alv"> Documentation Object Class </th>
                                        <th class="sapds-alv"> Documentation Object Name </th>
                                        <th class="sapds-alv"> Current line number </th>
                                        <th class="sapds-alv"> Application Component </th>
                                        <th class="sapds-alv"> Application Component Name </th>
                                    </tr>
                                    <?php
                                    foreach ($tfm18_list as $tfm18) {
                                        $tfm18_desc = ABAP_DB_TABLE_HIER::DF14T($tfm18['FUNCT']);
                                        ?>
                                        <tr><td class="sapds-alv"><?php echo $tfm18['DOKCLASS'] ?> </td>
                                            <td class="sapds-alv"><?php echo $tfm18['DOKNAME'] ?> </td>
                                            <td class="sapds-alv"><?php echo $tfm18['LINNO'] ?> </td>
                                            <td class="sapds-alv"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4Bmfr($tfm18['FUNCT'], $tfm18['FUNCT'], $tfm18_desc); ?> </td>
                                            <td class="sapds-alv"><?php echo htmlentities($tfm18_desc) ?>&nbsp;</td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            <?php } ?>

                            <h5 class="pt-4"> Maintenance Objects </h5>
                            <table>
                                <tbody>
                                    <tr><td class="sapds-gui-label"> Maintenance object type </td>
                                        <td class="sapds-gui-field"> <?php echo $acth['ACT_TYPE'] ?> &nbsp;</td>
                                        <td> <?php echo ABAP_UI_CUS0::GetImgActivityTypeDesc($acth['ACT_TYPE']) ?>&nbsp;</td>
                                    </tr>
                                </tbody>
                            </table>
                            <?php if (count($actobj_list) > 0) { ?>
                                <table class="table table-sm">
                                    <th>Assigned objects</th>
                                    <tr>
                                        <th class="sapds-alv"> Customizing Object </th>
                                   <!-- <th class="sapds-alv"> Object Description </th> -->
                                        <th class="sapds-alv"> Object Type </th>
                                        <th class="sapds-alv"> Transaction Code </th>
                                        <th class="sapds-alv"> Sub-object </th>
                                        <th class="sapds-alv"> Do not Summarize </th>
                                        <th class="sapds-alv"> Skip Subset Dialog Box</th>
                                   <!-- <th class="sapds-alv"> Current Settings </th> -->
                                        <th class="sapds-alv"> Description for multiple selections </th>
                                    </tr>
                                    <?php foreach ($actobj_list as $actobj) { ?>
                                        <tr><td class="sapds-alv"><?php echo $actobj['OBJECTNAME'] ?> </td>
                                            <td class="sapds-alv"><?php echo $actobj['OBJECTTYPE'] ?> - <?php echo ABAP_DB_TABLE_DOMA::DD07T(ABAP_DB_CONST::DOMAIN_CUS_ACTOBJ_OBJECTTYPE, $actobj['OBJECTTYPE']) ?></td>
                                            <td class="sapds-alv"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4Tran($actobj['TCODE'], null) ?> </td>
                                            <td class="sapds-alv"><?php echo $actobj['SUBOBJNAME'] ?> </td>
                                            <td class="sapds-alv"><?php echo ABAP_UI_TOOL::GetCheckBox("TXN_NO_CON", $actobj['TXN_NO_CON']) ?> </td>
                                            <td class="sapds-alv"><?php echo ABAP_UI_TOOL::GetCheckBox("SUPRESS_FL", $actobj['SUPRESS_FL']) ?> </td>
                                            <td class="sapds-alv"><?php echo htmlentities(ABAP_DB_TABLE_CUS0::CUS_ACTOBT($actobj)) ?>&nbsp;</td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            <?php } ?>

                            <h5 class="pt-4"><?php echo GLOBAL_ABAP_ICON::getIcon4History() ?> History </h5>
                            <table>
                                <tbody>
                                    <tr><td class="sapds-gui-label"> Last changed by/on      </td><td class="sapds-gui-field"><?php echo $imgach['LUSER'] ?>&nbsp;</td><td> <?php echo $imgach['LDATE'] ?>&nbsp;</td></tr>
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
