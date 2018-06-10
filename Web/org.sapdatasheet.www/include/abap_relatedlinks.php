<!-- Related Links at the page left -->
<h6 class="pt-4">Related Links</h6>
<div>
    <?php echo GLOBAL_ABAP_ICON::getIcon4FilePDF() ?>
    <a href="<?php echo ABAP_UI_TCODES_Navigation::DownloadBooks(TRUE) ?>" target="_blank"
       title="Download SAP Transaction Code Books in PDF format" >Download TCode Books
        <sup><img src="<?php echo ABAP_UI_CONST::ICON_EXTERNAL_LINK ?>"></sup>
    </a>
    <br>
    <?php echo GLOBAL_ABAP_ICON::getIcon4FileXLSX() ?>
    <a href="<?php echo ABAP_UI_TCODES_Navigation::DownloadSheets(TRUE) ?>" target="_blank"
       title="Download SAP Transaction Codes in Excel/CSV formats">Download TCode Excels
        <sup><img src="<?php echo ABAP_UI_CONST::ICON_EXTERNAL_LINK ?>"></sup>
    </a>
</div>

<h6 class="pt-4">Advertise Links</h6>
<?php include $__WS_ROOT__ . '/common-php/google/adsense-bottom.html' ?>
