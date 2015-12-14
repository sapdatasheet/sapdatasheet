<?php
$__ROOT__ = dirname(dirname(dirname(__FILE__)));
require_once ($__ROOT__ . '/include/global.php');
require_once ($__ROOT__ . '/include/abap_db.php');
require_once ($__ROOT__ . '/include/abap_ui.php');
GLOBAL_UTIL::UpdateSAPDescLangu();

// Get Index
if (!isset($index)) {
    if (php_sapi_name() == 'cli') {
        $index = $argv[1];
        $GLOBALS[GLOBAL_UTIL::SAP_DESC_LANGU] = $argv[2];
    } else {
        $index = filter_input(INPUT_GET, 'index');
    }
}

if (strlen(trim($index)) == 0) {
    $index = ABAP_DB_CONST::INDEX_PAGE_1;
}

// Check Buffer
$ob_folder = GLOBAL_UTIL::GetObFolder(dirname(__FILE__));
if (file_exists($ob_folder) == FALSE) {
    mkdir($ob_folder);
}
$ob_fname = $ob_folder . "/index-" . strtolower($index) . ".html";
if (file_exists($ob_fname)) {
    $ob_file_content = file_get_contents($ob_fname);
    if ($ob_file_content !== FALSE) {
        echo $ob_file_content;
        exit();
    }
}
ob_start();
?>
<!DOCTYPE html>
<!-- ABAP OO Class index. -->
<?php
$page_label = "Page " . $index . " of " . ABAP_DB_TABLE_SEO::SEOCLASS_CLAS_INDEX_MAX;
$GLOBALS['TITLE_TEXT'] = "SAP ABAP " . ABAP_OTYPE::CLAS_DESC . " - Index " . $page_label;
$clas_list = ABAP_DB_TABLE_SEO::SEOCLASS_List(ABAP_DB_TABLE_SEO::SEOCLASS_CLSTYPE_CLAS, $index);
?>
<html>
    <head>
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" href="/abap.css" type="text/css" />
        <title><?php echo $GLOBALS['TITLE_TEXT'] ?> <?php echo WEBSITE::TITLE ?> </title>
        <meta name="keywords" content="SAP,ABAP,<?php echo ABAP_OTYPE::CLAS_DESC ?>" />
        <meta name="description" content="<?php echo WEBSITE::META_DESC ?>" />
        <meta name="author" content="SAP Datasheet" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    </head>
    <body>

        <!-- Header -->
        <?php require $__ROOT__ . '/include/header.php' ?>

        <!-- Left -->
        <?php require $__ROOT__ . '/include/abap_index_left.php' ?>

        <!-- Content -->
        <div class="content">
            <!-- Content Navigator -->
            <div class="content_navi">
                <a href="/">Home page</a> &gt; 
                <a href="/abap/">ABAP Object</a> &gt; 
                <a href="/abap/clas/"><?php echo ABAP_OTYPE::CLAS_DESC ?></a> 
            </div>

            <!-- Content Object -->
            <div class="content_obj_title"><span><?php echo $GLOBALS['TITLE_TEXT'] ?></span></div>
            <div class="content_obj">        
                <div>
                    <?php include $__ROOT__ . '/include/google/adsense-content-top.html' ?>
                </div>

                <div>
                    <?php for ($count = 1; $count <= ABAP_DB_TABLE_SEO::SEOCLASS_CLAS_INDEX_MAX; $count++) { ?>
                        <a href="index-<?php echo $count ?>.html"><?php echo $count ?></a>&nbsp;
                    <?php } ?>
                </div>

                <h4> <?php echo ABAP_OTYPE::CLAS_DESC ?> - <?php echo $page_label ?></h4>
                <table class="alv">
                    <tr>
                        <th class="alv"> # </th>
                        <th class="alv"> Class Name </th>
                        <th class="alv"> Short Description </th>
                        <th class="alv"> Package </th>
                    </tr>
                    <tr>
                        <th class="alv"><?php echo ABAP_Navigation::GetURLDtelDocument(ABAP_DB_CONST::INDEX_SEQNO_DTEL, '?') ?></th>
                        <th class="alv"><?php echo ABAP_Navigation::GetURLDtelDocument(ABAP_DB_TABLE_SEO::SEOCLASS_CLSNAME_DTEL, '?') ?></th>
                        <th class="alv"><?php echo ABAP_Navigation::GetURLDtelDocument(ABAP_DB_TABLE_SEO::SEOCLASSTX_DESCRIPT_DTEL, '?') ?></th>
                        <th class="alv"><?php echo ABAP_Navigation::GetURLDtelDocument(ABAP_DB_TABLE_HIER::TADIR_DEVCLASS_DTEL, '?') ?></th>
                    </tr>
                    <?php
                    $count = 0;
                    foreach ($clas_list as $clas) {
                        $count++;
                        $clas_tx = ABAP_DB_TABLE_SEO::SEOCLASSTX($clas['CLSNAME']);
                        $tadir = ABAP_DB_TABLE_HIER::TADIR(ABAP_DB_TABLE_HIER::TADIR_PGMID_R3TR, ABAP_OTYPE::CLAS_NAME, $clas['CLSNAME']);
                        ?>
                        <tr><td class="alv" style="text-align: right;"><?php echo number_format($count) ?> </td>
                            <td class="alv"><?php echo ABAP_Navigation::GetURLClass($clas['CLSNAME'], $clas_tx) ?></td>
                            <td class="alv"><?php echo $clas_tx ?></td>
                            <td class="alv"><?php echo ABAP_Navigation::GetURLPackage($tadir['DEVCLASS'], NULL) ?>&nbsp;</td>
                        </tr>
                    <?php } ?>
                </table>

            </div>
        </div><!-- Content: End -->        

        <!-- Footer -->
        <?php require $__ROOT__ . '/include/footer.php' ?>

    </body>
</html>
<?php
$ob_content = ob_get_contents();
ob_end_flush();
file_put_contents($ob_fname, $ob_content);

// Make default index file
if ($index == ABAP_DB_CONST::INDEX_PAGE_1) {
    $ob_fname = $ob_folder . "/index.html";
    file_put_contents($ob_fname, $ob_content);
}

// Close Database Connection
ABAP_DB_TABLE::close_conn();
