<?php
$__ROOT__ = dirname(dirname(dirname(__FILE__)));
require_once ($__ROOT__ . '/include/global.php');
require_once ($__ROOT__ . '/include/abap_db.php');
require_once ($__ROOT__ . '/include/abap_ui.php');
GLOBAL_UTIL::UpdateSAPDescLangu();

if (php_sapi_name() == 'cli') {
    $GLOBALS[GLOBAL_UTIL::SAP_DESC_LANGU] = $argv[1];
}
// Check Buffer
$ob_folder = GLOBAL_UTIL::GetObFolder(dirname(__FILE__));
$ob_fname = $ob_folder . "/index.html";
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
$GLOBALS['TITLE_TEXT'] = "SAP ABAP " . ABAP_OTYPE::MSAG_DESC . " Index ";
$msag_list = ABAP_DB_TABLE_MSAG::T100A_List();
?>
<html>
    <head>
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" href="/abap.css" type="text/css" />
        <title><?php echo $GLOBALS['TITLE_TEXT'] ?> <?php echo WEBSITE::TITLE ?> </title>
        <meta name="keywords" content="SAP,ABAP,<?php echo ABAP_OTYPE::MSAG_DESC ?>" />
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
                <a href="/abap/msag/"><?php echo ABAP_OTYPE::MSAG_DESC ?></a> 
            </div>

            <!-- Content Object -->
            <div class="content_obj_title"><span><?php echo $GLOBALS['TITLE_TEXT'] ?></span></div>
            <div class="content_obj">        
                <div>
                    <?php include $__ROOT__ . '/include/google/adsense-content-top.html' ?>
                </div>

                <h4> <?php echo ABAP_OTYPE::MSAG_DESC ?></h4>
                <table class="alv">
                    <tr>
                        <th class="alv"> # </th>
                        <th class="alv"> Message Class </th>
                        <th class="alv"> Short Description </th>
                        <th class="alv"> Package </th>
                    </tr>
                    <?php
                    $count = 0;
                    foreach ($msag_list as $msag) {
                        $count++;
                        $msag_t = ABAP_DB_TABLE_MSAG::T100T($msag['ARBGB']);
                        $tadir = ABAP_DB_TABLE_HIER::TADIR(ABAP_DB_TABLE_HIER::TADIR_PGMID_R3TR, ABAP_OTYPE::MSAG_NAME, $msag['ARBGB']);
                        ?>
                        <tr><td class="alv" style="text-align: right;"><?php echo number_format($count) ?> </td>
                            <td class="alv"><?php echo ABAP_Navigation::GetURLMessageClass($msag['ARBGB'], $msag_t) ?></td>
                            <td class="alv"><?php echo $msag_t ?></td>
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


// Close Database Connection
ABAP_DB_TABLE::close_conn();
?>