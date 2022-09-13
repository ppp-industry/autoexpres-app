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
?>

<div class="bsContainerInner">
	<?php
	if($tpl['status'] == 'OK')
	{ 
		?>
		<form id="bsCheckoutForm_<?php echo $_GET['index'];?>" action="" method="post" class="bsCheckoutForm">
			<input type="hidden" name="step_checkout" value="1" />
			
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
					<div class="bsFormItemLabel"><?php __('front_label_title'); ?>&nbsp;<?php if($tpl['option_arr']['o_bf_include_title'] == 3){ ?><span class="bsFormStar">*</span><?php }?>:</div>
					<div class="bsFormItemValue">
						<select name="c_title" class="bsSelect<?php echo ($tpl['option_arr']['o_bf_include_title'] == 3) ? ' required' : NULL; ?>">
							<option value="">----</option>
							<?php
							$title_arr = pjUtil::getTitles();
							$name_titles = __('personal_titles', true, false);
							foreach ($title_arr as $v)
							{
								?><option value="<?php echo $v; ?>"<?php echo isset($FORM['c_title']) && $FORM['c_title'] == $v ? ' selected="selected"' : NULL; ?>><?php echo $name_titles[$v]; ?></option><?php
							}
							?>
						</select>
					</div>
				</div>
				<?php
			}
			if (in_array($tpl['option_arr']['o_bf_include_fname'], array(2, 3))){ 
				?>
				<div class="bsFormRow">
					<div class="bsFormItemLabel"><?php __('front_label_fname'); ?>&nbsp;<?php if($tpl['option_arr']['o_bf_include_fname'] == 3){ ?><span class="bsFormStar">*</span><?php }?>:</div>
					<div class="bsFormItemValue">
						<input type="text" name="c_fname" class="bsText bsW90p<?php echo ($tpl['option_arr']['o_bf_include_fname'] == 3) ? ' required' : NULL; ?>" value="<?php echo isset($FORM['c_fname']) ? pjSanitize::clean($FORM['c_fname']) : null;?>"/>
					</div>
				</div>
				<?php
			}
			if (in_array($tpl['option_arr']['o_bf_include_lname'], array(2, 3))){ 
				?>
				<div class="bsFormRow">
					<div class="bsFormItemLabel"><?php __('front_label_lname'); ?>&nbsp;<?php if($tpl['option_arr']['o_bf_include_lname'] == 3){ ?><span class="bsFormStar">*</span><?php }?>:</div>
					<div class="bsFormItemValue">
						<input type="text" name="c_lname" class="bsText bsW90p<?php echo ($tpl['option_arr']['o_bf_include_lname'] == 3) ? ' required' : NULL; ?>" value="<?php echo isset($FORM['c_lname']) ? pjSanitize::clean($FORM['c_lname']) : null;?>"/>
					</div>
				</div>
				<?php
			}
            if (in_array($tpl['option_arr']['o_bf_include_passport'], array(2, 3))){
                ?>
                <div class="bsFormRow">
                    <div class="bsFormItemLabel"><?php __('lblPassport'); ?>&nbsp;<?php if($tpl['option_arr']['o_bf_include_passport'] == 3){ ?><span class="bsFormStar">*</span><?php }?>:</div>
                    <div class="bsFormItemValue">
                        <input type="text" name="passport" class="bsText bsW90p<?php echo ($tpl['option_arr']['o_bf_include_passport'] == 3) ? ' required' : NULL; ?>" value="<?php echo isset($FORM['passport']) ? pjSanitize::clean($FORM['passport']) : null;?>"/>
                    </div>
                </div>
            <?php
            }
            if (in_array($tpl['option_arr']['o_bf_include_prodlocation'], array(2, 3))){
                ?>
                <div class="bsFormRow">
                    <div class="bsFormItemLabel"><?php __('lblProdLocation'); ?>&nbsp;<?php if($tpl['option_arr']['o_bf_include_prodlocation'] == 3){ ?><span class="bsFormStar">*</span><?php }?>:</div>
                    <div class="bsFormItemValue">
                        <input type="text" name="prod_location" class="bsText bsW90p<?php echo ($tpl['option_arr']['o_bf_include_prodlocation'] == 3) ? ' required' : NULL; ?>" value="<?php echo isset($FORM['prod_location']) ? pjSanitize::clean($FORM['prod_location']) : null;?>"/>
                    </div>
                </div>
            <?php
            }
			if (in_array($tpl['option_arr']['o_bf_include_phone'], array(2, 3))){ 
				?>
				<div class="bsFormRow">
					<div class="bsFormItemLabel"><?php __('front_label_phone'); ?>&nbsp;<?php if($tpl['option_arr']['o_bf_include_phone'] == 3){ ?><span class="bsFormStar">*</span><?php }?>:</div>
					<div class="bsFormItemValue">
						<input type="text" name="c_phone" class="bsText bsW90p<?php echo ($tpl['option_arr']['o_bf_include_phone'] == 3) ? ' required' : NULL; ?>" value="<?php echo isset($FORM['c_phone']) ? pjSanitize::clean($FORM['c_phone']) : null;?>"/>
					</div>
				</div>
				<?php
			}
			if (in_array($tpl['option_arr']['o_bf_include_email'], array(2, 3))){ 
				?>
				<div class="bsFormRow">
					<div class="bsFormItemLabel"><?php __('front_label_email'); ?>&nbsp;<?php if($tpl['option_arr']['o_bf_include_email'] == 3){ ?><span class="bsFormStar">*</span><?php }?>:</div>
					<div class="bsFormItemValue">
						<input type="text" name="c_email" class="bsText bsW90p email<?php echo ($tpl['option_arr']['o_bf_include_email'] == 3) ? ' required' : NULL; ?>" value="<?php echo isset($FORM['c_email']) ? pjSanitize::clean($FORM['c_email']) : null;?>"/>
					</div>
				</div>
				<?php
			}
			if (in_array($tpl['option_arr']['o_bf_include_company'], array(2, 3))){ 
				?>
				<div class="bsFormRow">
					<div class="bsFormItemLabel"><?php __('front_label_company'); ?>&nbsp;<?php if($tpl['option_arr']['o_bf_include_company'] == 3){ ?><span class="bsFormStar">*</span><?php }?>:</div>
					<div class="bsFormItemValue">
						<input type="text" name="c_company" class="bsText bsW90p<?php echo ($tpl['option_arr']['o_bf_include_company'] == 3) ? ' required' : NULL; ?>" value="<?php echo isset($FORM['c_company']) ? pjSanitize::clean($FORM['c_company']) : null;?>"/>
					</div>
				</div>
				<?php
			}
			if (in_array($tpl['option_arr']['o_bf_include_notes'], array(2, 3))){ 
				?>
				<div class="bsFormRow">
					<div class="bsFormItemLabel"><?php __('front_label_notes'); ?>&nbsp;<?php if($tpl['option_arr']['o_bf_include_notes'] == 3){ ?><span class="bsFormStar">*</span><?php }?>:</div>
					<div class="bsFormItemValue">
						<textarea name="c_notes" class="bsText bsH100 bsW90p<?php echo ($tpl['option_arr']['o_bf_include_notes'] == 3) ? ' required' : NULL; ?>"><?php echo isset($FORM['c_notes']) ? pjSanitize::clean($FORM['c_notes']) : null;?></textarea>
					</div>
				</div>
				<?php
			}
			if (in_array($tpl['option_arr']['o_bf_include_address'], array(2, 3))){ 
				?>
				<div class="bsFormRow">
					<div class="bsFormItemLabel"><?php __('front_label_address'); ?>&nbsp;<?php if($tpl['option_arr']['o_bf_include_address'] == 3){ ?><span class="bsFormStar">*</span><?php }?>:</div>
					<div class="bsFormItemValue">
						<input type="text" name="c_address" class="bsText bsW90p<?php echo ($tpl['option_arr']['o_bf_include_address'] == 3) ? ' required' : NULL; ?>" value="<?php echo isset($FORM['c_address']) ? pjSanitize::clean($FORM['c_address']) : null;?>"/>
					</div>
				</div>
				<?php
			}
			if (in_array($tpl['option_arr']['o_bf_include_city'], array(2, 3))){ 
				?>
				<div class="bsFormRow">
					<div class="bsFormItemLabel"><?php __('front_label_city'); ?>&nbsp;<?php if($tpl['option_arr']['o_bf_include_city'] == 3){ ?><span class="bsFormStar">*</span><?php }?>:</div>
					<div class="bsFormItemValue">
						<input type="text" name="c_city" class="bsText bsW90p<?php echo ($tpl['option_arr']['o_bf_include_city'] == 3) ? ' required' : NULL; ?>" value="<?php echo isset($FORM['c_city']) ? pjSanitize::clean($FORM['c_city']) : null;?>"/>
					</div>
				</div>
				<?php
			}
			if (in_array($tpl['option_arr']['o_bf_include_state'], array(2, 3))){ 
				?>
				<div class="bsFormRow">
					<div class="bsFormItemLabel"><?php __('front_label_state'); ?>&nbsp;<?php if($tpl['option_arr']['o_bf_include_state'] == 3){ ?><span class="bsFormStar">*</span><?php }?>:</div>
					<div class="bsFormItemValue">
						<input type="text" name="c_state" class="bsText bsW90p<?php echo ($tpl['option_arr']['o_bf_include_state'] == 3) ? ' required' : NULL; ?>" value="<?php echo isset($FORM['c_state']) ? pjSanitize::clean($FORM['c_state']) : null;?>"/>
					</div>
				</div>
				<?php
			}
			if (in_array($tpl['option_arr']['o_bf_include_zip'], array(2, 3))){ 
				?>
				<div class="bsFormRow">
					<div class="bsFormItemLabel"><?php __('front_label_zip'); ?>&nbsp;<?php if($tpl['option_arr']['o_bf_include_zip'] == 3){ ?><span class="bsFormStar">*</span><?php }?>:</div>
					<div class="bsFormItemValue">
						<input type="text" name="c_zip" class="bsText bsW90p<?php echo ($tpl['option_arr']['o_bf_include_zip'] == 3) ? ' required' : NULL; ?>" value="<?php echo isset($FORM['c_zip']) ? pjSanitize::clean($FORM['c_zip']) : null;?>"/>
					</div>
				</div>
				<?php
			}
			
			if (in_array($tpl['option_arr']['o_bf_include_country'], array(2, 3))){ 
				?>
				<div class="bsFormRow">
					<div class="bsFormItemLabel"><?php __('front_label_country'); ?>&nbsp;<?php if($tpl['option_arr']['o_bf_include_country'] == 3){ ?><span class="bsFormStar">*</span><?php }?>:</div>
					<div class="bsFormItemValue">
						<select name="c_country" class="bsSelect bsW90p<?php echo ($tpl['option_arr']['o_bf_include_country'] == 3) ? ' required' : NULL; ?>">
							<option value="">----</option>
							<?php
							foreach ($tpl['country_arr'] as $v)
							{
								?><option value="<?php echo $v['id']; ?>"<?php echo isset($FORM['c_country']) && $FORM['c_country'] == $v['id'] ? ' selected="selected"' : NULL; ?>><?php echo $v['country_title']; ?></option><?php
							}
							?>
						</select>
					</div>
				</div>
				<?php
			}
			if($tpl['option_arr']['o_payment_disable'] == 'No')
			{
				?>
				<div class="bsFormRow">
					<div class="bsFormItemLabel"><?php __('front_label_payment_medthod'); ?>&nbsp;<span class="bsFormStar">*</span>:</div>
					<div class="bsFormItemValue">
						<select id="bsPaymentMethod_<?php echo $_GET['index'];?>" name="payment_method" class="bsSelect required">
							<option value="">----</option>
							<?php
							foreach (__('payment_methods', true, false) as $k => $v)
							{
								if($tpl['option_arr']['o_allow_' . $k] == 'Yes')
								{
									?><option value="<?php echo $k; ?>"<?php echo isset($FORM['payment_method']) && $FORM['payment_method'] == $k ? ' selected="selected"' : NULL; ?>><?php echo $v; ?></option><?php
								}
							}
							?>
						</select>
					</div>
				</div>
				<div id="bsCCData_<?php echo $_GET['index'];?>" style="display: <?php echo isset($FORM['payment_method']) && $FORM['payment_method'] == 'creditcard' ? 'block' : 'none'; ?>">
					<div class="bsFormRow">
						<div class="bsFormItemLabel"><?php __('front_label_cc_type'); ?>&nbsp;<span class="bsFormStar">*</span>:</div>
						<div class="bsFormItemValue">
							<select name="cc_type" class="bsSelect required">
								<option value="">----</option>
								<?php
								foreach (__('cc_types', true, false) as $k => $v)
								{
									?><option value="<?php echo $k; ?>"<?php echo isset($FORM['cc_type']) && $FORM['cc_type'] == $k ? ' selected="selected"' : NULL; ?>><?php echo $v; ?></option><?php
								}
								?>
							</select>
						</div>
					</div>
					<div class="bsFormRow">
						<div class="bsFormItemLabel"><?php __('front_label_cc_num'); ?>&nbsp;<span class="bsFormStar">*</span>:</div>
						<div class="bsFormItemValue">
							<input type="text" name="cc_num" class="bsText bsW180 required" value="<?php echo isset($FORM['cc_num']) ? pjSanitize::clean($FORM['cc_num']) : null;?>" autocomplete="off"/>
						</div>
					</div>
					<div class="bsFormRow">
						<div class="bsFormItemLabel"><?php __('front_label_cc_exp'); ?>&nbsp;<span class="bsFormStar">*</span>:</div>
						<div class="bsFormItemValue">
							<select id="bsExpMonth_<?php echo $_GET['index'];?>" name="cc_exp_month" class="bsSelect required">
								<option value="">----</option>
								<?php
								$month_arr = __('months', true, false);
								ksort($month_arr);
								foreach ($month_arr as $key => $val)
								{
									?><option value="<?php echo $key;?>"<?php echo (int) @$FORM['cc_exp_month'] == $key ? ' selected="selected"' : NULL; ?>><?php echo $val;?></option><?php
								}
								?>
							</select>
							<select id="bsExpYear_<?php echo $_GET['index'];?>" name="cc_exp_year" class="bsSelect required">
								<option value="">----</option>
								<?php
								$y = (int) date('Y');
								for ($i = $y; $i <= $y + 10; $i++)
								{
									?><option value="<?php echo $i; ?>"<?php echo @$FORM['cc_exp_year'] == $i ? ' selected="selected"' : NULL; ?>><?php echo $i; ?></option><?php
								}
								?>
							</select>
						</div>
					</div>
					<div class="bsFormRow">
						<div class="bsFormItemLabel"><?php __('front_label_cc_code'); ?>&nbsp;<span class="bsFormStar">*</span>:</div>
						<div class="bsFormItemValue">
							<input type="text" name="cc_code" class="bsText bsW90 required" value="<?php echo isset($FORM['cc_code']) ? pjSanitize::clean($FORM['cc_code']) : null;?>" autocomplete="off"/>
						</div>
					</div>
				</div>
				<?php
			} 
			if (in_array($tpl['option_arr']['o_bf_include_captcha'], array(2, 3)))
			{
				?>
				<div class="bsFormRow">
					<div class="bsFormItemLabel"><?php __('front_label_captcha'); ?>&nbsp;<?php if($tpl['option_arr']['o_bf_include_captcha'] == 3){ ?><span class="bsFormStar">*</span><?php }?>:</div>
					<div class="bsFormItemValue">
						<input type="text" name="captcha" class="bsText bsFloatLeft bsR5 bsW90<?php echo ($tpl['option_arr']['o_bf_include_captcha'] == 3) ? ' required' : NULL; ?>" autocomplete="off"/>
						<img src="<?php echo PJ_INSTALL_FOLDER; ?>index.php?controller=pjFront&action=pjActionCaptcha&rand=<?php echo rand(1, 9999); ?>" alt="Captcha" style="border: solid 1px #E0E3E8;"/>
					</div>
				</div>
				<?php
			}
			?>
			<div class="bsLine bsT20"></div>
			<div class="bsHeading"><?php __('front_label_terms_conditions');?></div>
			<div class="bsFormRow">
				<div class="bsFormItemLabel">&nbsp;</div>
				<div class="bsFormItemValue">
					<input id="bsAgree_<?php echo $_GET['index']?>" name="agreement[]" type="checkbox" checked="checked" />&nbsp;<label for="bsAgree_<?php echo $_GET['index']?>"><?php __('front_label_agree');?></label>&nbsp;<a href="#" id="bsBtnTerms_<?php echo $_GET['index']?>"><?php __('front_label_terms_conditions');?></a>
				</div>
			</div>
			<?php
			if(!empty($tpl['terms_conditions'])){
				?>
				<div id="bsTermContainer_<?php echo $_GET['index'];?>" class="bsFormRow" style="display:none;">
					<div class="bsFormItemLabel">&nbsp;</div>
					<div class="bsFormItemValue bsTermsConditions">
						<?php echo nl2br(pjSanitize::clean($tpl['terms_conditions']));?>
					</div>
				</div>
				<?php
			} 
			?>
			<div class="bsLine bsT20"></div>
			
			<div class="bsFormRow">
				<div class="bsFloatLeft">
					<button type="button" id="bsBtnBack3_<?php echo $_GET['index'];?>" class="bsSelectorButton bsButton bsButtonRed"><abbr class="left"></abbr><abbr class="middle"><?php __('front_button_back'); ?></abbr><abbr class="right"></abbr></button>
				</div>
				<div class="bsFloatRight">
					<button type="button" id="bsBtnPreview_<?php echo $_GET['index'];?>" class="bsSelectorButton bsButton bsButtonBlue"><abbr class="left"></abbr><abbr class="middle"><?php __('front_button_preview'); ?></abbr><abbr class="right"></abbr></button>
				</div>
			</div>
		</form>
		<?php
	}else{
		?>
		<div class="bsSystemMessage">
			<?php
			$front_messages = __('front_messages', true, false);
			$system_msg = str_replace("[STAG]", "<a href='#' class='bsStartOver'>", $front_messages[5]);
			$system_msg = str_replace("[ETAG]", "</a>", $system_msg); 
			echo $system_msg; 
			?>
		</div>
		<?php
	} 
	?>
</div>