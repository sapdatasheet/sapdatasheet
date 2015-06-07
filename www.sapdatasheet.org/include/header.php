<script src="/include/header.js"></script>
<div class="header">

    <!-- Header Links -->
    <div class="headerlink">
        <a href="/abap/"><b>ALL</b></a> |
        <a href="/abap/doma/"><b><?php echo ABAP_OTYPE::DOMA_DESC ?></b></a> |
        <a href="/abap/dtel/"><b><?php echo ABAP_OTYPE::DTEL_DESC ?></b></a> |
        <a href="/abap/tabl/"><b><?php echo ABAP_OTYPE::TABL_DESC ?></b></a> |
        <a href="/abap/sqlt/"><b><?php echo ABAP_OTYPE::SQLT_DESC ?></b></a> |
        <a href="/abap/view/"><b><?php echo ABAP_OTYPE::VIEW_DESC ?></b></a> |
        <a href="/abap/tran/"><b><?php echo ABAP_OTYPE::TRAN_DESC ?></b></a> &nbsp;
        <select
            name="sap-desc-language" 
            title="Description Language"
            onfocus="langOnFocus(this);"
            onchange="langOnChnage(this);">
            <option value="N" <?php echo ($GLOBALS[GLOBAL_UTIL::SAP_DESC_LANGU] == "N") ? "selected=\"selected\"" : "" ?> >Nederlands (Dutch)</option>
            <option value="E" <?php echo ($GLOBALS[GLOBAL_UTIL::SAP_DESC_LANGU] == "E") ? "selected=\"selected\"" : "" ?> >English</option>
            <option value="F" <?php echo ($GLOBALS[GLOBAL_UTIL::SAP_DESC_LANGU] == "F") ? "selected=\"selected\"" : "" ?> >Français (French)</option>
            <option value="D" <?php echo ($GLOBALS[GLOBAL_UTIL::SAP_DESC_LANGU] == "D") ? "selected=\"selected\"" : "" ?> >Deutsch (German)</option>
            <option value="I" <?php echo ($GLOBALS[GLOBAL_UTIL::SAP_DESC_LANGU] == "I") ? "selected=\"selected\"" : "" ?> >Italiano (Italian)</option>
            <option value="J" <?php echo ($GLOBALS[GLOBAL_UTIL::SAP_DESC_LANGU] == "J") ? "selected=\"selected\"" : "" ?> >日本語 (Japanese)</option>
            <option value="3" <?php echo ($GLOBALS[GLOBAL_UTIL::SAP_DESC_LANGU] == "3") ? "selected=\"selected\"" : "" ?> >한국의 (Korean)</option>
            <option value="L" <?php echo ($GLOBALS[GLOBAL_UTIL::SAP_DESC_LANGU] == "L") ? "selected=\"selected\"" : "" ?> >Polski (Polish)</option>
            <option value="P" <?php echo ($GLOBALS[GLOBAL_UTIL::SAP_DESC_LANGU] == "P") ? "selected=\"selected\"" : "" ?> >Português (Portuguese)</option>
            <option value="R" <?php echo ($GLOBALS[GLOBAL_UTIL::SAP_DESC_LANGU] == "R") ? "selected=\"selected\"" : "" ?> >русский (Russian)</option>
            <option value="1" <?php echo ($GLOBALS[GLOBAL_UTIL::SAP_DESC_LANGU] == "1") ? "selected=\"selected\"" : "" ?> >简体中文 (Simplified Chinese)</option>
            <option value="S" <?php echo ($GLOBALS[GLOBAL_UTIL::SAP_DESC_LANGU] == "S") ? "selected=\"selected\"" : "" ?> >español (Spanish)</option>
            <option value="M" <?php echo ($GLOBALS[GLOBAL_UTIL::SAP_DESC_LANGU] == "M") ? "selected=\"selected\"" : "" ?> >正體中文 (Traditional Chinese)</option>
            <option value="T" <?php echo ($GLOBALS[GLOBAL_UTIL::SAP_DESC_LANGU] == "T") ? "selected=\"selected\"" : "" ?> >Türk (Turkish)</option>
        </select>
    </div>

    <!-- Header Text & Search -->
    <table class="headertitle"> 
        <tr>
            <!-- Title -->
            <td>
                <div class="headertxt"><a class="headertxt" href="/">
                        <img src="/sapdatasheet-middle.png"  alt="SAP Datasheet logo - Middle" />
                        <span><?php // echo  WEBSITE::NAME           ?></span>
                    </a></div>
                <div class="headertxtsub"><span><?php echo WEBSITE::DESC ?></span></div>
            </td>
            <!-- Search -->
            <td class="search">
                <form method="get" action="http://www.google.com/search" target="_blank">
                    <input type="text"   name="q" size="40" maxlength="255" value="<?php echo $GLOBALS['TITLE_TEXT']; ?>" />
                    <input type="hidden" name="sitesearch" value="sapdatasheet.org" />
                    <input type="submit" value="Search" /> 
                </form>
            </td>

        </tr>
    </table>
</div> <!-- End of Header -->
<div class="header">
    <?php include dirname(dirname(__FILE__)) . '/include/google/adsense-menu.html' ?>
</div> <!-- End of Menu -->