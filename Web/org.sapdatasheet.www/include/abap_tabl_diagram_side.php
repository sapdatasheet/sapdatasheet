<h6 class="pt-4">SAP Table Diagram</h6>
<div>
    <?php 
    $tables_url_table = ABAP_UI_TABLES_Navigation::url_table($dd02l['TABNAME'], TRUE);
    $tables_desc_png = ABAP_UI_TABLES_Navigation::desc_erd_png($dd02l['TABNAME']);
    ?>
    <?php echo GLOBAL_ABAP_ICON::getIcon4Relation() ?>
    <a target="_blank" href="<?php echo $tables_url_table ?>"
       title="Dispaly SAP Table Relationship Diagram" >
        <?php echo $dd02l['TABNAME'] ?> Diagram <sup><img src="<?php echo ABAP_UI_CONST::ICON_EXTERNAL_LINK ?>"></sup>
    </a>
    <a href="<?php echo $tables_url_table ?>" target="_blank">
        <img class="img-fluid img-thumbnail mx-auto d-block"
             src="<?php echo ABAP_UI_TABLES_Navigation::uri_table_erd_png($dd02l['TABNAME'], TRUE) ?>"
             alt="<?php echo $tables_desc_png ?>"
             title="<?php echo $tables_desc_png ?>">
    </a>
</div>

