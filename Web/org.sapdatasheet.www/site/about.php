<!DOCTYPE html>
<?php
$__WS_ROOT__ = dirname(__FILE__, 3);
$__ROOT__ = dirname(__FILE__, 2);

require_once ($__WS_ROOT__ . '/common-php/library/global.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_ui.php');
GLOBAL_UTIL::UpdateSAPDescLangu();

$GLOBALS['TITLE_TEXT'] = 'About';
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
                        <p>We are the author of <a href="<?php echo GLOBAL_WEBSITE::SAPDS_ORG_URL ?>" target="_blank" title="<?php echo GLOBAL_WEBSITE::SAPDS_ORG_DESC ?>"><?php echo GLOBAL_WEBSITE::SAPDS_ORG_URL_DISPLAY ?></a> and its affinity sites.</p>

                        <ul class="lead">
                            <li><?php echo GLOBAL_WEBSITE::SAPDS_ORG_URL_DISPLAY ?> and its affinity sites are FREE web sites providing important SAP technical objects data sheet and analytics.</li>
                            <li>We are trying the best to constantly improve these sites to provide more useful information.</li>
                            <li>We are trying the best to constantly review the contents to avoid errors.</li>
                            <li>If you have any requirements, suggestion, problem, or feedback, we can hear from you from <a target="_blank" href="https://github.com/sapdatasheet/sapdatasheet/issues"><b>here</b></a>.</li>
                        </ul>
                        
                        <h4>Current list of sites:</h4>
                        <ul class="lead">
                            <li><a href="<?php echo GLOBAL_WEBSITE::SAPDS_ORG_URL ?>" target="_blank" title="<?php echo GLOBAL_WEBSITE::SAPDS_ORG_DESC ?>"><?php echo GLOBAL_WEBSITE::SAPDS_ORG_URL_DISPLAY ?></a>, <?php echo GLOBAL_WEBSITE::SAPDS_ORG_DESC ?></li>
                            <li><a href="<?php echo GLOBAL_WEBSITE::SAP_TABLES_ORG_URL ?>" target="_blank" title="<?php echo GLOBAL_WEBSITE::SAP_TABLES_ORG_DESC ?>"><?php echo GLOBAL_WEBSITE::SAP_TABLES_ORG_URL_DISPLAY ?></a>, <?php echo GLOBAL_WEBSITE::SAP_TABLES_ORG_DESC ?></li>
                            <li><a href="<?php echo GLOBAL_WEBSITE::SAP_TCODES_ORG_URL ?>" target="_blank" title="<?php echo GLOBAL_WEBSITE::SAP_TCODES_ORG_DESC ?>"><?php echo GLOBAL_WEBSITE::SAP_TCODES_ORG_URL_DISPLAY ?></a>, <?php echo GLOBAL_WEBSITE::SAP_TCODES_ORG_DESC ?></li>
                        </ul>

                        <hr>
                        <p class="mb-0">Enjoy</p>
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
