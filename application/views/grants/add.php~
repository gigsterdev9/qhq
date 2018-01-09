<div class="container">
	<h2><?php echo $title; ?></h2>
	<p><a href="javascript:history.go(-1)" ><span class="glyphicon glyphicon-remove-sign"></span> Cancel</a></p>
	<div class="panel panel-default">
		<div class="panel-body">
			<p class="small"><span class="text-info">*</span> Indicates a required field</p>
			<?php 
			echo '<div class="text-warning">';
			echo validation_errors();
			echo '</div>'; 

			if (isset($alert_success)) 
			{ 
			?>
				<div class="alert alert-success">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					Grant entry successful.
				</div>
			<?php
			}
		
				$attributes = array('class' => 'form-horizontal', 'role' => 'form');
				echo form_open('grants/add', $attributes); 
			?>
				<div class="form-group">
					<label class="control-label col-sm-2" for="proponent">Proponent<span class="text-info">*</span></label>
					<div class="col-sm-10">
						<!-- <input type="text" class="form-control" name="proponent" /> -->
						<select name="proponent" id="proponent_input" class="form-control" >
							<option value="0">Select Proponent</option>
							<option value="add_new" style="font-style: italic">Add new Proponent</option> <!-- if selected, open new proponent form -->
							<?php
								foreach ($proponents as $proponent) 
								{
									echo '<option value="'.$proponent['proponent_id'].'">'.$proponent['organization_name'].'</option>';
								}
							?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="title">Title<span class="text-info">*</span></label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="title" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="grant_type">Grant type<span class="text-info">*</span></label>
					<div class="col-sm-10">
						<select name="grant_type" class="form-control">
							<option value="">Select type</option>
							<option value="Small">Small Grant</option>
							<option value="Planning">Planning Grant</option>
							<option value="Strategic">Strategic Project</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="location">Location<span class="text-info">*</span></label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="location" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="site">SGP5 Site<span class="text-info">*</span></label>
					<div class="col-sm-10">
						<select name="site" class="form-control" >
							<option value="">Select site</option>
							<!--
							<option value="palawan">Palawan</option>
							<option value="samarisland">Samar Island</option>
							<option value="sierramadre">Sierra Madre</option>
							-->
							<?php
								foreach ($sites as $site) 
								{
									echo '<option value="'.$site['location_id'].'">'.$site['location_name'].'</option>';
								}
							?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="project_objectives">Project Objectives</label>
					<div class="col-sm-10">	
						<textarea name="project_objectives" class="form-control" rows="5"></textarea>
					</div>
				</div>
				<hr />
				<div class="form-group">
					<label class="control-label col-sm-2" for="">Contributions to Outcome 1</label>
					<label class="control-label col-sm-1" for="1.1"><?php echo $indicators[0]['indicator_code']; ?></label>
					<div class="col-sm-1">
						<input type="text" class="form-control" name="o111" />
					</div>
					<div class="col-sm-8 indicator-desc"><?php echo $indicators[0]['indicator_desc']; ?></div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="">&nbsp;</label>
					<label class="control-label col-sm-1" for="1.2"><?php echo $indicators[1]['indicator_code']; ?></label>
					<div class="col-sm-1">
						<input type="text" class="form-control" name="o112" />
					</div>
					<div class="col-sm-8 indicator-desc"><?php echo $indicators[1]['indicator_desc']; ?></div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="">&nbsp;</label>
					<label class="control-label col-sm-1" for="1.3"><?php echo $indicators[2]['indicator_code']; ?></label>
					<div class="col-sm-1">
						<input type="text" class="form-control" name="o113" />
					</div>
					<div class="col-sm-8 indicator-desc"><?php echo $indicators[2]['indicator_desc']; ?></div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="">&nbsp;</label>
					<label class="control-label col-sm-1" for="1.4"><?php echo $indicators[3]['indicator_code']; ?></label>
					<div class="col-sm-1">
						<input type="text" class="form-control" name="o114" />
					</div>
					<div class="col-sm-8 indicator-desc"><?php echo $indicators[3]['indicator_desc']; ?></div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="">Contributions to Outcome 2</label>
					<label class="control-label col-sm-1" for="2.1"><?php echo $indicators[4]['indicator_code']; ?></label>
					<div class="col-sm-1">
						<input type="text" class="form-control" name="o221" />
					</div>
					<div class="col-sm-8 indicator-desc"><?php echo $indicators[4]['indicator_desc']; ?></div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="">&nbsp;</label>
					<label class="control-label col-sm-1" for="2.2"><?php echo $indicators[5]['indicator_code']; ?></label>
					<div class="col-sm-1">
						<input type="text" class="form-control" name="o222" />
					</div>
					<div class="col-sm-8 indicator-desc"><?php echo $indicators[5]['indicator_desc']; ?></div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="">Contributions to Outcome 3</label>
					<label class="control-label col-sm-1" for="3.1"><?php echo $indicators[6]['indicator_code']; ?></label>
					<div class="col-sm-1">
						<input type="text" class="form-control" name="o231" />
					</div>
					<div class="col-sm-8 indicator-desc"><?php echo $indicators[6]['indicator_desc']; ?></div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="">Contributions to Outcome 4</label>
					<label class="control-label col-sm-1" for="4.1"><?php echo $indicators[7]['indicator_code']; ?></label>
					<div class="col-sm-1">
						<input type="text" class="form-control" name="o341" />
					</div>
					<div class="col-sm-8 indicator-desc"><?php echo $indicators[7]['indicator_desc']; ?></div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="">&nbsp;</label>
					<label class="control-label col-sm-1" for="4.2"><?php echo $indicators[8]['indicator_code']; ?></label>
					<div class="col-sm-1">
						<input type="text" class="form-control" name="o342" />
					</div>
					<div class="col-sm-8 indicator-desc"><?php echo $indicators[8]['indicator_desc']; ?></div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="">&nbsp;</label>
					<label class="control-label col-sm-1" for="4.3"><?php echo $indicators[9]['indicator_code']; ?></label>
					<div class="col-sm-1">
						<input type="text" class="form-control" name="o343" />
					</div>
					<div class="col-sm-8 indicator-desc"><?php echo $indicators[9]['indicator_desc']; ?></div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="">&nbsp;</label>
					<label class="control-label col-sm-1" for="4.4"><?php echo $indicators[10]['indicator_code']; ?></label>
					<div class="col-sm-1">
						<input type="text" class="form-control" name="o344" />
					</div>
					<div class="col-sm-8 indicator-desc"><?php echo $indicators[10]['indicator_desc']; ?></div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="">Contributions to Outcome 5</label>
					<label class="control-label col-sm-1" for="5.1"><?php echo $indicators[11]['indicator_code']; ?></label>
					<div class="col-sm-1">
						<input type="text" class="form-control" name="o351" />
					</div>
					<div class="col-sm-8 indicator-desc"><?php echo $indicators[11]['indicator_desc']; ?></div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="">&nbsp;</label>
					<label class="control-label col-sm-1" for="5.2"><?php echo $indicators[12]['indicator_code']; ?></label>
					<div class="col-sm-1">
						<input type="text" class="form-control" name="o352" />
					</div>
					<div class="col-sm-8 indicator-desc"><?php echo $indicators[12]['indicator_desc']; ?></div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="">&nbsp;</label>
					<label class="control-label col-sm-1" for="5.3"><?php echo $indicators[13]['indicator_code']; ?></label>
					<div class="col-sm-1">
						<input type="text" class="form-control" name="o353" />
					</div>
					<div class="col-sm-8 indicator-desc"><?php echo $indicators[13]['indicator_desc']; ?></div>
				</div>
				<hr />
				<div class="form-group">
					<label class="control-label col-sm-2" for="key_partners">Key Partners</label>
					<div class="col-sm-10">
						<textarea name="key_partners" class="form-control" rows="5"></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="beneficiaries">Beneficiaries</label>
					<div class="col-sm-10">
						<textarea name="beneficiaries" class="form-control" rows="5"></textarea>
					</div>
				</div>
				<hr />
				<div class="form-group">
					<label class="control-label col-sm-2" for="project_duration">Project Duration<span class="text-info">*</span>
						<br /><small>(In Years)</small> </label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="project_duration" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="project_start">Project Start Year</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="project_start" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="project_end">Project End Year</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="project_end" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="actual_start">Actual Start Year</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="actual_start" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="actual_end">Actual End Year</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="actual_end" />
					</div>
				</div>
				<hr />
				<div class="form-group">
					<label class="control-label col-sm-2" for="project_budget">Budget<span class="text-info">*</span></label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="project_budget" />
					</div>	
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="amount_requested">Amount requested<span class="text-info">*</span></label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="amount_requested" />
					</div>	
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="co_financing">Co-financing<span class="text-info">*</span></label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="co_financing" />
					</div>	
				</div>
				<div class="form-group" >
					<label class="control-label col-sm-2" for="t1_amount"><small>Tranche 1 amount</small></label>
					<div class="col-sm-2">
						<input type="text" class="form-control" name="t1_amount" />
					</div>
					<label class="control-label col-sm-2" for="t1_released"><small>Amount released</small></label>
					<div class="col-sm-2">
						<input type="text" class="form-control" name="t1_released" />
					</div>	
					<label class="control-label col-sm-1 date-released" for="t1_date_released"><small>Date released</small></label>
					<!--
					<div class="col-sm-2">
						<input type="text" class="form-control" name="t1_date_released" />
					</div>
					-->
					<div class="input-group date col-sm-2" id="datetimepicker1">
		                <input type="text" class="form-control" name="t1_date_released" >
		                <span class="input-group-addon">
		                    <span class="glyphicon glyphicon-calendar"></span>
		                </span>
                	</div>
                </div>
				<div class="form-group" >
					<label class="control-label col-sm-2" for="t2_amount"><small>Tranche 2 amount</small></label>
					<div class="col-sm-2">
						<input type="text" class="form-control" name="t2_amount" />
					</div>
					<label class="control-label col-sm-2" for="t2_released"><small>Amount released</small></label>
					<div class="col-sm-2">
						<input type="text" class="form-control" name="t2_released" />
					</div>	
					<label class="control-label col-sm-1 date-released" for="t2_date_released"><small>Date released</small></label>
					<!--
					<div class="col-sm-2">
						<input type="text" class="form-control" name="t2_date_released" />
					</div> 
					-->
					<div class="input-group date col-sm-2" id="datetimepicker2">
		                <input type="text" class="form-control" name="t2_date_released" >
		                <span class="input-group-addon">
		                    <span class="glyphicon glyphicon-calendar"></span>
		                </span>
                	</div>
				</div>
				<div class="form-group" >
					<label class="control-label col-sm-2" for="t3_amount"><small>Tranche 3 amount</small></label>
					<div class="col-sm-2">
						<input type="text" class="form-control" name="t3_amount" />
					</div>
					<label class="control-label col-sm-2" for="t3_released"><small>Amount released</small></label>
					<div class="col-sm-2">
						<input type="text" class="form-control" name="t3_released" />
					</div>	
					<label class="control-label col-sm-1 date-released" for="t3_date_released"><small>Date released</small></label>
					<!--
					<div class="col-sm-2">
						<input type="text" class="form-control" name="t3_date_released" />
					</div>
					-->
					<div class="input-group date col-sm-2" id="datetimepicker3">
		                <input type="text" class="form-control" name="t3_date_released" >
		                <span class="input-group-addon">
		                    <span class="glyphicon glyphicon-calendar"></span>
		                </span>
                	</div>
				</div>
				<div class="form-group" >
					<label class="control-label col-sm-2" for="t4_amount"><small>Tranche 4 amount</small></label>
					<div class="col-sm-2">
						<input type="text" class="form-control" name="t4_amount" />
					</div>
					<label class="control-label col-sm-2" for="t4_released"><small>Amount released</small></label>
					<div class="col-sm-2">
						<input type="text" class="form-control" name="t4_released" />
					</div>	
					<label class="control-label col-sm-1 date-released" for="t4_date_released"><small>Date released</small></label>
					<!--
					<div class="col-sm-2">
						<input type="text" class="form-control" name="t4_date_released" />
					</div>
					-->
					<div class="input-group date col-sm-2" id="datetimepicker4">
		                <input type="text" class="form-control" name="t4_date_released" >
		                <span class="input-group-addon">
		                    <span class="glyphicon glyphicon-calendar"></span>
		                </span>
                	</div>
				</div>
				<div class="form-group" >
					<label class="control-label col-sm-2" for="t5_amount"><small>Tranche 5 amount</small></label>
					<div class="col-sm-2">
						<input type="text" class="form-control" name="t5_amount" />
					</div>
					<label class="control-label col-sm-2" for="t5_released"><small>Amount released</small></label>
					<div class="col-sm-2">
						<input type="text" class="form-control" name="t5_released" />
					</div>	
					<label class="control-label col-sm-1 date-released" for="t5_date_released"><small>Date released</small></label>
					<!--
					<div class="col-sm-2">
						<input type="text" class="form-control" name="t5_date_released" />
					</div>
					-->
					<div class="input-group date col-sm-2" id="datetimepicker5">
		                <input type="text" class="form-control" name="t5_date_released" >
		                <span class="input-group-addon">
		                    <span class="glyphicon glyphicon-calendar"></span>
		                </span>
                	</div>
				</div>
				<div class="form-group" >
					<label class="control-label col-sm-2" for="t6_amount"><small>Tranche 6 amount</small></label>
					<div class="col-sm-2">
						<input type="text" class="form-control" name="t6_amount" />
					</div>
					<label class="control-label col-sm-2" for="t6_released"><small>Amount released</small></label>
					<div class="col-sm-2">
						<input type="text" class="form-control" name="t6_released" />
					</div>	
					<label class="control-label col-sm-1 date-released" for="t6_date_released"><small>Date released</small></label>
					<!--
					<div class="col-sm-2">
						<input type="text" class="form-control" name="t6_date_released" />
					</div>
					-->
					<div class="input-group date col-sm-2" id="datetimepicker6">
		                <input type="text" class="form-control" name="t6_date_released" >
		                <span class="input-group-addon">
		                    <span class="glyphicon glyphicon-calendar"></span>
		                </span>
                	</div>
				</div>
				<!--
				<hr />
				<div class="form-group">
					<label class="control-label col-sm-2">Documents submitted</label>
					<div class="col-sm-10"></div>	
				</div>
				<div class="row">
					<div class="col-sm-2"></div>
					<div class="col-sm-10">
						<div class="form-group">
							<div class="checkbox">
								<label><input type="checkbox" name="cover_letter" value="1">Cover letter</label>
							</div>
							<div class="checkbox">
								<label><input type="checkbox" name="summary_sheet" value="1">Project summary sheet</label>
							</div>
							<div class="checkbox">
								<label><input type="checkbox" name="proj_proposal" value="1">Project proposal</label>
							</div>
							<div class="checkbox">
								<label><input type="checkbox" name="proof_of_registration" value="1">Proof of registration with Gov't Agency</label>
							</div>
							<div class="checkbox">
								<label><input type="checkbox" name="financial_statements" value="1">Audited financial statements for last 3 years</label>
							</div>
							<div class="checkbox">
								<label><input type="checkbox" name="commitments" value="1">Commitments to partner/support project</label>
							</div>
							<div class="checkbox">
								<label><input type="checkbox" name="endorsements" value="1">Endorsements from NCIP or PAMB</label>
							</div>
							<div class="checkbox">
								<label><input type="checkbox" name="others" value="1">Others</label>
							</div>
						</div>
					</div>
				</div>
				-->
				<hr />
				<div class="form-group">
					<label class="control-label col-sm-2" for="project_status">Project Status<span class="text-info">*</span></label>
					<div class="col-sm-10">
						<select name="project_status" id="project_status_input" class="form-control" >
							<option value="">Select status</option>
							<option value="1">Pending approval</option>
							<option value="2">Approved</option>
							<option value="3">Declined</option>
							<option value="4">Completed</option>
							<option value="5">Cancelled</option>
							<option value="6">Ongoing</option>
						</select>
					</div>	
				</div>
				<!-- only available for approved grants -->
				<div class="form-group" id="moa_number" style="display:none">
					<label class="control-label col-sm-2" for="moa_number">MOA Number</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="moa_number" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="remarks">Remarks</label>
					<div class="col-sm-10">
						<textarea name="remarks" class="form-control" rows="5"></textarea>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<button type="submit" class="btn btn-default">Submit</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<script>
$(function () {
	//auto open add new proponent form
	$('#proponent_input').on('change', function(){
		var myval = $(this).val();
    	if (myval == 'add_new') {
    		window.location = "<?php echo base_url('proponents/add') ?>";
    	}
	});
	
	//toggle MOA number input field depending on selected status
	$('#project_status_input').on('change', function(){
		var myval = $(this).val();
		if (myval == 1 || myval == 2 || myval == 3) { //if pending approval, approved or declined
			$('#moa_number').hide();
		}
    	if (myval == 4 || myval ==5 || myval == 6) { //if completed, cancelled or ongoing
    		$('#moa_number').show();
    	}
	});
	
	//datetimepicker executions for tranche release date
	$('#datetimepicker1').datetimepicker({
		format: 'YYYY[-]MM[-]DD'
	});
	$('#datetimepicker2').datetimepicker({
		format: 'YYYY[-]MM[-]DD'
	});
	$('#datetimepicker3').datetimepicker({
		format: 'YYYY[-]MM[-]DD'
	});
	$('#datetimepicker4').datetimepicker({
		format: 'YYYY[-]MM[-]DD'
	});
	$('#datetimepicker5').datetimepicker({
		format: 'YYYY[-]MM[-]DD'
	});
	$('#datetimepicker6').datetimepicker({
		format: 'YYYY[-]MM[-]DD'
	});
	
});
</script>
						

