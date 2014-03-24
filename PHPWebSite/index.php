<!DOCTYPE html>
<?php require_once '/include/global.php'; ?>
<?php $GLOBALS['SearchTerm'] = "Company Code"; ?>

<html>
    <head>
        <link rel="stylesheet" href="abap.css" type="text/css" >
        <title><?php echo WEBSITE::NAME  ?> - <?php echo WEBSITE::DESC ?> </title>
        <meta name="keywords" content="SAP,ABAP">
        <meta name="description" content="<?php echo WEBSITE::META_DESC ?>">
        <meta name="author" content="SAP Datasheet">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
    </head>
    <body>
        <div class="headerlink">
            <a href="/abap/cvers"><?php echo ABAP_OTYPE::CVERS_DESC ?></a>
            <a href="/abap/bmfr"><?php echo ABAP_OTYPE::BMFR_DESC ?></a>
            <a href="/abap/devc"><?php echo ABAP_OTYPE::DEVC_DESC ?></a>
            <a href="/abap/tran"><?php echo ABAP_OTYPE::TRAN_DESC ?></a>
            <a href="/abap/prog"><?php echo ABAP_OTYPE::PROG_DESC ?></a>
            <a href="/abap/func"><?php echo ABAP_OTYPE::FUNC_DESC ?></a>
            <a href="/abap/tabl"><?php echo ABAP_OTYPE::TABL_DESC ?></a>
            <a href="/abap/sqlt"><?php echo ABAP_OTYPE::SQLT_DESC ?></a>
            <a href="/abap/view"><?php echo ABAP_OTYPE::VIEW_DESC ?></a>
            <a href="/abap/dtel"><?php echo ABAP_OTYPE::DTEL_DESC ?></a>
            <a href="/abap/doma"><?php echo ABAP_OTYPE::DOMA_DESC ?></a>
        </div>

        <div class="home_logo">
            <?php echo WEBSITE::NAME ?>
        </div>
        <div class="home_link">
            <a href="/abap/tran/"><b>T-Codes</b></a> |
            <a href="/abap/prog/"><b><?php echo ABAP_OTYPE::PROG_DESC ?></b></a> |
            <a href="/abap/func/"><b>BAPI</b></a> |
            <a href="/abap/tabl/"><b>Tables</b></a> |
            <a href="/abap/sqlt/"><b>Cluster Tables</b></a> |
            <a href="/abap/view/"><b>Views</b></a>
        </div>
        <div class="home_form">
            <form method="get" action="http://www.google.com/search" target="_blank">
                <input class="home_search_input" type="text" x-webkit-speech name="q" size="60" maxlength="255" value="<?php echo $GLOBALS['SearchTerm'] ?>" />
                <input type="hidden" name="sitesearch" value="sapdatasheet.org" />
                <input class="home_search_submit" type="submit" value="Search" />
            </form>
        </div>


        <div class="home_footer">
            <div>
                <a target="_blank" href="/site/PRIVACY.html"><b>PRIVACY</b></a> -
                <a target="_blank" href="/site/TERM.html"><b>TERMS OF USE</b></a> -
                <a target="_blank" href="/site/ABOUT.html"><b>ABOUT</b></a>
            </div>
            &copy; Copyright 2014 SAPDatasheet.org
        </div>

    </body>
</html>
