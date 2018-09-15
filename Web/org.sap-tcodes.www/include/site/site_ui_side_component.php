<!-- All T-Codes by Level 1 Application Component -->
<div class="card">
	<div class="card-header bg-warning">TCodes by Each Component</div>
	<div class="card-body">
		<table class="table table-hover">
			<tbody>
            <?php foreach ( SITE_UI_ANALYTICS::AnaComp_DB2UI ( ABAPANA_DB_TABLE::ABAPTRAN_ANALYTICS_SOFTCOMP () ) as $comp ) {	?>
            <tr>
					<td><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeCVERS(TRUE) ?>
                        <a
						href="<?php echo $comp[SITE_UI_CONST::KEY_URL] ?>"
						title="<?php echo $comp[SITE_UI_CONST::KEY_CAPTION] ?>"
						target="_blank">
                            <?php echo $comp[SITE_UI_CONST::KEY_LABEL] ?></a>
					
					<td class="text-right"><span class="badge badge-warning">
                            <?php echo number_format($comp[SITE_UI_CONST::KEY_VALUE]) ?></span></td>
				</tr>
            <?php } ?>
        </tbody>
		</table>
	</div>
</div>