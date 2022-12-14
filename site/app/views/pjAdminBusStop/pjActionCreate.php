<?php
//vd($tpl);

    pjUtil::printNotice(__('infoAddBusTypeTitle', true, false), __('infoAddBusTypeDesc', true, false));
	?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminBusStop&amp;action=pjActionCreate" method="post" id="frmCreateBusType" class="pj-form form" enctype="multipart/form-data">
    <input type="hidden" name="bus_stop_create" value="1" />

    <?php if ((int) $tpl['option_arr']['o_multi_lang'] === 1 && count($tpl['lp_arr']) > 1) : ?>
        <div class="multilang b10"></div>
    <?php endif;?>
    
        <div class="clear_both">

            <div class="bs-location-row" data-index="<?php echo $index; ?>">
                <p>
                    <label class="title bs-title-<?php echo $index; ?>"><?php __('lblLocation'); ?> :</label>
                    <span class="inline_block">
                        <select name="location_id" class="pj-form-field w300 required bs-city">
                            <option value="">-- <?php __('lblChoose'); ?>--</option>
                            <?php
                            foreach ($tpl['city_arr'] as $k => $v) {
                                ?><option value="<?php echo $v['id']; ?>"><?php echo pjSanitize::clean($v['name']); ?></option><?php
                            }
                            ?>
                        </select>
                    </span>
                </p>
                <div class="location-icons">
                    <a href="javascript:void(0);" class="location-delete-icon"></a>
                    <a href="javascript:void(0);" class="location-move-icon"></a>
                </div>
            </div>
        
        
        
        <?php
            foreach ($tpl['lp_arr'] as $v)
            {
            ?>
                    <p class="pj-multilang-wrap" data-index="<?php echo $v['id']; ?>" style="display: <?php echo (int) $v['is_default'] === 0 ? 'none' : NULL; ?>">
                            <label class="title">Назва:</label>
                            <span class="inline_block">
                                
                                
                                    <input type="text" name="i18n[<?php echo $v['id']; ?>][name]" class="pj-form-field w300 required" required lang="<?php echo $v['id']; ?>" />
                                   

                                     <?php if ((int) $tpl['option_arr']['o_multi_lang'] === 1 && count($tpl['lp_arr']) > 1) : ?>
                                    <span class="pj-multilang-input"><img src="<?php echo PJ_INSTALL_URL . PJ_FRAMEWORK_LIBS_PATH . 'pj/img/flags/' . $v['file']; ?>" alt="" /></span>
                                    <?php endif;?>
                            </span>
                    </p>
                    
                    
                    <p class="pj-multilang-wrap" data-index="<?php echo $v['id']; ?>" style="display: <?php echo (int) $v['is_default'] === 0 ? 'none' : NULL; ?>">
                            <label class="title">Адреса:</label>
                            <span class="inline_block">
                                
                                
                                    <input type="text" name="i18n[<?php echo $v['id']; ?>][address]" class="pj-form-field w300 required" required lang="<?php echo $v['id']; ?>" />
                                   

                                     <?php if ((int) $tpl['option_arr']['o_multi_lang'] === 1 && count($tpl['lp_arr']) > 1) : ?>
                                    <span class="pj-multilang-input"><img src="<?php echo PJ_INSTALL_URL . PJ_FRAMEWORK_LIBS_PATH . 'pj/img/flags/' . $v['file']; ?>" alt="" /></span>
                                    <?php endif;?>
                            </span>
                    </p>
                    <?php
            }
            ?>
        

        <p>
            <label class="title">&nbsp;</label>
            <input type="submit" value="<?php __('btnSave'); ?>" class="pj-button" />
            <input type="button" value="<?php __('btnCancel'); ?>" class="pj-button" onclick="window.location.href='<?php echo PJ_INSTALL_URL; ?>index.php?controller=pjAdminBusTypeOptions&action=pjActionIndex';" />
        </p>
    </div>
</form>
	
	<script type="text/javascript">
	var locale_array = new Array(); 
	var myLabel = myLabel || {};
	myLabel.field_required = "<?php __('bs_field_required'); ?>";
	<?php
	foreach ($tpl['lp_arr'] as $v)
	{
		?>locale_array.push(<?php echo $v['id'];?>);<?php
	} 
	?>
	myLabel.locale_array = locale_array;
	myLabel.localeId = "<?php echo $controller->getLocaleId(); ?>";
	(function ($) {
		$(function() {
			$(".multilang").multilang({
				langs: <?php echo $tpl['locale_str']; ?>,
				flagPath: "<?php echo PJ_FRAMEWORK_LIBS_PATH; ?>pj/img/flags/",
				select: function (event, ui) {
					
				}
			});
		});
	})(jQuery_1_8_2);
	</script>