<?php
$week_start = isset($tpl['option_arr']['o_week_start']) && in_array((int) $tpl['option_arr']['o_week_start'], range(0,6)) ? (int) $tpl['option_arr']['o_week_start'] : 0;
$jqDateFormat = pjUtil::jqDateFormat($tpl['option_arr']['o_date_format']);
$STORE = @$_SESSION[$controller->defaultStore];

include PJ_VIEWS_PATH . 'pjFront/elements/locale.php';
include PJ_VIEWS_PATH . 'pjFront/elements/header.php';

if(isset($STORE['booked_data']))
{
	$booked_data = $STORE['booked_data'];
}

?>
<div class="bsContainerInner">
	<?php
	if($tpl['status'] == 'OK')
	{ 
		$current_date = date('Y-m-d');
		$selected_date = pjUtil::formatDate($STORE['date'], $tpl['option_arr']['o_date_format']);
		$previous_date = pjUtil::formatDate(date('Y-m-d', strtotime($selected_date . ' -1 day')), 'Y-m-d', $tpl['option_arr']['o_date_format']);
		$next_date = pjUtil::formatDate(date('Y-m-d', strtotime($selected_date . ' +1 day')), 'Y-m-d', $tpl['option_arr']['o_date_format']);
		?>
		<form id="bsSelectSeatsForm_<?php echo $_GET['index'];?>" action="" method="post">
		
			<div class="bsContent"><?php __('front_journey_from');?> <span class="bsBold"><?php echo $tpl['from_location']?></span> <?php __('front_to');?> <span class="bsBold"><?php echo $tpl['to_location']?></span></div>
			<div class="bsContent"><?php __('front_date_departure');?>: <?php if($current_date != $selected_date) {?><a href="#" class="bsDateNav" data-pickup="<?php echo $STORE['pickup_id']?>" data-return="<?php echo $STORE['return_id']?>" data-date="<?php echo $previous_date;?>">&laquo;&nbsp;<?php echo __('front_prev');?></a><?php }?> <span class="bsBold"><?php echo $STORE['date'];?></span> <a href="#" class="bsDateNav" data-pickup="<?php echo $STORE['pickup_id']?>" data-return="<?php echo $STORE['return_id']?>" data-date="<?php echo $next_date;?>"><?php echo __('front_next');?>&nbsp;&raquo;</a></div>
			
			<?php
			if(isset($tpl['bus_arr']))
			{ 
				?>
				<div class="bsBusContainer">
					<table class="bsTable">
						<thead>
							<tr>
								<th style="width: 250px;"><?php echo __('front_bus');?></th>
								<th style="width: 30px;">&nbsp;</th>
								<th style="width: 70px;"><?php echo __('front_available_seats');?></th>
								<th style="width: 70px;"><?php echo __('front_departure_from');?></th>
								<th style="width: 70px;"><?php echo __('front_arrive_to');?></th>
								<th style="width: 80px;"><?php echo __('front_duration');?></th>
								<th colspan="<?php echo $tpl['ticket_columns']?>"><?php __('front_tickets');?></th>
							<tr>
						</thead>
						<tbody>
							<?php
							foreach($tpl['bus_arr'] as $bus)
							{
								$seats_avail = $bus['seats_available'];
								$location_arr = $bus['locations'];
								$tip_arr = array();
								foreach($location_arr as $location)
								{
									$tip_arr[] = $location['content'] . " - " . (!empty($location['departure_time']) ? pjUtil::formatTime($location['departure_time'], 'H:i:s', $tpl['option_arr']['o_time_format']) : pjUtil::formatTime($location['arrival_time'], 'H:i:s', $tpl['option_arr']['o_time_format']));
								}
								?>
								<tr id="bsRow_<?php echo $bus['id'];?>" class="bsRow<?php echo isset($booked_data) && $booked_data['bus_id'] == $bus['id'] ? ' bsFocusRow' : null;?>">
									<td class="bsBold"><?php echo $bus['route'];?></td>
									<td><a href="javascript:void(0);" class="bsBusTooltip" title="<?php echo join("<br/>", $tip_arr); ?>"></a></td>
									<td class="bsBold bsAvailSeats">
										<?php echo $seats_avail;?>
										<input type="hidden" id="bs_avail_seats_<?php echo $bus['id'];?>" name="avail_seats" value="<?php echo join("~|~", $bus['seat_avail_arr']) ;?>"/>
										<input type="hidden" id="bs_number_of_seats_<?php echo $bus['id'];?>" value="<?php echo $seats_avail;?>"/>
									</td>
									<td class="bsBold"><?php echo $bus['departure_time'];?></td>
									<td class="bsBold"><?php echo $bus['arrival_time'];?></td>
									<td class="bsDuration"><?php echo $bus['duration'];?></td>
									<?php
									$ticket_arr = $bus['ticket_arr'];
									for($i = 0; $i < $tpl['ticket_columns']; $i++)
									{
										if(isset($ticket_arr[$i]))
										{
											$ticket = $ticket_arr[$i];
											?>
											<td>
												<label class="bsBold"><?php echo $ticket['ticket'];?></label>
												<span>
													<select name="ticket_cnt_<?php echo $ticket['ticket_id'];?>" class="bsSelect bsTicketSelect bsTicketSelect-<?php echo $bus['id'];?>" data-set="<?php echo !empty($bus['seats_map']) ? 'T' : 'F';?>" data-bus="<?php echo $bus['id']; ?>" data-price="<?php echo $ticket['price'];?>">
														<?php
														for($j = 0; $j <= $seats_avail; $j++)
														{
															?><option value="<?php echo $j; ?>"<?php echo isset($booked_data) && $booked_data['ticket_cnt_' . $ticket['ticket_id']] == $j ? ' selected="selected"' : null;?>><?php echo $j; ?></option><?php
														}
														?>
													</select> x <?php echo pjUtil::formatCurrencySign( $ticket['price'], $tpl['option_arr']['o_currency']);?>
												</span>
											</td>
											<?php
										}else{
											?><td>&nbsp;</td><?php
										}
									} 
									?>
								</tr>
								<?php
							} 
							?>
						</tbody>
					</table>
				</div>
				<?php
				if(isset($booked_data))
				{
					$selected_seats_arr = explode("|", $booked_data['selected_seats']);
					$intersect = array_intersect($tpl['booked_seat_arr'], $selected_seats_arr);
				}
				?>
				<div class="bsErrorMsg bsTicketErrorMsg"><?php __('front_validation_tickets');?></div>
				<div class="bsContent bsFloatLeft bsBold bsR14" style="display:<?php echo isset($booked_data) && $booked_data['selected_ticket'] > 0 ? 'block' : 'none';?>;"><?php __('front_select');?> <span id="bsSeats_<?php echo $_GET['index'];?>"><?php echo isset($booked_data) ? ( empty($intersect) ? ( $booked_data['selected_ticket'] > 0 ? ($booked_data['selected_ticket'] != 1 ? ($booked_data['selected_ticket'] . ' ' . pjSanitize::clean(__('front_seats', true, false))) : ($booked_data['selected_ticket'] . ' ' . pjSanitize::clean(__('front_seat', true, false))) ) :null) :null): null;?></span></div>
				<div class="bsContent bsOverflow">
					<div class="bsSelectedSeatsLabel" style="display:<?php echo isset($booked_data) ? ( empty($intersect) ? ( $booked_data['selected_seats'] != '' ? 'block' : 'none' ) : 'none' ) : 'none';?>;"><?php __('front_selected_seats');?>: <span id="bsSelectedSeatsLabel_<?php echo $_GET['index'];?>"><?php echo isset($booked_data) ? ( empty($intersect) ? ($booked_data['selected_seats'] != '' ? join(", ", $tpl['selected_seat_arr']) : null) : null ) : null;?></span></div>
					<a class="bsReSelect" href="#" style="display:<?php echo isset($booked_data) ? (empty($intersect) ? ( $booked_data['has_map'] == 'T' ? 'block' : 'none') :'none' ) : 'none';?>;"><?php __('front_reselect');?></a>
				</div>
				<div style="clear: both;"></div>
				<div id="bsMapContainer_<?php echo $_GET['index'];?>" class="bsMapContainer" style="display:<?php echo isset($booked_data) && $booked_data['has_map'] == 'T' ? 'block' : 'none';?>;">
					<?php
					if(isset($booked_data) && $booked_data['has_map'] == 'T')
					{
						include PJ_VIEWS_PATH . 'pjFront/pjActionGetSeats.php';
					} 
					?>
				</div>
				<div class="bs-seats-legend bsB20">
					<label><span class="bs-available-seats"></span><?php __('front_available');?></label>
					<label><span class="bs-selected-seats"></span><?php __('front_selected');?></label>
					<label><span class="bs-booked-seats"></span><?php __('front_booked');?></label>
				</div>
				
				<input type="hidden" id="bs_selected_tickets_<?php echo $_GET['index'];?>" name="selected_ticket" value="<?php echo isset($booked_data) && $booked_data['selected_ticket'] > 0 ? $booked_data['selected_ticket'] : null;?>" data-map="<?php echo isset($booked_data) && $booked_data['selected_ticket'] > 0 ? (!empty($tpl['bus_type_arr']['seats_map']) ? 'T' : 'F') : 'F';?>"/>
				<input type="hidden" id="bs_selected_seats_<?php echo $_GET['index'];?>" name="selected_seats" value="<?php echo isset($booked_data) && $booked_data['selected_seats'] != '' ? $booked_data['selected_seats'] : null;?>"/>
				<input type="hidden" id="bs_selected_bus_<?php echo $_GET['index'];?>" name="bus_id" value="<?php echo isset($booked_data) && $booked_data['bus_id'] != '' ? $booked_data['bus_id'] : null;?>"/>
				<input type="hidden" id="bs_has_map_<?php echo $_GET['index'];?>" name="has_map" value="<?php echo isset($booked_data) ? $booked_data['has_map'] : null;?>"/>
				
				<div class="bsErrorMsg bsSeatErrorMsg"></div>
			
				<?php
			}else{
				?><div class="bsB20 bsT10"><?php __('front_no_bus_available');?></div><?php 
			} 
			?>
			<div class="bsSearchItem">
				<div class="bsFloatLeft">
					<button type="button" id="bsBtnCancel_<?php echo $_GET['index'];?>" class="bsSelectorButton bsButton bsButtonRed"><abbr class="left"></abbr><abbr class="middle"><?php __('front_button_back'); ?></abbr><abbr class="right"></abbr></button>
				</div>
				<?php
				if(isset($tpl['bus_arr'])) 
				{
					?>
					<div class="bsFloatRight">
						<button type="button" id="bsBtnCheckout_<?php echo $_GET['index'];?>" class="bsSelectorButton bsButton bsButtonBlue"><abbr class="left"></abbr><abbr class="middle"><?php __('front_button_checkout'); ?></abbr><abbr class="right"></abbr></button>
					</div>
					<?php
				} 
				?>
			</div>
		</form>
		<?php
	}else{
		?>
		<div class="bsSystemMessage bsM10">
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
