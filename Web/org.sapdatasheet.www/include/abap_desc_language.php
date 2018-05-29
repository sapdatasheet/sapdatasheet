<script src="/include/abap_desc_language.js"></script>
<div class="clearfix pt-1">
    <span class="float-right">
        <select class="form-control" title="Description Language" name="sap-desc-language" 
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
    </span>
</div>

