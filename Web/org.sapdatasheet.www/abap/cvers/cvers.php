<?php
$__ROOT__ = dirname(dirname(dirname(__FILE__)));
require_once ($__ROOT__ . '/include/common/global.php');
require_once ($__ROOT__ . '/include/common/abap_db.php');
require_once ($__ROOT__ . '/include/common/abap_ui.php');
require_once ($__ROOT__ . '/include/common/schemaorg.php');
GLOBAL_UTIL::UpdateSAPDescLangu();

if (!isset($ObjID)) {
    $ObjID = filter_input(INPUT_GET, 'id');
}

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
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" href="/abap.css" type="text/css" />
        <title><?php echo $GLOBALS['TITLE_TEXT'] . GLOBAL_WEBSITE_SAPDS::TITLE ?> </title>
        <meta name="keywords" content="SAP,<?php echo GLOBAL_ABAP_OTYPE::CVERS_DESC ?>,<?php echo $cvers['COMPONENT']; ?>,<?php echo $cvers_desc; ?>" />
        <meta name="description" content="<?php echo GLOBAL_WEBSITE_SAPDS::META_DESC; ?>" />
        <meta name="author" content="SAP Datasheet" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <script type="application/ld+json"><?php echo $json_ld->toJson() ?></script>
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
                    <tr><td class="left_value"><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeCVERS() ?>
                            <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Cvers($cvers['COMPONENT'], $cvers_desc) ?>&nbsp;</td></tr>
                </tbody>
            </table>
            <h5>Top Level Application Component</h5>
            <table class="content_obj">
                <tbody>
                    <?php
                    foreach ($child_bmfr as $child_bmfr_item) {
                        $child_bmfr_item_s = ABAP_DB_TABLE_HIER::DF14L_ID_LEVEL($child_bmfr_item['COMPONENT']);
                        foreach ($child_bmfr_item_s as $l1_bmfr) {
                            if ($l1_bmfr['LEVEL'] <= 2) {
                                $l1_bmfr_desc = ABAP_DB_TABLE_HIER::DF14T($l1_bmfr['FCTR_ID']);
                                ?>
                                <tr><td class="left_value"><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeBMFR() ?>
                                        <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Bmfr($l1_bmfr['FCTR_ID'], $l1_bmfr['PS_POSID'], $l1_bmfr_desc) ?> </td></tr>
                                <?php
                            }
                        }
                    }
                    ?>
                </tbody>
            </table>

            <?php require $__ROOT__ . '/include/abap_relatedlinks.php' ?>
            <h5>&nbsp;</h5>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Content Navigator -->
            <div class="content_navi">
                <a href="/"><?php echo GLOBAL_ABAP_ICON::getIcon4Home() ?> Home page</a> &gt; 
                <a href="/abap/">ABAP Object</a> &gt; 
                <a href="/abap/cvers/">ABAP <?php echo GLOBAL_ABAP_OTYPE::CVERS_DESC ?></a> &gt; 
                <a href="#"><?php echo $cvers['COMPONENT'] ?></a>
            </div>

            <!-- Content Object -->
            <div class="content_obj_title"><span><?php echo $GLOBALS['TITLE_TEXT'] ?></span></div>
            <div class="content_obj">
                <div>
                    <?php include $__WS_ROOT__ . '/common-php/google/adsense-content-top.html' ?>
                </div>

                <h4> Basic Data </h4>
                <table class="content_obj">
                    <tbody>
                        <tr><td class="content_label"> Software Component </td><td class="field"><?php echo $cvers['COMPONENT'] ?> &nbsp;</td><td>&nbsp;</td></tr>
                        <tr><td class="content_label"> Short Description  </td><td class="field"><?php echo htmlentities($cvers_desc) ?> &nbsp;</td><td>&nbsp;</td></tr>
                        <tr><td class="content_label"> Component type     </td>
                            <td class="field"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4DomainValue(ABAP_DB_CONST::DOMAIN_TADIR_COMP_TYPE, $cvers['COMP_TYPE'], $cvers_comp_type_desc) ?>&nbsp;</td>
                            <td><?php echo $cvers_comp_type_desc ?>&nbsp;</td></tr>
                    </tbody>
                </table><!-- Basic Data: End -->

                <!-- Software Component Content -->
                <?php if (count($child_bmfr) > 0) { ?>
                    <h4> Content </h4>
                    <table class="alv">
                        <caption>Contained Application Component</caption>
                        <tr>
                            <th class="alv"> Application Component </th>
                            <th class="alv"> Application Component ID </th>
                            <th class="alv"> Short Description </th></tr>                        
                        <?php
                        foreach ($child_bmfr as $child_bmfr_item) {
                            $child_bmfr_item_s = ABAP_DB_TABLE_HIER::DF14L_ID($child_bmfr_item['COMPONENT']);
                            foreach ($child_bmfr_item_s as $appcomp_item) {
                                $appcomp_desc = ABAP_DB_TABLE_HIER::DF14T($appcomp_item['FCTR_ID']);
                                ?>
                                <tr><td class="alv"><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeBMFR() ?>
                                        <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Bmfr($appcomp_item['FCTR_ID'], $appcomp_item['PS_POSID'], $appcomp_desc) ?></td>
                                    <td class="alv"><?php echo $appcomp_item['FCTR_ID'] ?></td>
                                    <td class="alv"><?php echo htmlentities($appcomp_desc) ?>&nbsp;</td></tr>
                                    <?php
                                }
                            }
                            ?>
                    </table>
                <?php } ?><!-- Software Component Content: End -->

            </div>
        </div><!-- Content: End -->

        <!-- Footer -->
        <?php require $__ROOT__ . '/include/footer.php' ?>

    </body>
</html>
<?php
// Close PDO Database Connection
ABAP_DB_TABLE::close_conn();
