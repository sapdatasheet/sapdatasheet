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
$doma = ABAP_DB_TABLE_DOMA::DD01L(strtoupper($ObjID));
if (empty($doma['DOMNAME'])) {
    ABAP_UI_TOOL::Redirect404();
}
$doma_desc = ABAP_DB_TABLE_DOMA::DD01T($doma['DOMNAME']);
$doma_datatype_desc = ABAP_DB_TABLE_DOMA::DD07T(ABAP_DB_CONST::DOMAIN_DATATYPE, $doma['DATATYPE']);
$doma_vall = ABAP_DB_TABLE_DOMA::DD07L($doma['DOMNAME']);

$wul_counter_list = ABAPANA_DB_TABLE::WULCOUNTER_List(GLOBAL_ABAP_OTYPE::DOMA_NAME, $doma['DOMNAME']);
$wul_list = ABAP_DB_TABLE_DTEL::DD04L_DOMNAME($ObjID);
$wil_enabled = TRUE;
$wil_counter_list = ABAPANA_DB_TABLE::WILCOUNTER_List(GLOBAL_ABAP_OTYPE::DOMA_NAME, $doma['DOMNAME']);

$hier = ABAP_DB_TABLE_HIER::Hier(ABAP_DB_TABLE_HIER::TADIR_PGMID_R3TR, GLOBAL_ABAP_OTYPE::DOMA_NAME, $doma['DOMNAME']);
$GLOBALS['TITLE_TEXT'] = ABAP_UI_TOOL::GetObjectTitle(GLOBAL_ABAP_OTYPE::DOMA_NAME, $doma['DOMNAME']);

$json_ld = new \OrgSchema\Thing();
$json_ld->name = $doma['DOMNAME'];
$json_ld->alternateName = $doma_desc;
$json_ld->description = $GLOBALS['TITLE_TEXT'];
$json_ld->image = GLOBAL_ABAP_ICON::getIconURL(GLOBAL_ABAP_ICON::OTYPE_DOMA, TRUE);
$json_ld->url = ABAP_UI_DS_Navigation::GetObjectURL(GLOBAL_ABAP_OTYPE::DOMA_NAME, $json_ld->name);
?>
<!DOCTYPE html>
<!-- DDIC Domain object. -->
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <title><?php echo $GLOBALS['TITLE_TEXT'] . GLOBAL_WEBSITE_SAPDS::TITLE ?> </title>
        <meta name="author" content="SAP Datasheet" />
        <meta name="description" content="<?php echo GLOBAL_WEBSITE_SAPDS::META_DESC; ?>" />
        <meta name="keywords" content="SAP,<?php echo GLOBAL_ABAP_OTYPE::DOMA_DESC ?>,<?php echo $doma['DOMNAME'] ?>,<?php echo $doma_desc ?>" />

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
                            <tr><td><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeDOMA() ?>
                                    <a href="/abap/doma/"><?php echo GLOBAL_ABAP_OTYPE::DOMA_DESC ?></a></td></tr>
                            <tr><td><small><strong>Object name </strong></small></td></tr>
                            <tr><td><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeDOMA() ?>
                                    <a href="#" title="<?php echo $doma_desc ?>"><?php echo $doma['DOMNAME'] ?></a> </td></tr>
                        </tbody>
                    </table>
                    <?php if (strlen(trim($doma['ENTITYTAB'])) > 0) { ?>
                        <h6 class="pt-4">Relationship</h6>
                        <table>
                            <tbody>
                                <tr><td>Value table</td></tr>
                                <tr><td><?php echo ABAP_UI_DS_Navigation::GetHyperlink4Tabl($doma['ENTITYTAB'], '') ?>&nbsp;</td></tr>
                            </tbody>
                        </table>
                    <?php } ?>

                    <?php require $__ROOT__ . '/include/abap_oname_wul.php' ?>
                    <?php require $__ROOT__ . '/include/abap_ads_side.php' ?>

                    <h6 class="pt-4">Used by Data Element</h6>
                    <table>
                        <tbody>
                            <?php if (empty($wul_list) === FALSE) { ?>
                                <?php foreach ($wul_list as $wul_item) { ?>
                                    <tr><td><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeDTEL() ?>
                                            <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Dtel($wul_item['ROLLNAME'], ABAP_DB_TABLE_DTEL::DD04T($wul_item['ROLLNAME'])) ?>&nbsp;</td></tr>
                                <?php } ?>
                            <?php } else { ?>
                                <tr><td>Not Used by Anyone</td></tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <main class="col-xl-8 col-lg-8 col-md-6  col-sm-9    col-12 bd-content" role="main">
                    <nav class="pt-3" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/"><?php echo GLOBAL_ABAP_ICON::getIcon4Home() ?> Home</a></li>
                            <li class="breadcrumb-item"><a href="/abap/">ABAP Object Types</a></li>
                            <li class="breadcrumb-item"><a href="/abap/doma/"><?php echo GLOBAL_ABAP_OTYPE::DOMA_DESC ?></a></li>
                            <li class="breadcrumb-item active"><a href="#"><?php echo $doma['DOMNAME'] ?></a></li>
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
                                    <tr><td class="sapds-gui-label"> Domain Name       </td><td class="sapds-gui-field"> <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Doma($doma['DOMNAME'], $doma_desc) ?> </td></tr>
                                    <tr><td class="sapds-gui-label"> Short Description </td><td class="sapds-gui-field"> <?php echo htmlentities($doma_desc) ?> &nbsp;</td></tr>
                                </tbody>
                            </table>

                            <h5 class="pt-4"><?php echo GLOBAL_ABAP_ICON::getIcon4OOClassAttribute() ?> Definition </h5>
                            <table>
                                <tbody>
                                    <tr><td class="sapds-gui-label"> Data Type          </td><td class="sapds-gui-field"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4DomainValue(ABAP_DB_CONST::DOMAIN_DATATYPE, $doma['DATATYPE'], $doma_datatype_desc) ?> </td><td> <?php echo $doma_datatype_desc ?> </td></tr>
                                    <tr><td class="sapds-gui-label"> No. Characters     </td><td class="sapds-gui-field text-right"><?php echo intval($doma['LENG']) ?>&nbsp;</td><td>&nbsp;</td></tr>
                                    <tr><td class="sapds-gui-label"> Decimal Places     </td><td class="sapds-gui-field text-right"><?php echo ABAP_UI_TOOL::ClearZero(intval($doma['DECIMALS'])) ?>&nbsp;</td><td>&nbsp;</td></tr>
                                    <tr><td class="sapds-gui-label"> Output Length      </td><td class="sapds-gui-field text-right"><?php echo intval($doma['OUTPUTLEN']) ?>&nbsp;</td><td>&nbsp;</td></tr>
                                    <tr><td class="sapds-gui-label"> Conversion Routine </td><td class="sapds-gui-field"><?php echo $doma['CONVEXIT'] ?>&nbsp;</td><td>&nbsp;</td></tr>
                                    <tr><td class="sapds-gui-label"> Sign               </td><td class="text-right"><?php echo ABAP_UI_TOOL::GetCheckBox('SIGNFLAG', $doma['SIGNFLAG']) ?></td><td>&nbsp;</td></tr>
                                    <tr><td class="sapds-gui-label"> Lower Case         </td><td class="text-right"><?php echo ABAP_UI_TOOL::GetCheckBox('LOWERCASE', $doma['LOWERCASE']) ?></td><td>&nbsp;</td></tr>
                                </tbody>
                            </table>

                            <?php
                            if (strlen(trim($doma['ENTITYTAB'])) > 0) {
                                $entitytab_desc = ABAP_DB_TABLE_TABL::DD02T($doma['ENTITYTAB']);
                                ?>
                                <h5 class="pt-4"><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeTABL() ?> Value Table</h5>
                                <table>
                                    <tbody>
                                        <tr><td class="sapds-gui-label"> Value Table </td>
                                            <td class="sapds-gui-field"> <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Tabl($doma['ENTITYTAB'], $entitytab_desc) ?> &nbsp; </td>
                                            <td><?php echo $entitytab_desc ?></td> </tr>
                                    </tbody>
                                </table>
                            <?php } ?>

                            <?php if (empty($doma_vall) === FALSE) { ?>
                                <h5 class="pt-4"><?php echo GLOBAL_ABAP_ICON::getIcon4Field() ?> Value Range</h5>
                                <a id="<?php echo ABAP_UI_CONST::ANCHOR_VALUES ?>"></a>
                                <table class="table table-sm">
                                    <tbody>
                                        <tr><th class="sapds-alv">#</th>
                                            <th class="sapds-alv">Lower Limit</th>
                                            <th class="sapds-alv">Upper Limit</th>
                                            <th class="sapds-alv">Short Description</th> </tr>
                                        <?php
                                        foreach ($doma_vall as $doma_vall_item) {
                                            $doma_vall_item_text = ABAP_DB_TABLE_DOMA::DD07T($doma['DOMNAME'], $doma_vall_item['DOMVALUE_L']);
                                            ?>
                                            <tr><td class="sapds-alv text-center"> <?php echo intval($doma_vall_item['VALPOS']) ?> </td>
                                                <td class="sapds-alv text-right"> <?php echo $doma_vall_item['DOMVALUE_L'] ?> &nbsp; </td>
                                                <td class="sapds-alv text-right"> <?php echo $doma_vall_item['DOMVALUE_H'] ?> &nbsp; </td>
                                                <td class="sapds-alv"><?php echo htmlentities($doma_vall_item_text) ?></td> </tr>
                                        <?php } ?>
                                        <tr><td class="sapds-alv text-center"> &nbsp; </td>
                                            <td class="sapds-alv text-right">  &nbsp; </td>
                                            <td class="sapds-alv text-right">  &nbsp; </td>
                                            <td class="sapds-alv"> &nbsp; </td> </tr>
                                    </tbody>
                                </table>
                            <?php } ?>

                            <h5 class="pt-4"><?php echo GLOBAL_ABAP_ICON::getIcon4History() ?> History </h5>
                            <table>
                                <tbody>
                                    <tr><td class="sapds-gui-label"> Last changed by/on      </td><td class="sapds-gui-field"><?php echo $doma['AS4USER'] ?>&nbsp;</td><td> <?php echo $doma['AS4DATE'] ?>&nbsp;</td></tr>
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
