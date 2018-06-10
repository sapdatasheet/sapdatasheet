<!DOCTYPE html>
<?php
$__WS_ROOT__ = dirname(__FILE__, 3);
$__ROOT__ = dirname(__FILE__, 2);

require_once ($__WS_ROOT__ . '/common-php/library/global.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_ui.php');
GLOBAL_UTIL::UpdateSAPDescLangu();

$GLOBALS['TITLE_TEXT'] = 'Site Terms of Use';
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <title><?php echo $GLOBALS['TITLE_TEXT'] ?><?php echo GLOBAL_WEBSITE::SAPDS_ORG_TITLE ?> </title>
        <meta name="author" content="SAP Datasheet" />
        <meta name="description" content="<?php echo GLOBAL_WEBSITE::SAPDS_ORG_META_DESC ?>" />
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
                            <li class="breadcrumb-item active"><a href="#"><?php echo $GLOBALS['TITLE_TEXT'] ?></a></li>
                        </ol>
                    </nav>


                    <div class="alert alert-success" role="alert">
                        <h2 class="alert-heading"><?php echo $GLOBALS['TITLE_TEXT'] ?></h2>
                        <p><a href="<?php echo GLOBAL_WEBSITE::SAPDS_ORG_URL ?>" target="_blank" title="<?php echo GLOBAL_WEBSITE::SAPDS_ORG_DESC ?>"><?php echo GLOBAL_WEBSITE::SAPDS_ORG_URL_DISPLAY ?></a>
                            and its affinity sites share the same terms of use as described bellow.
                        </p>
                        <ul class="lead">
                            <li><?php echo GLOBAL_WEBSITE::SAPDS_ORG_URL_DISPLAY ?> and its affinity sites content is based on our knowledge of SAP system, and it is constantly reviewed to avoid errors; well we cannot warrant full correctness of all content.</li>
                            <li>While using this site, you agree to have read and accepted our <a href="#">terms of use</a>, <a href="privacy.php">cookie and privacy</a> policy.</li>
                            <li>Use the information and content on this web site at your own risk.</li>
                        </ul>
                        <ul class="lead">
                            <li>SAP and the SAP logo are registered trademarks of <a href="http://www.sap.com" target="_blank" title="SAP SE Web Site">SAP SE</a>.</li>
                            <li>This web site is not sponsored by, affiliated with, or approved by <a href="http://www.sap.com" target="_blank" title="SAP SE Web Site">SAP SE</a>.</li>
                        </ul>

                        <hr>
                        <p class="mb-0">All the Best</p>
                    </div>
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
