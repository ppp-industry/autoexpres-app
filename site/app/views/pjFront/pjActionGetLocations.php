<?php
if(isset($_GET['pickup_id']))
{
	?>
	<select id="bsReturnId_<?php echo $_GET['index'];?>" name="return_id" class="bsSelect bsW200">
		<option value="">-- <?php __('front_choose'); ?>--</option>
		<?php
		foreach($tpl['location_arr'] as $k => $v)
		{
			?><option value="<?php echo $v['id'];?>"><?php echo stripslashes($v['name']);?></option><?php
		} 
		?>
	</select>
	<?php
}
if(isset($_GET['return_id']))
{
	?>
	<select id="bsPickupId_<?php echo $_GET['index'];?>" name="pickup_id" class="bsSelect bsW200">
		<option value="">-- <?php __('front_choose'); ?>--</option>
		<?php
		foreach($tpl['location_arr'] as $k => $v)
		{
			?><option value="<?php echo $v['id'];?>"><?php echo stripslashes($v['name']);?></option><?php
		} 
		?>
	</select>
	<?php
}
?>