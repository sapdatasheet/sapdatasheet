<?php ob_start(); ?>
<!DOCTYPE html>
<!-- Software component index. -->
<?php
require_once '../../include/global.php';
require_once '../../include/abap_db.php';
require_once '../../include/abap_ui.php';

$GLOBALS['TITLE_TEXT'] = "SAP ABAP " . ABAP_OTYPE::CVERS_DESC;
?>
<html>
    <head>
        <link rel="stylesheet" href="../../abap.css" type="text/css" >
        <title>SAP ABAP <?php echo ABAP_OTYPE::CVERS_DESC ?> <?php echo WEBSITE::TITLE ?> </title>
        <meta name="keywords" content="SAP,ABAP,<?php echo ABAP_OTYPE::CVERS_DESC ?>">
        <meta name="description" content="<?php echo WEBSITE::META_DESC ?>">
        <meta name="author" content="SAP Datasheet">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
    </head>
    <body>

        <!-- Header -->
        <?php require '../../include/header.php' ?>

        <!-- Left -->
        <?php require '../../include/abap_index_left.php' ?>

        <!-- Content -->
        <div class="content">
            <!-- Content Navigator -->
            <div class="content_navi">
                <a href="/">Home page</a> &gt; 
                <a href="/abap/">ABAP Object</a> &gt; 
                <a href="/abap/cvers/"><?php echo ABAP_OTYPE::CVERS_DESC ?></a> 
            </div>

            <!-- Content Object -->
            <div class="content_obj_title"><span>SAP ABAP <?php echo ABAP_OTYPE::CVERS_DESC ?></span></div>
            <div class="content_obj">

                <h4> <?php echo ABAP_OTYPE::CVERS_DESC ?> </h4>
                <table class="alv">
                    <tr>
                        <th class="alv"> Software Component </th>
                        <th class="alv"> Short Description </th>
                        <th class="alv"> Component Type </th>
                        <th class="alv"> Component Type Text </th></tr>
                    <?php
                    $table = ABAP_DB_TABLE_HIER::CVERS_List();
                    while ($row = mysqli_fetch_array($table)) {
                        $cvers_component = $row['COMPONENT'];
                        $cvers_desc = ABAP_DB_TABLE_HIER::CVERS_REF($row['COMPONENT']);
                        $cvers_comp_type = $row['COMP_TYPE'];
                        $cvers_comp_type_desc = ABAP_DB_TABLE_DOMA::DD07T(ABAP_DB_CONST::DOMAIN_TADIR_COMP_TYPE, $row['COMP_TYPE']);
                        ?>
                        <tr><td class="alv"><?php echo ABAP_Navigation::GetURLSoftComp($cvers_component, $cvers_desc) ?></td>
                            <td class="alv"><?php echo $cvers_desc ?></td>
                            <td class="alv"><?php echo ABAP_Navigation::GetURLDomainValue(ABAP_DB_CONST::DOMAIN_TADIR_COMP_TYPE, $cvers_comp_type, $cvers_comp_type_desc) ?></td>
                            <td class="alv"><?php echo $cvers_comp_type_desc ?></td></tr>
                        <?php } ?>
                </table>

            </div>
        </div><!-- Content: End -->        

        <!-- Footer -->
        <?php include '../../include/footer.html' ?>

    </body>
</html>
<?php 
$ob_content = ob_get_contents();
ob_end_flush();
$ob_fp = fopen("./index.html", "w");
fwrite($ob_fp, $ob_content);
fclose($ob_fp);
?>