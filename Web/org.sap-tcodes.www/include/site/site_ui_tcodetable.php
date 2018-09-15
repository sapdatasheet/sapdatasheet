<!-- Show an HTML Table for T-Codes -->
<!-- $table_id - ID of the Table -->
<!-- $tcode_list - Array of TCodes -->
<!-- $tcode_count - Number of TCodes in DB -->

<div class="table-responsive">
<table id="<?php echo $table_id ?>" class="table table-striped table-hover">
    <thead>
        <tr>
            <th>TCode</th>
            <th>Description</th>
            <th>Module</th>
            <th>Top Module</th>
            <th>Component</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($tcode_list as $tcode_item) { ?>
            <tr><td><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeTRAN(TRUE) ?>
                    <?php echo ABAP_UI_TCODES_Navigation::TCodeHyperlink($tcode_item['TCODE']) ?>
                    <?php echo ABAP_UI_DS_Navigation::GetObjectHyperlink4DS(GLOBAL_ABAP_OTYPE::TRAN_NAME, $tcode_item['TCODE'], NULL, FALSE) ?>
                </td>
                <td><?php echo htmlentities(ABAP_DB_TABLE_TRAN::TSTCT($tcode_item['TCODE'])) ?></td>
                <td><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeBMFR(TRUE) ?>
                    <?php echo ABAP_UI_TCODES_Navigation::AnalyticsModuleHyperlink($tcode_item['APPLPOSID']); ?>
                    <?php echo ABAP_UI_DS_Navigation::GetObjectHyperlink4DS(
                            GLOBAL_ABAP_OTYPE::BMFR_NAME, ABAPANA_DB_TABLE::ABAPBMFR_POSID_2_FCTR($tcode_item['APPLPOSID']), NULL, FALSE)
                    ?>
                </td>
                <td><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeBMFR(TRUE) ?>
                    <?php echo ABAP_UI_TCODES_Navigation::AnalyticsModuleHyperlink($tcode_item['PS_POSID_L1']); ?>
                    <?php echo ABAP_UI_DS_Navigation::GetObjectHyperlink4DS(
                            GLOBAL_ABAP_OTYPE::BMFR_NAME, ABAPANA_DB_TABLE::ABAPBMFR_POSID_2_FCTR($tcode_item['PS_POSID_L1']), NULL, FALSE)
                    ?>
                </td>
                <td><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeCVERS(TRUE) ?>
                    <?php echo ABAP_UI_TCODES_Navigation::AnalyticsCompHyperlink($tcode_item['SOFTCOMP']); ?>
            <?php echo ABAP_UI_DS_Navigation::GetObjectHyperlink4DS(GLOBAL_ABAP_OTYPE::CVERS_NAME, $tcode_item['SOFTCOMP'], NULL, FALSE); ?>
                </td>
            </tr>
<?php } ?>
    </tbody>
</table>
</div>
    
<?php if ($tcode_count > ABAP_DB_CONST::MAX_ROWS_LIMIT) { ?>
    </div>
    <div class="card-footer">
        <strong><?php echo number_format(ABAP_DB_CONST::MAX_ROWS_LIMIT) ?></strong> of <strong><?php echo number_format($tcode_count) ?></strong> tcodes loaded.
        We did not load the full list for performance considerations. 
        <br>You may choose to download the <?php echo GLOBAL_ABAP_ICON::getIcon4FilePDF(TRUE) ?> <strong><a href="/download/book/" target="_blank">Books</a></strong> or <?php echo  GLOBAL_ABAP_ICON::getIcon4FileXLSX(TRUE)?> <strong><a href="/download/sheet/" target="_blank">Sheets</a></strong> to get the full list.
<?php } ?>
