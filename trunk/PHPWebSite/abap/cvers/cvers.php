<!DOCTYPE html>
<!-- Software component object. -->
<?php
require_once '../../include/global.php';
require_once '../../include/abap_db.php';
require_once '../../include/abap_ui.php';

$SoftComp = filter_input(INPUT_GET, 'id');
$cvers = ABAP_DB_TABLE_HIER::CVERS($SoftComp);
if (empty($cvers['COMPONENT'])) {
    ABAP_Redirect::Redirect404();
}
$GLOBALS['TITLE_TEXT'] = 'SAP ABAP ' . ABAP_OTYPE::CVERS_DESC . ' ' . $cvers['COMPONENT'];
$cvers_desc = ABAP_DB_TABLE_HIER::CVERS_REF($SoftComp);
$cvers_comp_type_desc = ABAP_DB_TABLE_DOMA::DD07T(ABAP_DB_CONST::TADIR_COMP_TYPE_DOMAIN, $cvers['COMP_TYPE']);
$children = ABAP_DB_TABLE_HIER::CVERS_Child($cvers['COMPONENT']);
?>
<html>
    <head>
        <link rel="stylesheet" href="../../abap.css" type="text/css" >
        <title><?php echo $GLOBALS['TITLE_TEXT']; ?> <?php echo WEBSITE::TITLE ?> </title>
        <meta name="keywords" content="SAP,<?php echo ABAP_OTYPE::CVERS_DESC ?>,<?php echo $cvers['COMPONENT']; ?>,<?php echo $cvers_desc; ?>">
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
                    <tr><td class="left_value"><?php echo ABAP_Navigation::GetURLSoftComp($cvers['COMPONENT'], $cvers_desc) ?>&nbsp;</td></tr>
                </tbody>
            </table>
            <h5>Top Level Application Component</h5>
            <table class="content_obj">
                <tbody>
                    <?php
                    foreach ($children as $l1_child) {
                        if ($l1_child['LEVEL'] <= 2) {
                            $l1_appcomp_desc = ABAP_DB_TABLE_HIER::DF14T($l1_child['FCTR_ID']);
                            ?>
                            <tr><td class="left_value"><?php echo ABAP_Navigation::GetURLAppComp($l1_child['FCTR_ID'], $l1_child['PS_POSID'], $l1_appcomp_desc) ?> </td></tr>
                            <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Content Navigator -->
            <div class="content_navi">
                <a href="/">Home page</a> &gt; 
                <a href="/abap/">ABAP Object</a> &gt; 
                <a href="/abap/cvers/">ABAP <?php echo ABAP_OTYPE::CVERS_DESC ?></a> &gt; 
                <a href="#"><?php echo $cvers['COMPONENT'] ?></a>
            </div>

            <!-- Content Object -->
            <div class="content_obj_title"><span><?php echo $GLOBALS['TITLE_TEXT'] ?></span></div>
            <div class="content_obj">
                <h4> Basic Data </h4>
                <table class="content_obj">
                    <tbody>
                        <tr><td class="content_label"> Software Component </td><td class="field"><?php echo $cvers['COMPONENT'] ?> &nbsp;</td><td>&nbsp;</td></tr>
                        <tr><td class="content_label"> Short Description  </td><td class="field"><?php echo $cvers_desc ?> &nbsp;</td><td>&nbsp;</td></tr>
                        <tr><td class="content_label"> Component type     </td>
                            <td class="field"><?php echo ABAP_Navigation::GetURLDomainValue(ABAP_DB_CONST::TADIR_COMP_TYPE_DOMAIN, $cvers['COMP_TYPE'], $cvers_comp_type_desc) ?>&nbsp;</td>
                            <td><?php echo $cvers_comp_type_desc ?>&nbsp;</td></tr>
                    </tbody>
                </table><!-- Basic Data: End -->

                <!-- Software Component Content -->
                <?php if (!empty($children)) { ?>
                    <h4> Software Component Content </h4>
                    <table class="alv">
                        <caption>Contained Application Component</caption>
                        <tr>
                            <th class="alv"> Application Component </th>
                            <th class="alv"> Application Component ID </th>
                            <th class="alv"> Short Description </th></tr>                        
                        <?php
                        foreach ($children as $child) {
                            $appcomp_desc = ABAP_DB_TABLE_HIER::DF14T($child['FCTR_ID']);
                            ?>
                            <tr><td class="alv"><?php echo ABAP_Navigation::GetURLAppComp($child['FCTR_ID'], $child['PS_POSID'], $appcomp_desc) ?></td>
                                <td class="alv"><?php echo $child['FCTR_ID'] ?></td>
                                <td class="alv"><?php echo $appcomp_desc ?>&nbsp;</td></tr>
                            <?php } ?>
                    </table>
                <?php } ?><!-- Software Component Content: End -->

            </div>
        </div><!-- Content: End -->

        <!-- Footer -->
        <?php include '../../include/footer.html' ?>

    </body>
</html>
</html>
