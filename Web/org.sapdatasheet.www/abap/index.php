<!DOCTYPE html>
<!-- ABAP Object Types List -->
<?php
$__WS_ROOT__ = dirname(__FILE__, 3);
$__ROOT__ = dirname(__FILE__, 2);

require_once ($__WS_ROOT__ . '/common-php/library/global.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_ui.php');
GLOBAL_UTIL::UpdateSAPDescLangu();

$GLOBALS['TITLE_TEXT'] = "SAP ABAP Object Types";
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <title><?php echo $GLOBALS['TITLE_TEXT'] . GLOBAL_WEBSITE::SAPDS_ORG_TITLE ?> </title>
        <meta name="author" content="SAP Datasheet" />
        <meta name="description" content="<?php echo $GLOBALS['TITLE_TEXT'] . ', ' . GLOBAL_WEBSITE::SAPDS_ORG_META_DESC ?>" />
        <meta name="keywords" content="SAP,ABAP" />

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

                    <nav class="pt-3" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/"><?php echo GLOBAL_ABAP_ICON::getIcon4Home() ?> Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a href="/abap/">ABAP Object Types</a></li>
                        </ol>
                    </nav>

                    <div class="card shadow">
                        <div class="card-header sapds-card-header"><?php echo $GLOBALS['TITLE_TEXT'] ?></div>
                        <div class="card-body table-responsive sapds-card-body">
                            <div><?php include $__WS_ROOT__ . '/common-php/google/adsense-content-top.html' ?></div>

                            <h5>&nbsp;</h5>
                            <table class="table table-sm table-hover">
                                <tr>
                                    <th class="sapds-alv"> # </th>
                                    <th class="sapds-alv"> Object Type </th>
                                    <th class="sapds-alv"> Object Name </th>
                                </tr>
                                <?php
                                $count = 0;
                                foreach (array_keys(GLOBAL_ABAP_OTYPE::$OTYPES) as $oType) {
                                    $count++;
                                    ?>
                                    <tr><td class="sapds-alv text-right"><?php echo number_format($count) ?> </td>
                                        <td class="sapds-alv"><?php echo GLOBAL_ABAP_ICON::getIcon4Otype($oType) ?>
                                            <a href="/abap/<?php echo strtolower($oType) ?>/"><?php echo $oType ?></a></td>
                                        <td class="sapds-alv"><?php echo GLOBAL_ABAP_OTYPE::$OTYPES[$oType] ?></td>
                                    </tr>
                                <?php } ?>
                                <tr><td class="sapds-alv">&nbsp;</td>
                                    <td class="sapds-alv">&nbsp;</td>
                                    <td class="sapds-alv">&nbsp;</td>
                                </tr>
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
