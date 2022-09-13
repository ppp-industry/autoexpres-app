<div class="bsLocale">
<?php
if (isset($tpl['locale_arr']) && is_array($tpl['locale_arr']) && !empty($tpl['locale_arr']))
{
	?>
	<ul class="bsLocaleMenu"><?php
	$locale_id = $controller->pjActionGetLocale();
	foreach ($tpl['locale_arr'] as $locale)
	{
		?><li><a href="#" class="bsSelectorLocale<?php echo $locale_id == $locale['id'] ? ' bsLocaleFocus' : NULL; ?>" data-id="<?php echo $locale['id']; ?>" title="<?php echo pjSanitize::html($locale['title']); ?>"><img src="<?php echo PJ_INSTALL_URL . 'core/framework/libs/pj/img/flags/' . $locale['file'] ?>" alt="<?php echo htmlspecialchars($locale['title']); ?>" /></a></li><?php
	}
	?>
	</ul>
	<?php
}
?>
</div>