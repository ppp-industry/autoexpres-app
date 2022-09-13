<?php
$week_start = isset($tpl['option_arr']['o_week_start']) && in_array((int) $tpl['option_arr']['o_week_start'], range(0,6)) ? (int) $tpl['option_arr']['o_week_start'] : 0;
$jqDateFormat = pjUtil::jqDateFormat($tpl['option_arr']['o_date_format']);

$STORE = @$_SESSION[$controller->defaultStore];

include PJ_VIEWS_PATH . 'pjFront/elements/locale.php';
include PJ_VIEWS_PATH . 'pjFront/elements/header.php';
?>

<div class="bsContainerInner bsSearchContainer">
	<form id="bsSearchForm_<?php echo $_GET['index'];?>" action="<?php echo PJ_INSTALL_URL; ?>index.php?controller=pjFront&amp;action=pjActionCheck" method="post" class="bsSelectorSearchForm">
		<div class="bsSearchItem">
			<div class="bsSearchItemLabel"><?php __('front_label_date'); ?>:</div>
			<div class="bsSearchItemValue"><input type="text" id="bsDate_<?php echo $_GET['index'];?>" name="date" class="bsSelectorDatepick bsText bsDatepicker" readonly="readonly" value="<?php echo isset($STORE) && isset($STORE['date']) ? htmlspecialchars($STORE['date']) : date($tpl['option_arr']['o_date_format']) ; ?>" data-dformat="<?php echo $jqDateFormat; ?>" data-fday="<?php echo $week_start; ?>"/></div>
		</div>
		<div class="bsSearchItem bsSearchItemChosen">
			<div class="bsSearchItemLabel"><?php __('front_label_from'); ?>:</div>
			<div id="bsPickupContainer_<?php echo $_GET['index'];?>" class="bsSearchItemValue">
				<select id="bsPickupId_<?php echo $_GET['index'];?>" name="pickup_id" class="bsSelect bsW200">
					<option value="">-- <?php __('front_choose'); ?>--</option>
					<?php
					foreach($tpl['from_location_arr'] as $k => $v)
					{
						?><option value="<?php echo $v['id'];?>"<?php echo isset($STORE['pickup_id']) && $STORE['pickup_id'] == $v['id'] ? ' selected="selected"' : null;?>><?php echo stripslashes($v['name']);?></option><?php
					} 
					?>
				</select>
			</div>
		</div>
		<div class="bsSearchItem bsSearchItemChosen">
			<div class="bsSearchItemLabel"><?php __('front_label_to'); ?>:</div>
			<div id="bsReturnContainer_<?php echo $_GET['index'];?>" class="bsSearchItemValue">
				<?php
				if(!isset($tpl['return_location_arr']))
				{ 
					?>
					<select id="bsReturnId_<?php echo $_GET['index'];?>" name="return_id" class="bsSelect bsW200">
						<option value="">-- <?php __('front_choose'); ?>--</option>
						<?php
						foreach($tpl['to_location_arr'] as $k => $v)
						{
							?><option value="<?php echo $v['id'];?>"<?php echo isset($STORE['return_id']) && $STORE['return_id'] == $v['id'] ? ' selected="selected"' : null;?>><?php echo stripslashes($v['name']);?></option><?php
						} 
						?>
					</select>
					<?php
				}else{
					?>
					<select id="bsReturnId_<?php echo $_GET['index'];?>" name="return_id" class="bsSelect bsW200">
						<option value="">-- <?php __('front_choose'); ?>--</option>
						<?php
						foreach($tpl['return_location_arr'] as $k => $v)
						{
							?><option value="<?php echo $v['id'];?>"<?php echo isset($STORE['return_id']) && $STORE['return_id'] == $v['id'] ? ' selected="selected"' : null;?>><?php echo stripslashes($v['name']);?></option><?php
						} 
						?>
					</select>
					<?php
				} 
				?>
			</div>
		</div>
		<div class="bsSearchItem bsCheckErrorMsg">
			<div class="bsSearchItemLabel">&nbsp;</div>
			<div class="bsSearchItemValue">
				<?php __('front_no_bus_available');?>
			</div>
		</div>
		<div class="bsSearchItem">
			<div class="bsSearchItemLabel">&nbsp;</div>
			<div class="bsSearchItemValue">
				<button type="submit" id="bsCheckAvail_<?php echo $_GET['index'];?>" class="bsSelectorButton bsButton bsButtonBlue"><abbr class="left"></abbr><abbr class="middle"><?php __('front_button_check_availability'); ?></abbr><abbr class="right"></abbr></button>
			</div>
		</div>
	</form>
	<div class="bsSearchContent">
		<?php
		if(!empty($tpl['content_arr']['image'][0]['value']))
		{
			?>
			<div class="bsContentImage"><img src="<?php echo PJ_INSTALL_URL . $tpl['content_arr']['image'][0]['value'];?>" /></div>
			<?php
		}
		?>
		<div class="bsContent">
			<?php echo nl2br(pjSanitize::clean($tpl['content_arr']['content'][0]['content']));?>
		</div>
	</div>
</div>