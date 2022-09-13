<div class="bsHeader">
	<div class="bsHeaderAbove"></div>
	<div class="bsHeaderBelow"></div>
	
	<div class="bsHeaderSteps">
		<div class="bsStep1"><a class="bsStepLink bsStepClickable<?php echo $_GET['action'] == 'pjActionSearch' ? ' focus' : NULL; ?>" href="javascript:void(0);" data-step="1"><?php __('front_step_1');?></a><span class="bsStep<?php echo $_GET['action'] == 'pjActionSearch' ? ' focus' : NULL; ?><?php echo isset( $_SESSION[$controller->defaultStep]['1_passed']) && $_GET['action'] != 'pjActionSearch' ? ($_GET['action'] == 'pjActionDone' ? ' passed' : ' bsStepPassed') : NULL; ?>" data-step="1"></span></div>
		<div class="bsStep2"><a class="bsStepLink<?php echo $_GET['action'] == 'pjActionSeats' ? ' focus' : NULL; ?><?php echo isset( $_SESSION[$controller->defaultStep]['2_passed']) && $_GET['action'] != 'pjActionSeats' && $_GET['action'] != 'pjActionDone' ?  ' bsStepClickable' : NULL; ?>" href="javascript:void(0);" data-step="2"><?php __('front_step_2');?></a><span class="bsStep<?php echo $_GET['action'] == 'pjActionSeats' ? ' focus' : NULL; ?><?php echo isset( $_SESSION[$controller->defaultStep]['2_passed']) && $_GET['action'] != 'pjActionSeats' ? ($_GET['action'] == 'pjActionDone' ? ' passed' : ' bsStepPassed') : NULL; ?>" data-step="2"></span></div>
		<div class="bsStep3"><a class="bsStepLink<?php echo $_GET['action'] == 'pjActionCheckout' ? ' focus' : NULL; ?><?php echo isset( $_SESSION[$controller->defaultStep]['3_passed']) && $_GET['action'] != 'pjActionSeats' && $_GET['action'] != 'pjActionDone' ?  ' bsStepClickable' : NULL; ?>" href="javascript:void(0);" data-step="3"><?php __('front_step_3');?></a><span class="bsStep<?php echo $_GET['action'] == 'pjActionCheckout' ? ' focus' : NULL; ?><?php echo isset( $_SESSION[$controller->defaultStep]['3_passed']) && $_GET['action'] != 'pjActionCheckout' ? ($_GET['action'] == 'pjActionDone' ? ' passed' : ' bsStepPassed') : NULL; ?>" data-step="3"></span></div>
		<div class="bsStep4"><a class="bsStepLink<?php echo $_GET['action'] == 'pjActionPreview' ? ' focus' : NULL; ?>" href="javascript:void(0);" rel="5"><?php __('front_step_4');?></a><span class="bsStep<?php echo $_GET['action'] == 'pjActionPreview' ? ' focus' : NULL; ?>"></span></div>
	</div>
</div>
<?php
if(isset($_SESSION[$controller->defaultStep]['5_passed']) && $tpl['status'] == 'OK')
{
	unset($_SESSION[$controller->defaultStep]);
}					 
?>