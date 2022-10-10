<?php

    pjUtil::printNotice(__('infoAddBusTypeTitle', true, false), __('infoAddBusTypeDesc', true, false));
	?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminBusTypeOptions&amp;action=pjActionCreate" method="post" id="frmCreateBusType" class="pj-form form" enctype="multipart/form-data">
    <input type="hidden" name="bus_type_create" value="1" />

    <div class="clear_both">

        <p>
            <label class="title">Назва</label>
            <span class="inline_block">
                <input type="text" name="name"  class="pj-form-field w80" />
            </span>
        </p>

        <p>
            <label class="title">&nbsp;</label>
            <input type="submit" value="<?php __('btnSave'); ?>" class="pj-button" />
            <input type="button" value="<?php __('btnCancel'); ?>" class="pj-button" onclick="window.location.href='<?php echo PJ_INSTALL_URL; ?>index.php?controller=pjAdminBusTypeOptions&action=pjActionIndex';" />
        </p>
    </div>
</form>
	
	