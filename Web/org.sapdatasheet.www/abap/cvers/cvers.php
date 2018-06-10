<?php
$__WS_ROOT__ = dirname(__FILE__, 4);
$__ROOT__ = dirname(__FILE__, 3);

require_once ($__WS_ROOT__ . '/common-php/library/global.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_db.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_ui.php');
require_once ($__WS_ROOT__ . '/common-php/library/schemaorg.php');
GLOBAL_UTIL::UpdateSAPDescLangu();

$cvers = ABAP_DB_TABLE_HIER::CVERS(strtoupper($ObjID));
if (empty($cvers['COMPONENT'])) {
    ABAP_UI_TOOL::Redirect404();
}
$cvers_desc = ABAP_DB_TABLE_HIER::CVERS_REF($cvers['COMPONENT']);
$cvers_comp_type_desc = ABAP_DB_TABLE_DOMA::DD07T(ABAP_DB_CONST::DOMAIN_TADIR_COMP_TYPE, $cvers['COMP_TYPE']);
$child_bmfr = ABAP_DB_TABLE_HIER::TDEVC_COMPONENT($cvers['COMPONENT']);

$GLOBALS['TITLE_TEXT'] = ABAP_UI_TOOL::GetObjectTitle(GLOBAL_ABAP_OTYPE::CVERS_NAME, $cvers['COMPONENT']);

$json_ld = new \OrgSchema\Thing();
$json_ld->name = $cvers['COMPONENT'];
$json_ld->alternateName = $cvers_desc;
$json_ld->description = $GLOBALS['TITLE_TEXT'];
$json_ld->image = GLOBAL_ABAP_ICON::getIconURL(GLOBAL_ABAP_ICON::OTYPE_CVERS, TRUE);
$json_ld->url = ABAP_UI_DS_Navigation::GetObjectURL(GLOBAL_ABAP_OTYPE::CVERS_NAME, $json_ld->name);
?>
<!DOCTYPE html>
<!-- Software component object. -->
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <title><?php echo $GLOBALS['TITLE_TEXT'] . GLOBAL_WEBSITE::SAPDS_ORG_URL_TITLE ?> </title>
        <meta name="author" content="SAP Datasheet" />
        <meta name="description" content="<?php echo GLOBAL_WEBSITE::SAPDS_ORG_URL_META_DESC; ?>" />
        <meta name="keywords" content="SAP,<?php echo GLOBAL_ABAP_OTYPE::CVERS_DESC ?>,<?php echo $cvers['COMPONENT']; ?>,<?php echo $cvers_desc; ?>" />

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
                                    <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Cvers($cvers['COMPONENT'], $cvers_desc) ?>&nbsp;</td></tr>
                        </tbody>
                    </table>

                    <?php require $__ROOT__ . '/include/abap_ads_side.php' ?>

                    <h6 class="pt-3">Top Level Application Component</h6>
                    <table>
                        <tbody>
                            <?php
                            foreach ($child_bmfr as $child_bmfr_item) {
                                $child_bmfr_item_s = ABAP_DB_TABLE_HIER::DF14L_ID_LEVEL($child_bmfr_item['COMPONENT']);
                                foreach ($child_bmfr_item_s as $l1_bmfr) {
                                    if ($l1_bmfr['LEVEL'] <= 2) {
                                        $l1_bmfr_desc = ABAP_DB_TABLE_HIER::DF14T($l1_bmfr['FCTR_ID']);
                                        ?>
                                        <tr><td><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeBMFR() ?>
                                                <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Bmfr($l1_bmfr['FCTR_ID'], $l1_bmfr['PS_POSID'], $l1_bmfr_desc) ?> </td></tr>
                                        <?php
                                    }
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div><!-- End - Left Side bar -->

                <main class="col-xl-8 col-lg-8 col-md-6  col-sm-9    col-12 bd-content" role="main">
                    <nav class="pt-2" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/"><?php echo GLOBAL_ABAP_ICON::getIcon4Home() ?> Home</a></li>
                            <li class="breadcrumb-item"><a href="/abap/">ABAP Object Types</a></li>
                            <li class="breadcrumb-item"><a href="/abap/cvers/">ABAP <?php echo GLOBAL_ABAP_OTYPE::CVERS_DESC ?></a></li>
                            <li class="breadcrumb-item active"><a href="#"><?php echo $cvers['COMPONENT'] ?></a></li>
                        </ol>
                    </nav>

                    <div class="card shadow">
                        <div class="card-header sapds-card-header"><?php echo $GLOBALS['TITLE_TEXT'] ?></div>
                        <div class="card-body table-responsive sapds-card-body">
                            <div><?php include $__WS_ROOT__ . '/common-php/google/adsense-content-top.html' ?></div>
                            <?php require $__ROOT__ . '/include/abap_desc_language.php' ?>

                            <h5> Basic Data </h5>
                            <table>
                                <tbody>
                                    <tr><td class="sapds-gui-label"> Software Component </td>
                                        <td class="sapds-gui-field"><?php echo $cvers['COMPONENT'] ?> &nbsp;</td><td>&nbsp;</td></tr>
                                    <tr><td class="sapds-gui-label"> Short Description  </td>
                                        <td class="sapds-gui-field"><?php echo htmlentities($cvers_desc) ?> &nbsp;</td><td>&nbsp;</td></tr>
                                    <tr><td class="sapds-gui-label"> Component type     </td>
                                        <td class="sapds-gui-field"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4DomainValue(ABAP_DB_CONST::DOMAIN_TADIR_COMP_TYPE, $cvers['COMP_TYPE'], $cvers_comp_type_desc) ?>&nbsp;</td>
                                        <td>&nbsp;<?php echo $cvers_comp_type_desc ?></td></tr>
                                </tbody>
                            </table><!-- Basic Data: End -->

                            <!-- Software Component Content -->
                            <?php if (count($child_bmfr) > 0) { ?>
                                <h5 class="pt-4"> Content </h5>
                                <table class="table table-sm">
                                    <caption class="sapds-alv">Contained Application Component</caption>
                                    <tr>
                                        <th class="sapds-alv"> Application Component </th>
                                        <th class="sapds-alv"> Application Component ID </th>
                                        <th class="sapds-alv"> Short Description </th></tr>                        
                                    <?php
                                    foreach ($child_bmfr as $child_bmfr_item) {
                                        $child_bmfr_item_s = ABAP_DB_TABLE_HIER::DF14L_ID($child_bmfr_item['COMPONENT']);
                                        foreach ($child_bmfr_item_s as $appcomp_item) {
                                            $appcomp_desc = ABAP_DB_TABLE_HIER::DF14T($appcomp_item['FCTR_ID']);
                                            ?>
                                            <tr><td class="sapds-alv"><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeBMFR() ?>
                                                    <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Bmfr($appcomp_item['FCTR_ID'], $appcomp_item['PS_POSID'], $appcomp_desc) ?></td>
                                                <td class="sapds-alv"><?php echo $appcomp_item['FCTR_ID'] ?></td>
                                                <td class="sapds-alv"><?php echo htmlentities($appcomp_desc) ?>&nbsp;</td></tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                </table>
                            <?php } ?><!-- Software Component Content: End -->

                        </div> 
                    </div><!-- End Card -->
                </main>

                <div  class="col-xl-2 col-lg-2 d-md-3    col-sm-none" >
                    <!-- Right Side bar -->
                    <div class="container">
                        <?php require $__ROOT__ . '/include/abap_relatedlinks.php' ?>
                    </div>
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
