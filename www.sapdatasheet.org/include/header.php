<script>
    function langOnFocus(obj) {
        obj._initValue = obj.value;
        window.alert(obj.value);
    }
    function langOnChnage(obj) {
        //if verify a change took place...
        if (obj._initValue === obj.value) {
            //do nothing, no actual change occurred...
            //or in your case if you want to make a minor update
            doMinorUpdate();
        } else {
            //change happened
            window.alert(obj.value);
        }
    }
</script>

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
            name="i18n-language" 
            title="Description Language"
            onfocus="langOnFocus(this);"
            onchange="langOnChnage(this);">
            <option value="N">(Dutch)</option>
            <option value="E" selected="selected">English</option>
            <option value="F">(French)</option>
            <option value="D">(German)</option>
            <option value="I">(Italian)</option>
            <option value="J">(Japanese)</option>
            <option value="3">(Korean)</option>
            <option value="L">(Polish)</option>
            <option value="P">(Portuguese)</option>
            <option value="R">(Russian)</option>
            <option value="1">(Simplified Chinese)</option>
            <option value="S">(Spanish)</option>
            <option value="M">(Traditional Chinese)</option>
            <option value="T">(Turkish)</option>
        </select>
    </div>

    <!-- Header Text & Search -->
    <table class="headertitle"> 
        <tr>
            <!-- Title -->
            <td>
                <div class="headertxt"><a class="headertxt" href="/">
                        <img src="/sapdatasheet-middle.png"  alt="SAP Datasheet logo - Middle" />
                        <span><?php // echo  WEBSITE::NAME      ?></span>
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