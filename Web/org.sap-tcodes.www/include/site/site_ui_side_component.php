<!-- All T-Codes by Level 1 Application Component -->
<div class="panel panel-success">
    <div class="panel-heading">TCodes by Each Component</div>
    <table class="table table-hover table-condensed">
        <tbody>
            <?php
            foreach (SITE_UI_ANALYTICS::AnaComp_DB2UI(ABAPANA_DB_TABLE::ABAPTRAN_ANALYTICS_SOFTCOMP()) as $comp) {
                ?>
            <tr><td><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeCVERS(TRUE) ?>
                        <a href="<?php echo $comp[SITE_UI_CONST::KEY_URL] ?>"
                           title="<?php echo $comp[SITE_UI_CONST::KEY_CAPTION] ?>" target="_blank">
                            <?php echo $comp[SITE_UI_CONST::KEY_LABEL] ?></a>
                    <td class="text-right"><span class="label label-success">
                            <?php echo number_format($comp[SITE_UI_CONST::KEY_VALUE]) ?></span></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>