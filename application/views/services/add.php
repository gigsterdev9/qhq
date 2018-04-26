<?php 
//echo '<pre>'; print_r($_POST); echo '</pre>'; 
//echo '<pre>'; echo $ben_id; echo '</pre>'; 
?>
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
				<?php echo $alert_success ?> <a href="<?php echo base_url('services') ?>">Return to Index.</a>
			</div>
		<?php
		}
	

		if ( $this->input->POST('action') === NULL) {
			//begin match find form
			$attributes = array('class' => 'form-horizontal', 'role' => 'form', 'id' => 'form-match-find');
			echo form_open('services/add', $attributes); 
		?>
				<div class="form-group">
					<label class="control-label col-sm-2" for="fname">First Name<span class="text-info">*</span></label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="fname" id="fname" value="<?php echo set_value('fname'); ?>" required />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="fname">Middle Name<span class="text-info">*</span></label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="mname" id="mname" value="<?php echo set_value('mname'); ?>" required />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="lname">Last Name<span class="text-info">*</span></label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="lname" id="lname" value="<?php echo set_value('lname'); ?>" required />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="dob">Birthdate<span class="text-info">*</span></label>
					<div class="col-sm-10">
						<input type='text' class="form-control" name="dob" id='datetimepicker1' value="<?php echo set_value('dob'); ?>" required />
						<script type="text/javascript">
							$(function () {
								var end = new Date();
								end.setFullYear(end.getFullYear() - 12);

								$('#datetimepicker1').datetimepicker({
									format: 'YYYY-MM-DD',
									viewMode: 'years',
									maxDate: end
								});
							});
						</script>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<button type="submit" class="btn btn-default" id="match_submit">Submit</button>
					</div>
				</div>
			</form>
			<!-- end: match find form -->
		<?php
			}
			//begin main add services form
			$attributes = array('class' => 'form-horizontal', 'role' => 'form', 'id' => 'form-new-scholarship');
			echo form_open('services/add', $attributes); 
		?>
		<!-- display the remainder of the form only if no match is found -->
				<div class="match-found alert alert-warning collapse" id="match-found"></div> 

				<!-- begin: hidden div -->
				<div class="with-match <?php if ($this->input->POST('action') === null) echo 'collapse' ?>" id="with-match">
						
				<div class="form-group">
						<label class="control-label col-sm-2" for="req_date">Request date<span class="text-info">*</span></label>
						<div class="col-sm-10">
							<input type='text' class="form-control" name="req_date" id='datetimepicker1' value="<?php echo set_value('req_date'); ?>" />
							<script type="text/javascript">
								$(function () {
									$('#datetimepicker1').datetimepicker({
										format: 'YYYY-MM-DD',
									});
								});
							</script>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="recipient_fullname">Recipient<span class="text-info">*</span></label>
						<div class="col-sm-10">	
							<input type="text" class="form-control" name="recipient_fullname" id="recipient_fullname" 
								value="<?php echo (isset($recipient_fullname)) ? $recipient_fullname : set_value('recipient_fullname') ?>" readonly />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="req_id">Requested by<span class="text-info">*</span></label>
						<div class="col-sm-10">	
							<select name="req_ben_id" class="form-control select2-single">
								<option value="">Select</option>
								<?php
								foreach ($requestors as $r) {
									echo '<option value="'.$r['ben_id'].'">'.$r['fullname'].'</option>';
								}
								?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="relationship">Relationship<span class="text-info">*</span></label>
						<div class="col-sm-10">	
							<input type="text" class="form-control" name="relationship" value="<?php echo set_value('relationship'); ?>" placeholder="e.g. self, mother, uncle, guardian"/>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="service_type">Type<span class="text-info">*</span></label>
						<div class="col-sm-10">	
							<select name="service_type" class="form-control select2-single">
								<option value="">Select</option>
								<option value="burial" <?php if (set_value('service_type') == 'burial') echo 'selected'; ?> >Burial</option>
								<option value="endorsement" <?php if (set_value('service_type') == 'endorsement') echo 'selected'; ?> >Endorsement</option>
								<option value="financial" <?php if (set_value('service_type') == 'financial') echo 'selected'; ?> >Financial</option>
								<option value="legal" <?php if (set_value('service_type') == 'legal') echo 'selected'; ?> >Legal</option>
								<option value="medical" <?php if (set_value('service_type') == 'medical') echo 'selected'; ?> >Medical</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="particulars">Particulars<span class="text-info">*</span></label>
						<div class="col-sm-10">	
							<input type="text" class="form-control" name="particulars" value="<?php echo set_value('particulars'); ?>" />
						</div>
					</div>
                    <div class="form-group">
						<label class="control-label col-sm-2" for="institution">Institution</label>
						<div class="col-sm-10">	
							<input type="text" class="form-control" name="institution" value="<?php echo set_value('institution'); ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="amount">Amount (in Php)</label>
						<div class="col-sm-10">	
						<input type="text" class="form-control" name="amount" value="<?php echo set_value('amount'); ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="s_status">Status<span class="text-info">*</span></label>
						<div class="col-sm-10">	
							<select name="s_status" class="form-control select2-single">
								<option value="">Select</option>
								<option value="pending" <?php if (set_value('s_status') == 'pending') echo 'selected'; ?> >Pending</option>
								<option value="released" <?php if (set_value('s_status') == 'released') echo 'selected'; ?> >Released</option>
								<option value="endorsed" <?php if (set_value('s_status') == 'endorsed') echo 'selected'; ?> >Endorsed</option>
								<option value="cancelled" <?php if (set_value('s_status') == 'cancelled') echo 'selected'; ?> >Cancelled</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="action_officer">Action Officer</label>
						<div class="col-sm-10">	
						<input type="text" class="form-control" name="action_officer" value="<?php echo set_value('action_officer'); ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="recommendation">Recommendation</label>
						<div class="col-sm-10">	
							<input type="text" class="form-control" name="recommendation" value="<?php echo set_value('recommendation'); ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="s_remarks">Remarks</label>
						<div class="col-sm-10">	
							<input type="text" class="form-control" name="s_remarks" value="<?php echo set_value('s_remarks'); ?>" />
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							
							<input type="hidden" id="altered" name="altered" value="" />
							<input type="hidden" name="ben_id" value="<?php echo (isset($ben_id)) ? $ben_id : set_value('ben_id') ?>" />
							<input type="hidden" name="action" value="1" />
							<button type="submit" class="btn btn-default">Submit</button>
						</div>
					</div>

				</div> <!-- end: hidden div -->
			</form> 
			<!--end: main add scholarship form -->				
	</div>
</div>
</div>

<script type="text/javascript">
//move this to data.js

// Ajax post
$(document).ready(function() {

	$("#match_submit").click(function(event) {
		
		event.preventDefault();
		
		$("#match_submit").hide();
		$("#match-found").show();

		//set the previously entered values to read-only
		$("input#fname").prop("readonly", true);
		$("input#mname").prop("readonly", true);
		$("input#lname").prop("readonly", true);
		$("input#datetimepicker1").prop("readonly", true);

		$.ajax({
			"type" : "POST",
			"url" : "<?php echo base_url('beneficiaries/match_find/services'); ?>",
			"data" : $("#form-match-find").serialize(), // serializes the form's elements.
			"success" : function(data) {
				//console.log(data);
				$("#match-found").html(data);
			},
			"error" : function(jqXHR, status, error) {
				console.log("status:", status, "error:", error);
				$("#match-find").text(status);
			}
		});
	});

	$("#optradio").click(function(event) {
		alert('x');
	});

});
</script>