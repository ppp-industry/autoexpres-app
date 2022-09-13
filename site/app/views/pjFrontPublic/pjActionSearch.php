<?php
$week_start = isset($tpl['option_arr']['o_week_start']) && in_array((int) $tpl['option_arr']['o_week_start'], range(0,6)) ? (int) $tpl['option_arr']['o_week_start'] : 0;
$jqDateFormat = pjUtil::jqDateFormat($tpl['option_arr']['o_date_format']);

$STORE = @$_SESSION[$controller->defaultStore];

$months = __('months', true);
$short_months = __('short_months', true);
ksort($months);
ksort($short_months);
$days = __('days', true);
$short_days = __('short_days', true);

?>
<div class="panel panel-default pjBsMain">
	<?php
	include PJ_VIEWS_PATH . 'pjFrontEnd/elements/header.php';
	?>
    <?switch($controller->getLocaleId()){
        case '1':
            $baseUrl = $tpl['option_arr']['o_base_url_en'];
            break;
        case '2':
            $baseUrl = $tpl['option_arr']['o_base_url_ru'];
            break;
        case '3':
            $baseUrl = $tpl['option_arr']['o_base_url_uk'];
            break;
    }?>
    <input type="hidden" name="base_url" value="<?=$baseUrl?>">
	
	<div class="panel-body pjBsBody">
		<div class="pjBsForm pjBsFormAvailability">
			<div id="pjBrCalendarLocale" style="display: none;" data-months="<?php echo implode("_", $months);?>" data-days="<?php echo implode("_", $short_days);?>"></div>
			<form id="bsSearchForm_<?php echo $_GET['index'];?>" action="<?php echo PJ_INSTALL_URL; ?>index.php?controller=pjFront&amp;action=pjActionCheck" method="post" >
				<input type="hidden" id="bsIsReturn_<?php echo $_GET['index'];?>" name="is_return" value="<?php echo (isset($STORE['is_return']) && $STORE['is_return'] == 'T')  ? 'T' : 'F';?>" />
				<div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pjBsFormContent">
						<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
							<div class="form-group">
								<label for=""><?php __('front_label_from'); ?>: </label>
								
								<div id="bsPickupContainer_<?php echo $_GET['index'];?>">	
									<select id="bsPickupId_<?php echo $_GET['index'];?>" name="pickup_id"  class="form-control pjBsAutocomplete required">
										<option value="" disabled selected>-- <?php __('front_choose'); ?>--</option>
										<?php
										foreach($tpl['from_location_arr'] as $k => $v)
										{
											?><option value="<?php echo $v['id'];?>"<?php echo isset($STORE['pickup_id']) && $STORE['pickup_id'] == $v['id'] ? ' selected="selected"' : null;?>><?php echo stripslashes($v['name']);?></option><?php
										} 
										?>
									</select>
									<div class="help-block with-errors"><ul class="list-unstyled"></ul></div>
								</div>
							</div><!-- /.form-group -->
						</div>

						<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
							<div class="form-group">
								<label for=""><?php __('front_label_to'); ?>: </label>
								<div id="bsReturnContainer_<?php echo $_GET['index'];?>">		
									<?php
									if(!isset($tpl['return_location_arr']))
									{ 
										?>
										<select id="bsReturnId_<?php echo $_GET['index'];?>" name="return_id" class="form-control pjBsAutocomplete required">
											<option value="">-- <?php __('front_choose'); ?>--</option>
											<?php
											foreach($tpl['to_location_arr'] as $k => $v)
											{
												?><option value="<?php echo $v['id'];?>"<?php echo isset($STORE['return_id']) && $STORE['return_id'] == $v['id'] ? ' selected="selected"' : null;?>><?php echo stripslashes($v['name']);?></option><?php
											} 
											?>
										</select>
										<div class="help-block with-errors"><ul class="list-unstyled"></ul></div>
										<?php
									}else{
										?>
										<select id="bsReturnId_<?php echo $_GET['index'];?>" name="return_id" class="form-control pjBsAutocomplete">
											<option value="">-- <?php __('front_choose'); ?>--</option>
											<?php
											foreach($tpl['return_location_arr'] as $k => $v)
											{
												?><option value="<?php echo $v['id'];?>"<?php echo isset($STORE['return_id']) && $STORE['return_id'] == $v['id'] ? ' selected="selected"' : null;?>><?php echo stripslashes($v['name']);?></option><?php
											} 
											?>
										</select>
										<div class="help-block with-errors"><ul class="list-unstyled"></ul></div>
										<?php
									} 
									?>
								</div>
							</div><!-- /.form-group -->
						</div>

                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <?php
                            $one_way = true;
                            $class="col-lg-12 col-md-12 col-sm-12 col-xs-12";
                            if(isset($STORE['is_return']) && $STORE['is_return'] == 'T')
                            {
                                $class = "col-lg-12 col-md-12 col-sm-12 col-xs-12";
                                $one_way = false;
                            }
                            ?>
                            <div class="<?php echo $class;?>">
                                <div class="form-group">
                                    <label for=""><?php __('front_departing'); ?>: </label>

                                    <div class="input-group pjBsDatePicker pjBsDatePickerFrom">
                                        <input type="text" id="bsDate_<?php echo $_GET['index'];?>" name="date" class="form-control required" readonly="readonly" value="<?php echo isset($STORE) && isset($STORE['date']) ? htmlspecialchars($STORE['date']) : date($tpl['option_arr']['o_date_format']) ; ?>"/>
                                        <span class="input-group-addon">
											<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
										</span>
                                    </div><!-- /.input-group pjCcDatePicker -->
                                    <div class="help-block with-errors"><ul class="list-unstyled"></ul></div>
                                </div><!-- /.form-group -->
                            </div><!-- /.col-lg-6 col-md-6 col-sm-6 col-xs-6 -->
                        </div>
								
						<p class="text-danger pjBsErrorMessage bsCheckErrorMsg" style="display: none;"><?php __('front_no_bus_available');?></p><!-- /.text-danger pjBsErrorMessage -->
						
						<p class="text-danger pjBsErrorMessage bsCheckReturnErrorMsg" style="display: none;"><?php __('front_no_return_bus_available');?></p><!-- /.text-danger pjBsErrorMessage -->
					</div><!-- /.col-lg-6 col-md-6 col-sm-6 col-xs-12 pjBsFormContent -->
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pjBsFormContent pjBsFormContent2">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-8">
                            <div id="StraightReturn">
                                <p class="">туда\обратно</p>
                                <div class="switch-btn <?=$STORE['is_return'] == 'T' ? 'switch-on' : ''?>"></div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-8">
                            <div class="form-group pjBsFormActions">
                                <button type="submit" class="btn btn-primary"><?php __('front_button_check_availability'); ?></button>
                            </div>
                        </div>
                        <?php
                        $min_to = isset($STORE['date']) && !empty($STORE['date']) ? $STORE['date'] : date("Y-m-d");
                        ?>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" style="display: <?php echo $one_way==true? 'none' : 'block';?>">
                            <div class="form-group">
                                <label for=""><?php __('front_returning'); ?>: </label>

                                <div class="input-group pjBsDatePicker pjBsDatePickerTo" data-year="<?php echo date('Y', strtotime($min_to));?>" data-month="<?php echo date('n', strtotime($min_to));?>" data-day="<?php echo date('j', strtotime($min_to));?>">
                                    <input type="text" id="bsReturnDate_<?php echo $_GET['index'];?>" name="return_date" class="form-control required" readonly="readonly" value="<?php echo isset($STORE) && isset($STORE['return_date']) ? htmlspecialchars($STORE['return_date']) : date($tpl['option_arr']['o_date_format']) ; ?>"/>
                                    <span class="input-group-addon">
											<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
										</span>
                                </div><!-- /.input-group pjCcDatePicker -->
                                <div class="help-block with-errors"><ul class="list-unstyled"></ul></div>
                            </div><!-- /.form-group -->
                        </div><!-- /.col-lg-6 col-md-6 col-sm-6 col-xs-6 -->
                    </div>
                    <aside class="col-lg-6 col-md-6 col-sm-12 col-xs-6 pjBsFormAside">
						<article class="pjBsFormArticle">
							<?php
							if(!empty($tpl['content_arr']['image'][0]['value']))
							{
								?>
								<div class="pjBsFormArticleImage">
									<img src="<?php echo PJ_INSTALL_URL . $tpl['content_arr']['image'][0]['value'];?>" />
								</div><!-- /.pjBsFormArticleImage -->
								<?php
							}
							?>
							<p>
								<?php echo nl2br(pjSanitize::clean($tpl['content_arr']['content'][0]['content']));?>
							</p>
						</article><!-- /.pjBsFormArticle -->
					</aside><!-- /.col-lg-6 col-md-6 col-sm-6 col-xs-12 pjBsFormAside -->
				</div><!-- /.row -->
			</form>
		</div><!-- /.pjBsForm pjBsFormAvailability -->
	</div><!-- /.panel-body pjBsBody -->
</div>