<!-- Bread crumb list -->
<!-- $title_bc_list: Bread crumbs list -->
<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
    <?php foreach ($title_bc_list as $breadcrumb) { ?>
        <li class="breadcrumb-item"
			<?php echo $breadcrumb[SITE_UI_CONST::KEY_CSS_CLASS] ?>>
            <?php echo $breadcrumb[SITE_UI_CONST::KEY_ICON_LINK] ?> <a
			href="<?php echo $breadcrumb[SITE_UI_CONST::KEY_URL] ?>"
			title="<?php echo $breadcrumb[SITE_UI_CONST::KEY_CAPTION] ?>"
			data-toggle="tooltip" data-placement="bottom" target="_blank"><?php echo $breadcrumb[SITE_UI_CONST::KEY_LABEL] ?></a>
		</li>
    <?php } ?>
  </ol>
</nav>