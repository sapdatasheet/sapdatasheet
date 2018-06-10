<!DOCTYPE html>
<!-- ABAP Object Types List -->
<?php
$__WS_ROOT__ = dirname(__FILE__, 2);
$__ROOT__ = dirname(__FILE__, 1);

require_once ($__WS_ROOT__ . '/common-php/library/global.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_ui.php');
GLOBAL_UTIL::UpdateSAPDescLangu();

$GLOBALS['TITLE_TEXT'] = "SAP ABAP";
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <title>SAP ABAP Objects <?php echo GLOBAL_WEBSITE::SAPDS_ORG_TITLE ?> </title>
        <meta name="author" content="SAP Datasheet" />
        <meta name="description" content="<?php echo GLOBAL_WEBSITE::SAPDS_ORG_META_DESC ?>" />
        <meta name="keywords" content="SAP,ABAP" />

        <link rel="stylesheet" type="text/css"  href="/3rdparty/bootstrap/css/bootstrap.min.css"/>
        <link rel="stylesheet" type="text/css"  href="/sapdatasheet.css"/>
    </head>
    <body>

        <!-- Header -->
        <?php require $__ROOT__ . '/include/header.php' ?>

        <main role="main">

            <div class="container-fluid pt-2">
                <div class="jumbotron text-white rounded bg-info">
                    <div class="container">
                        <h1 class="display-3">The #1 Online SAP Datasheet!</h1>
                        <p>WWW.SAPDatasheet.org is the <b>BEST</b> online SAP object repository. </p>
                        <p>The URL for each ABAP object is well formatted, and we can guess the location of your favorite object. Example: 
                        <ul>
                            <li><mark>https://www.sapdatasheet.org/abap/tabl/<code>bkpf</code>.html</mark> is the location for ABAP database table <mark><code>BKPF</code></mark>, while</li>
                            <li><mark>https://www.sapdatasheet.org/abap/tabl/<code>bseg</code>.html</mark> is the location for the table <mark><code>BSEG</code></mark></li>
                        </ul>
                        </p>
                        <p class="pt-4"><a class="btn btn-primary btn-lg" href="/abap/" role="button">ABAP Objects &raquo;</a></p>
                    </div>
                </div>
            </div>

            <div class="container">
                <!-- Example row of columns -->
                <div class="row">
                    <div class="col-md-6">
                        <h2>SAP Object Repository</h2>
                        <p>A site contains the major SAP ABAP Objects, including
                            <a href="/abap/cus0/"><b><?php echo GLOBAL_ABAP_OTYPE::CUS0_DESC ?></b></a>,
                            <a href="/abap/tran/"><b><?php echo GLOBAL_ABAP_OTYPE::TRAN_DESC ?></b></a>,
                            <a href="/abap/tabl/"><b><?php echo GLOBAL_ABAP_OTYPE::TABL_DESC ?></b></a>,
                            <a href="/abap/sqlt/"><b><?php echo GLOBAL_ABAP_OTYPE::SQLT_DESC ?></b></a>,
                            <a href="/abap/func/"><b><?php echo GLOBAL_ABAP_OTYPE::FUNC_DESC ?></b></a>,
                            <a href="/abap/dtel/"><b><?php echo GLOBAL_ABAP_OTYPE::DTEL_DESC ?></b></a>,
                            <a href="/abap/doma/"><b><?php echo GLOBAL_ABAP_OTYPE::DOMA_DESC ?></b></a>,
                            etc.
                        </p>
                        <p><a class="btn btn-secondary" href="/abap/" role="button">View details &raquo;</a></p>
                    </div>
                    <div class="col-md-6">
                        <h2>SAP Transaction Codes</h2>
                        <p>The Best Online SAP Transaction Code Analytics; Analytic on SAP TCodes by Module, Component, or Name; We can download SAP TCode Books and Sheets: 
                            <span class="text-nowrap"><?php echo GLOBAL_ABAP_ICON::getIcon4FilePDF() ?><a href="<?php echo ABAP_UI_TCODES_Navigation::DownloadBooks(TRUE) ?>" target="_blank">Download TCode Books</a></span>,
                            <span class="text-nowrap"><?php echo GLOBAL_ABAP_ICON::getIcon4FileXLSX() ?><a href="<?php echo ABAP_UI_TCODES_Navigation::DownloadSheets(TRUE) ?>" target="_blank">Download TCode Excels</a></span>.
                        </p>
                        <p><a class="btn btn-secondary" role="button" href="https://www.sap-tcodes.org/" target="_blank">View details &raquo;</a></p>
                    </div>
                    <!--
                        <div class="col-md-4">
                            <h2>&nbsp;</h2>
                            <p>&nbsp;</p>
                        </div>
                    -->
                </div>
            </div> <!-- /container -->

            <hr>
        </main>

        <!-- Footer -->
        <?php require $__ROOT__ . '/include/footer.php' ?>
    </body>
</html>
<?php
// Close PDO Database Connection
ABAP_DB_TABLE::close_conn();
