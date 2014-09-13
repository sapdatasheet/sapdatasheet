<!DOCTYPE html>
<?php 
define('__ROOT__', dirname(__FILE__)); 
require_once(__ROOT__ . '/include/global.php');
$GLOBALS['SearchTerm'] = "Company Code"; 
?>
<html>
    <head>
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" href="abap.css" type="text/css" />
        <title><?php echo WEBSITE::NAME ?> - <?php echo WEBSITE::DESC ?> </title>
        <meta name="keywords" content="SAP,ABAP" />
        <meta name="description" content="<?php echo WEBSITE::META_DESC ?>" />
        <meta name="author" content="SAP Datasheet" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    </head>
    <body>
        <div class="headerlink">
            <a href="/abap/"><b>ALL</b></a> |
            <a href="/abap/doma/"><b><?php echo ABAP_OTYPE::DOMA_DESC ?></b></a> |
            <a href="/abap/dtel/"><b><?php echo ABAP_OTYPE::DTEL_DESC ?></b></a> |
            <a href="/abap/tabl/"><b><?php echo ABAP_OTYPE::TABL_DESC ?></b></a> |
            <a href="/abap/sqlt/"><b><?php echo ABAP_OTYPE::SQLT_DESC ?></b></a> |
            <a href="/abap/view/"><b><?php echo ABAP_OTYPE::VIEW_DESC ?></b></a> |
            <a href="/abap/tran/"><b><?php echo ABAP_OTYPE::TRAN_DESC ?></b></a>
        </div>

        <div class="home_logo">
            <img src="/sapdatasheet-big.png"  alt="SAP Datasheet logo - Big" />
            <?php // echo WEBSITE::NAME ?>
        </div>
        <!--
        <div class="home_link">
            <a href="/abap/tran/"><b>T-Codes</b></a> |
            <a href="/abap/prog/"><b>Program</b></a> |
            <a href="/abap/func/"><b>BAPI</b></a> |
            <a href="/abap/tabl/"><b>Tables</b></a> |
            <a href="/abap/sqlt/"><b>Cluster Tables</b></a> |
            <a href="/abap/view/"><b>Views</b></a>
        </div>
        -->
        <div class="home_form">
            <form method="get" action="http://www.google.com/search" target="_blank">
                <input class="home_search_input" type="text" x-webkit-speech name="q" size="60" maxlength="255" value="<?php echo $GLOBALS['SearchTerm'] ?>" />
                <input type="hidden" name="sitesearch" value="sapdatasheet.org" />
                <input class="home_search_submit" type="submit" value="Search" />
            </form>
        </div>


        <div class="home_footer">
            <div>
                <a target="_blank" href="/site/privacy.html"><b>PRIVACY</b></a> -
                <a target="_blank" href="/site/term.html"><b>TERMS OF USE</b></a> -
                <a target="_blank" href="/site/about.html"><b>ABOUT</b></a>
            </div>
            &copy; Copyright 2014 SAPDatasheet.org
        </div>

    </body>
</html>
