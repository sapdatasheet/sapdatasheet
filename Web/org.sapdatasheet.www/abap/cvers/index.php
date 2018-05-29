<?php
$__WS_ROOT__ = dirname(__FILE__, 4);
$__ROOT__ = dirname(__FILE__, 3);

require_once ($__WS_ROOT__ . '/common-php/library/global.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_db.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_ui.php');
GLOBAL_UTIL::UpdateSAPDescLangu();

$GLOBALS['TITLE_TEXT'] = "SAP ABAP " . GLOBAL_ABAP_OTYPE::CVERS_DESC;
?>
<!DOCTYPE html>
<!-- Software component index. -->
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <title>SAP ABAP <?php echo GLOBAL_ABAP_OTYPE::CVERS_DESC ?> <?php echo GLOBAL_WEBSITE_SAPDS::TITLE ?> </title>
        <meta name="description" content="<?php echo GLOBAL_WEBSITE_SAPDS::META_DESC ?>" />
        <meta name="author" content="SAP Datasheet" />
        <meta name="keywords" content="SAP,ABAP,<?php echo GLOBAL_ABAP_OTYPE::CVERS_DESC ?>" />

        <link rel="stylesheet" type="text/css"  href="/3rdparty/bootstrap/css/bootstrap.min.css"/>
        <link rel="stylesheet" type="text/css"  href="/sapdatasheet.css"/>
    </head>
    <body>
        <!-- Header -->
        <?php require $__ROOT__ . '/include/header.php' ?>

        <div class="container-fluid">
            <div class="row">
                <div  class="col-xl-2 col-lg-2 col-md-3  col-sm-3    bd-sidebar bg-light">
                    <!-- Left Side bar -->
                    <?php require $__ROOT__ . '/include/abap_index_left.php' ?>
                </div>

                <main class="col-xl-8 col-lg-8 col-md-6  col-sm-9    col-12 bd-content" role="main">
                    <br>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/"><?php echo GLOBAL_ABAP_ICON::getIcon4Home() ?> Home</a></li>
                            <li class="breadcrumb-item"><a href="/abap/">ABAP Object Types</a></li>
                            <li class="breadcrumb-item active"><a href="/abap/cvers/"><?php echo GLOBAL_ABAP_OTYPE::CVERS_DESC ?></a></li>
                        </ol>
                    </nav>

                    <div class="card shadow">
                        <div class="card-header sapds-card-header">SAP ABAP <?php echo GLOBAL_ABAP_OTYPE::CVERS_DESC ?></div>
                        <div class="card-body table-responsive sapds-card-body">
                            <div><?php include $__WS_ROOT__ . '/common-php/google/adsense-content-top.html' ?></div>

                            <br>
                            <h5><?php echo GLOBAL_ABAP_OTYPE::CVERS_DESC ?></h5>
                            <table class="table table-sm table-hover">
                                <tr>
                                    <th class="sapds-alv"> # </th>
                                    <th class="sapds-alv"> Software Component </th>
                                    <th class="sapds-alv"> Short Description </th>
                                    <th class="sapds-alv"> Component Type </th>
                                    <th class="sapds-alv"> Component Type Text </th>
                                </tr>
                                <tr>
                                    <th class="sapds-alv"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4DtelDocument(ABAP_DB_CONST::INDEX_SEQNO_DTEL) ?></th>
                                    <th class="sapds-alv"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4DtelDocument(ABAP_DB_TABLE_HIER::CVERS_COMPONENT_DTEL) ?></th>
                                    <th class="sapds-alv"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4DtelDocument(ABAP_DB_TABLE_HIER::CVERS_REF_DESC_TEXT_DTEL) ?></th>
                                    <th class="sapds-alv"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4DtelDocument(ABAP_DB_TABLE_HIER::CVERS_COMP_TYPE_DTEL) ?></th>
                                    <th class="sapds-alv"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4DtelDocument(ABAP_DB_TABLE_DOMA::DD07T_DDTEXT_DTEL) ?></th>
                                </tr>
                                <?php
                                $table = ABAP_DB_TABLE_HIER::CVERS_List();
                                $count = 0;
                                foreach ($table as $row) {
                                    $count++;
                                    $cvers_component = $row['COMPONENT'];
                                    $cvers_desc = ABAP_DB_TABLE_HIER::CVERS_REF($row['COMPONENT']);
                                    $cvers_comp_type = $row['COMP_TYPE'];
                                    $cvers_comp_type_desc = ABAP_DB_TABLE_DOMA::DD07T(ABAP_DB_CONST::DOMAIN_TADIR_COMP_TYPE, $row['COMP_TYPE']);
                                    ?>
                                    <tr><td class="sapds-alv text-right"><?php echo number_format($count) ?> </td>
                                        <td class="sapds-alv"><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeCVERS() ?>
                                            <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Cvers($cvers_component, $cvers_desc) ?></td>
                                        <td class="sapds-alv"><?php echo htmlentities($cvers_desc) ?></td>
                                        <td class="sapds-alv"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4DomainValue(ABAP_DB_CONST::DOMAIN_TADIR_COMP_TYPE, $cvers_comp_type, $cvers_comp_type_desc) ?></td>
                                        <td class="sapds-alv"><?php echo htmlentities($cvers_comp_type_desc) ?></td></tr>
                                <?php } ?>
                            </table>


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
