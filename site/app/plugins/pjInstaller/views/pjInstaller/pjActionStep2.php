<?php
include dirname(__FILE__) . '/elements/progress.php';
$STORAGE = &$_SESSION[$controller->defaultInstaller];
?>
<div class="i-wrap">
	<?php
	$hasErrors = FALSE;
	if (isset($_GET['err']) && !empty($_GET['err']) && isset($_SESSION[$controller->defaultErrors][$_GET['err']]))
	{
		?>
		<div class="i-status i-status-error">
			<div class="i-status-icon"><abbr></abbr></div>
			<div class="i-status-txt">
				<h2>Installation error!</h2>
				<p class="t10"><?php echo @$_SESSION[$controller->defaultErrors][$_GET['err']]; ?></p>
			</div>
		</div>
		<?php
		$hasErrors = TRUE;
		$alert = array('status' => 'ERR', 'text' => strip_tags($_SESSION[$controller->defaultErrors][$_GET['err']]));
	}
	?>
	<p>Enter your client License key.</p>
	
	<form action="index.php?controller=pjInstaller&amp;action=pjActionStep3&amp;install=1" method="post" id="frmStep2" class="i-form">
		<input type="hidden" name="step2" value="1" />
	
		<table cellpadding="0" cellspacing="0" class="i-table t20">
			<thead>
				<tr>
					<th>License Key</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<p>
							<label class="i-title">Key <span class="i-red">*</span></label>
							<input type="text" tabindex="1" name="license_key" class="pj-form-field w300 required" value="<?php echo isset($STORAGE['license_key']) ? htmlspecialchars($STORAGE['license_key']) : "uvFW9nTYWAVS6756dfgs234fasQWV>LTYBbsdcv20MnsdfsASDQBgnTYJn"; ?>" />
						</p>
					</td>
				</tr>
			</tbody>
		</table>
		
		<div class="t20">
			<input type="submit" tabindex="2" value="Continue &raquo;" class="pj-button float_right l5" />
			<input type="button" tabindex="3" value="&laquo; Back" class="pj-button float_right" onclick="window.location='index.php?controller=pjInstaller&amp;action=pjActionStep1'" />
			<br class="clear_both" />
		</div>
	</form>
</div>