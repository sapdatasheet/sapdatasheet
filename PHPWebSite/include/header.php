<div class="header">

    <!-- Header Links -->
    <div class="headerlink">
        <a href="/abap/doma/"><b><?php echo ABAP_OTYPE::DOMA_DESC ?></b></a> |
        <a href="/abap/dtel/"><b><?php echo ABAP_OTYPE::DTEL_DESC ?></b></a> |
        <a href="/abap/tabl/"><b><?php echo ABAP_OTYPE::TABL_DESC ?></b></a> |
        <a href="/abap/sqlt/"><b><?php echo ABAP_OTYPE::SQLT_DESC ?></b></a> |
        <a href="/abap/view/"><b><?php echo ABAP_OTYPE::VIEW_DESC ?></b></a> |
        <a href="/abap/tran/"><b><?php echo ABAP_OTYPE::TRAN_DESC ?></b></a>
    </div>

    <!-- Header Text & Search -->
    <table class="headertitle" cellpadding="0">
        <tr>
            <!-- Icon (TODO) -->
            <td></td>
            <!-- Title -->
            <td>
                <div class="headertxt"><a class="headertxt" href="/"><span><?php echo  WEBSITE::NAME ?></span></a></div>
                <div class="headertxtsub"><span><?php echo  WEBSITE::DESC ?></span></div>
            </td>
            <!-- Search -->
            <td class="search">
                <form method="get" action="http://www.google.com/search" target="_blank">
                    <input type="text"   name="q" size="40" maxlength="255" value="<?php echo $GLOBALS['TITLE_TEXT'];  ?>" />
                    <input type="hidden" name="sitesearch" value="sapdatasheet.org" />
                    <input type="submit" value="Search" />
                </form>
            </td>

        </tr>
    </table>
</div> <!-- End of Header -->