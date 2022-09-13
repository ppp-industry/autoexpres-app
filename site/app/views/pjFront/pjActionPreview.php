<?php
$STORE = @$_SESSION[$controller->defaultStore];
$FORM = @$_SESSION[$controller->defaultForm];
$booked_data = $STORE['booked_data'];

include PJ_VIEWS_PATH . 'pjFront/elements/locale.php';
include PJ_VIEWS_PATH . 'pjFront/elements/header.php';

$sub_total = 0;
$tax = 0;
$total = 0;
$deposit = 0;

$front_messages = __('front_messages', true, false);
?>
<div class="bsContainerInner">
	<?php
	if($tpl['status'] == 'OK')
	{ 
		?>
		<form id="bsPreviewForm_<?php echo $_GET['index'];?>" action="" method="post" class="bsPreviewForm">
			<input type="hidden" name="step_preview" value="1" />
			
			<div class="bsHeading"><?php __('front_booking_details');?></div>
			<div class="bsBookingDetail">
				<div class="bsOuterBox">
					<div class="bsJourneyBox bsInnerBox">
						<label><?php __('front_journey');?></label>
						<div class="bsPair">
							<?php __('front_date');?>: <span><?php echo $STORE['date'];?></span> <a class="bsChangeDate" href="javascript:void(0);"><?php __('front_link_change_date');?></a>
						</div>
						<div class="bsPair">
							<?php __('front_departure_from');?>: <br/><span><?php echo $tpl['from_location']?> <?php __('front_at');?> <?php echo $tpl['bus_arr']['departure_time'];?></span>
						</div>
						<div class="bsPair">
							<?php __('front_arrive_to');?>: <br/><span><?php echo $tpl['to_location']?> <?php __('front_at');?> <?php echo $tpl['bus_arr']['arrival_time'];?></span>
						</div>
						<div class="bsPair">
							<?php __('front_bus');?>: <br/><span><?php echo $tpl['bus_arr']['route_title'];?></span>
						</div>
					</div>
				</div>
				<div class="bsOuterBox">
					<div class="bsTicketBox bsInnerBox">
						<label><?php __('front_tickets');?></label>
						<div class="bsPair">
							<?php __('front_tickets');?>: <br/>
							<?php 
							foreach($tpl['ticket_arr'] as $k => $v)
							{
								if(isset($booked_data['ticket_cnt_' . $v['ticket_id']]) && $booked_data['ticket_cnt_' . $v['ticket_id']] > 0)
								{
									?>
									<span><?php echo $booked_data['ticket_cnt_' . $v['ticket_id']];?> <?php echo $v['ticket'];?> x <?php echo pjUtil::formatCurrencySign($v['price'], $tpl['option_arr']['o_currency']);?></span><br/>
									<?php
									$sub_total += $booked_data['ticket_cnt_' . $v['ticket_id']] * $v['price'];
								}
							}
							if(!empty($tpl['option_arr']['o_tax_payment']) && $sub_total > 0)
							{
								$tax = ($tpl['option_arr']['o_tax_payment'] * $sub_total) / 100;
							}
							$total = $sub_total + $tax;
							if(!empty($tpl['option_arr']['o_deposit_payment']) && $total > 0)
							{
								$deposit = ($tpl['option_arr']['o_deposit_payment'] * $total) / 100;
							}
							?>
							<a class="bsChangeSeat" href="javascript:void(0);"><?php __('front_link_change_seats');?></a>
						</div>
						<?php
						if(!empty($tpl['selected_seat_arr']))
						{ 
							?>
							<div class="bsPair">
								<?php echo ucfirst(__('front_seats', true, false));?>: <br/><span><?php echo join(", ", $tpl['selected_seat_arr']);?></span>
							</div>
							<?php
						} 
						?>
						
					</div>
				</div>
				<div class="bsOuterBox">
					<div class="bsPaymentBox bsInnerBox">
						<label><?php __('front_payment');?></label>
						<div class="bsPairHorizontal"><span class="bsTitle"><?php __('front_tickets_total');?></span><span class="bsContent"><?php echo pjUtil::formatCurrencySign(number_format($sub_total, 2), $tpl['option_arr']['o_currency']);?></span></div>
						<div class="bsPairHorizontal"><span class="bsTitle"><?php __('front_tax');?></span><span class="bsContent"><?php echo pjUtil::formatCurrencySign(number_format($tax, 2), $tpl['option_arr']['o_currency']);?></span></div>
						<div class="bsPairHorizontal"><span class="bsTitle"><?php __('front_total');?></span><span class="bsContent"><?php echo pjUtil::formatCurrencySign(number_format($total, 2), $tpl['option_arr']['o_currency']);?></span></div>
						<div class="bsPairHorizontal"><span class="bsTitle"><?php __('front_deposit');?></span><span class="bsContent"><?php echo pjUtil::formatCurrencySign(number_format($deposit, 2), $tpl['option_arr']['o_currency']);?></span></div>
					</div>
				</div>
			</div>
			<input type="hidden" name="sub_total" value="<?php echo $sub_total;?>" />
			<input type="hidden" name="tax" value="<?php echo $tax;?>" />
			<input type="hidden" name="total" value="<?php echo $total;?>" />
			<input type="hidden" name="deposit" value="<?php echo $deposit;?>" />
			<div class="bsLine"></div>
			
			<div class="bsHeading"><?php __('front_personal_details');?></div>
			<?php 
			if (in_array($tpl['option_arr']['o_bf_include_title'], array(2, 3))){ 
				?>
				<div class="bsFormRow">
					<div class="bsFormItemLabel"><?php __('front_label_title'); ?>:</div>
					<div class="bsFormItemValue">
						<?php
						$title_arr = pjUtil::getTitles();
						$name_titles = __('peronal_titles', true, false);
						echo $name_titles[$FORM['c_title']];
						?>
					</div>
				</div>
				<?php
			}
			if (in_array($tpl['option_arr']['o_bf_include_fname'], array(2, 3))){ 
				?>
				<div class="bsFormRow">
					<div class="bsFormItemLabel"><?php __('front_label_fname'); ?>:</div>
					<div class="bsFormItemValue">
						<?php echo isset($FORM['c_fname']) ? pjSanitize::clean($FORM['c_fname']) : null;?>
					</div>
				</div>
				<?php
			}
			if (in_array($tpl['option_arr']['o_bf_include_lname'], array(2, 3))){ 
				?>
				<div class="bsFormRow">
					<div class="bsFormItemLabel"><?php __('front_label_lname'); ?>:</div>
					<div class="bsFormItemValue">
						<?php echo isset($FORM['c_lname']) ? pjSanitize::clean($FORM['c_lname']) : null;?>
					</div>
				</div>
				<?php
			}
            if (in_array($tpl['option_arr']['o_bf_include_passport'], array(2, 3))){
                ?>
                <div class="bsFormRow">
                    <div class="bsFormItemLabel"><?php __('lblPassport'); ?>:</div>
                    <div class="bsFormItemValue">
                        <?php echo isset($FORM['passport']) ? pjSanitize::clean($FORM['passport']) : null;?>
                    </div>
                </div>
            <?php
            }
            if (in_array($tpl['option_arr']['o_bf_include_prodlocation'], array(2, 3))){
                ?>
                <div class="bsFormRow">
                    <div class="bsFormItemLabel"><?php __('lblProdLocation'); ?>:</div>
                    <div class="bsFormItemValue">
                        <?php echo isset($FORM['prod_location']) ? pjSanitize::clean($FORM['prod_location']) : null;?>
                    </div>
                </div>
            <?php
            }
			if (in_array($tpl['option_arr']['o_bf_include_phone'], array(2, 3))){ 
				?>
				<div class="bsFormRow">
					<div class="bsFormItemLabel"><?php __('front_label_phone'); ?>:</div>
					<div class="bsFormItemValue">
						<?php echo isset($FORM['c_phone']) ? pjSanitize::clean($FORM['c_phone']) : null;?>
					</div>
				</div>
				<?php
			}
			if (in_array($tpl['option_arr']['o_bf_include_email'], array(2, 3))){ 
				?>
				<div class="bsFormRow">
					<div class="bsFormItemLabel"><?php __('front_label_email'); ?>:</div>
					<div class="bsFormItemValue">
						<?php echo isset($FORM['c_email']) ? pjSanitize::clean($FORM['c_email']) : null;?>
					</div>
				</div>
				<?php
			}
			if (in_array($tpl['option_arr']['o_bf_include_company'], array(2, 3))){ 
				?>
				<div class="bsFormRow">
					<div class="bsFormItemLabel"><?php __('front_label_company'); ?>:</div>
					<div class="bsFormItemValue">
						<?php echo isset($FORM['c_company']) ? pjSanitize::clean($FORM['c_company']) : null;?>
					</div>
				</div>
				<?php
			}
			if (in_array($tpl['option_arr']['o_bf_include_notes'], array(2, 3))){ 
				?>
				<div class="bsFormRow">
					<div class="bsFormItemLabel"><?php __('front_label_notes'); ?>:</div>
					<div class="bsFormItemValue">
						<?php echo isset($FORM['c_notes']) ? nl2br(pjSanitize::clean($FORM['c_notes'])) : null;?>
					</div>
				</div>
				<?php
			}
			if (in_array($tpl['option_arr']['o_bf_include_address'], array(2, 3))){ 
				?>
				<div class="bsFormRow">
					<div class="bsFormItemLabel"><?php __('front_label_address'); ?>:</div>
					<div class="bsFormItemValue">
						<?php echo isset($FORM['c_address']) ? pjSanitize::clean($FORM['c_address']) : null;?>
					</div>
				</div>
				<?php
			}
			if (in_array($tpl['option_arr']['o_bf_include_city'], array(2, 3))){ 
				?>
				<div class="bsFormRow">
					<div class="bsFormItemLabel"><?php __('front_label_city'); ?>:</div>
					<div class="bsFormItemValue">
						<?php echo isset($FORM['c_city']) ? pjSanitize::clean($FORM['c_city']) : null;?>
					</div>
				</div>
				<?php
			}
			if (in_array($tpl['option_arr']['o_bf_include_state'], array(2, 3))){ 
				?>
				<div class="bsFormRow">
					<div class="bsFormItemLabel"><?php __('front_label_state'); ?>:</div>
					<div class="bsFormItemValue">
						<?php echo isset($FORM['c_state']) ? pjSanitize::clean($FORM['c_state']) : null;?>
					</div>
				</div>
				<?php
			}
			if (in_array($tpl['option_arr']['o_bf_include_zip'], array(2, 3))){ 
				?>
				<div class="bsFormRow">
					<div class="bsFormItemLabel"><?php __('front_label_zip'); ?>:</div>
					<div class="bsFormItemValue">
						<?php echo isset($FORM['c_zip']) ? pjSanitize::clean($FORM['c_zip']) : null;?>
					</div>
				</div>
				<?php
			}
			
			if (in_array($tpl['option_arr']['o_bf_include_country'], array(2, 3))){ 
				?>
				<div class="bsFormRow">
					<div class="bsFormItemLabel"><?php __('front_label_country'); ?>:</div>
					<div class="bsFormItemValue">
						<?php echo !empty($tpl['country_arr']) ? $tpl['country_arr']['country_title'] : null;?>
					</div>
				</div>
				<?php
			}
			if($tpl['option_arr']['o_payment_disable'] == 'No')
			{
				?>
				<div class="bsFormRow">
					<div class="bsFormItemLabel"><?php __('front_label_payment_medthod'); ?>:</div>
					<div class="bsFormItemValue">
						<?php 
						$payment_methods = __('payment_methods', true, false);
						echo $payment_methods[$FORM['payment_method']];
						?>
					</div>
				</div>
				<div id="bsCCData_<?php echo $_GET['index'];?>" style="display: <?php echo isset($FORM['payment_method']) && $FORM['payment_method'] == 'creditcard' ? 'block' : 'none'; ?>">
					<div class="bsFormRow">
						<div class="bsFormItemLabel"><?php __('front_label_cc_type'); ?>:</div>
						<div class="bsFormItemValue">
							<?php 
							$cc_types = __('cc_types', true, false);
							echo $cc_types[$FORM['cc_type']];
							?>
						</div>
					</div>
					<div class="bsFormRow">
						<div class="bsFormItemLabel"><?php __('front_label_cc_num'); ?>:</div>
						<div class="bsFormItemValue">
							<?php echo isset($FORM['cc_num']) ? pjSanitize::clean($FORM['cc_num']) : null;?>
						</div>
					</div>
					<div class="bsFormRow">
						<div class="bsFormItemLabel"><?php __('front_label_cc_exp'); ?>:</div>
						<div class="bsFormItemValue">
							<?php
							$month_arr = __('months', true, false);
							ksort($month_arr);
							echo $month_arr[$FORM['cc_exp_month']] . '-' . $FORM['cc_exp_year'];
							?>
						</div>
					</div>
					<div class="bsFormRow">
						<div class="bsFormItemLabel"><?php __('front_label_cc_code'); ?>:</div>
						<div class="bsFormItemValue">
							<?php echo isset($FORM['cc_code']) ? pjSanitize::clean($FORM['cc_code']) : null;?>
						</div>
					</div>
				</div>
				<?php
			} 
			?>
			<div class="bsLine bsT20"></div>
		</form>
		
		<div class="bsFormRow" style="display:none;">
			<div class="bsFormItemLabel">&nbsp;</div>
			<div class="bsFormItemValue">
				<div id="bsBookingMsg_<?php echo $_GET['index']?>" class="bsBookingMsg"></div>
			</div>
		</div>
		
		<div class="bsFormRow">
			<div class="bsFloatLeft">
				<button type="button" id="bsBtnBack4_<?php echo $_GET['index'];?>" class="bsSelectorButton bsButton bsButtonRed"><abbr class="left"></abbr><abbr class="middle"><?php __('front_button_back'); ?></abbr><abbr class="right"></abbr></button>
			</div>
			<div class="bsFloatRight">
				<button type="button" id="bsBtnConfirm_<?php echo $_GET['index'];?>" class="bsSelectorButton bsButton bsButtonBlue"><abbr class="left"></abbr><abbr class="middle"><?php __('front_button_confirm'); ?></abbr><abbr class="right"></abbr></button>
			</div>
			<input type="hidden" id="bsDate_<?php echo $_GET['index'];?>" value="<?php echo $STORE['date'];?>" />
			<input type="hidden" id="bsPickupId_<?php echo $_GET['index'];?>" value="<?php echo $STORE['pickup_id'];?>" />
			<input type="hidden" id="bsReturnId_<?php echo $_GET['index'];?>" value="<?php echo $STORE['return_id'];?>" />
			<?php
			$failed_msg = str_replace("[STAG]", "<a href='#' class='bsStartOver'>", $front_messages[6]);
			$failed_msg = str_replace("[ETAG]", "</a>", $failed_msg);  
			?>
			<input type="hidden" id="bsFailMessage_<?php echo $_GET['index'];?>" value="<?php echo $failed_msg;?>" />
		</div>
		<?php
	}else{
		?>
		<div class="bsSystemMessage">
			<?php
			$system_msg = str_replace("[STAG]", "<a href='#' class='bsStartOver'>", $front_messages[5]);
			$system_msg = str_replace("[ETAG]", "</a>", $system_msg); 
			echo $system_msg; 
			?>
		</div>
		<?php
	} 
	?>
</div>