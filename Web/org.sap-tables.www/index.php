<?php
$__WS_ROOT__ = dirname(__FILE__, 2);
$__ROOT__ = dirname(__FILE__, 1);
require_once ($__WS_ROOT__ . '/common-php/library/global.php');
require_once ($__WS_ROOT__ . '/common-php/library/erd.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_db.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_ui.php');
GLOBAL_UTIL::UpdateSAPDescLangu();


$title = 'SAP ABAP Tables'
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <title><?php echo $title ?><?php echo GLOBAL_WEBSITE::SAP_TABLES_ORG_TITLE ?></title>
        <link rel="stylesheet" type="text/css"  href="/3rdparty/bootstrap/css/bootstrap.min.css"/>
    </head>
    <body>
        <div class="container-fluid bg-light">
            <h3 class="text-monospace pt-4">SAP ABAP Tables 
                <small><small><?php echo GLOBAL_WEBSITE::SAP_TABLES_ORG_DESC ?></small></small>
            </h3>

            <!-- TODO: Add a search box here -->
            <hr>
        </div>

        <main class="container-fluid table-responsive">
            <!-- Adver here -->

            <h5>Top Used SAP ABAP Tabys by Reference Count</h5>
            <p>For the <b><?php echo number_format(113102) ?></b> SAP tables, We count the total number of <code>where used list</code> for each of them, and rank the top <b><?php echo ABAP_DB_CONST::MAX_ROWS_LIMIT_SMALL ?></b> popular used SAP ABAP tables.</p>

            <div class="bg-light" title="Advertisement">
                <?php include $__WS_ROOT__ . '/common-php/google/adsense-content-top.html' ?>
            </div>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th class="border-bottom">Ranking</th>
                        <th class="border-bottom">Table</th>
                        <th class="border-bottom">Short Description</th>
                        <th class="border-bottom">Reference #</th>
                        <!-- TODO: Investigate if we need this or not <th class="border-bottom">Reference Details</th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $rank_id = 1;
                    foreach (ABAPANA_DB_TABLE::WULCOUNTER_Ranking_TABL() as $rank) {
                        ?>
                        <tr>
                            <td class="border-0"><?php echo $rank_id++ ?></td>
                            <td class="border-0 text-monospace">
                                <a href="<?php echo ABAP_UI_TABLES_Navigation::url_table($rank['TABNAME']) ?>"><span class="text-danger"><?php echo $rank['TABNAME'] ?></span></a>
                                <?php echo ABAP_UI_DS_Navigation::GetObjectHyperlink4DS(GLOBAL_ABAP_OTYPE::TABL_NAME, $rank['TABNAME'], NULL, FALSE) ?>
                            </td>
                            <td class="border-0 text-monospace"><?php echo ABAP_DB_TABLE_TABL::DD02T($rank['TABNAME']) ?></td>
                            <td class="border-0 text-right"><?php echo number_format($rank[ABAP_DB_CONST::COUNTER]) ?></td>
                            <!-- <td class="border-0">&nbsp;</td> -->
                        </tr>
                    <?php } ?>
                </tbody>
            </table>            

            <br><br><br><br>
        </main>

        <!-- Footer -->
        <?php require $__ROOT__ . '/include/footer.php' ?>
    </body>
</html>



