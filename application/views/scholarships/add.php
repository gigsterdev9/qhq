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
				Entry added. <a href="<?php echo base_url('rvoters') ?>">Return to Index.</a>
			</div>
		<?php
		}
	
			//begin match find form
			$attributes = array('class' => 'form-horizontal', 'role' => 'form', 'id' => 'form-match-find');
			echo form_open('scholarships/add', $attributes); 
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
			<!--end: match find form -->
		<?php
			//begin main add scholarship form
			$attributes = array('class' => 'form-horizontal', 'role' => 'form', 'id' => 'form-match-find');
			echo form_open('scholarships/add', $attributes); 
		?>
		<!-- display the remainder of the form only if no match is found -->
				<div class="match-found alert alert-warning collapse" id="match-found"></div> 

				<!-- begin: hidden div -->
				<div class="with-match collapse" id="with-match">
						
					<div class="form-group">
						<label class="control-label col-sm-2" for="batch">Batch<span class="text-info">*</span></label>
						<div class="col-sm-10">	
							<input type="text" class="form-control" name="batch" value="<?php echo set_value('batch'); ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="school_id">School Name<span class="text-info">*</span></label>
						<div class="col-sm-10">	
							<select name="school_id" class="form-control">
							<?php foreach ($schools as $school): ?>
								<option value="<?php echo $school['school_id'] ?>" <?php if (set_value('school_id') == $school['school_id'] ) echo 'selected' ?>><?php echo $school['school_name'] ?></option>
							<?php endforeach; ?>
							</select>
						</div>
					</div>
					<!-- add other school not in the list -->
					<div class="form-group">
						<label class="control-label col-sm-2" for="course">Course<span class="text-info">*</span></label>
						<div class="col-sm-10">	
							<input type="text" class="form-control" name="course" value="<?php echo set_value('course'); ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="major">Major</label>
						<div class="col-sm-10">	
							<input type="text" class="form-control" name="major" value="<?php echo set_value('major'); ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="scholarship_status">Scholarship Status<span class="text-info">*</span></label>
						<div class="col-sm-10">	
							<select class="form-control" name="scholarship_status">
								<option value="">Select</option>
								<option value="Freshman" <?php if (set_value('scholarship_status') == 'Freshman') echo 'selected' ?> >Freshman</option>
								<option value="Ongoing" <?php if (set_value('scholarship_status') == 'Ongoing') echo 'selected' ?> >Ongoing</option>
								<option value="Completed" <?php if (set_value('scholarship_status') == 'Completed') echo 'selected' ?> >Completed</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="disability">Disability?</label>
						<div class="col-sm-10">	
							<input type="text" class="form-control" name="disability" value="<?php echo set_value('disability'); ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="senior_citizen">Senior Citizen?</label>
						<div class="col-sm-10">	
							<select class="form-control" name="senior_citizen">
								<option value="">Select</option>
								<option value="Y" <?php if (set_value('senior_citizen') == 'Y') echo 'selected' ?> >Yes</option>
								<option value="N" <?php if (set_value('senior_citizen') == 'N') echo 'selected' ?> >No</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="parent_support_status">Solo Parent?</label>
						<div class="col-sm-10">	
							<select class="form-control" name="parent_support_status">
								<option value="">Select</option>
								<option value="Y" <?php if (set_value('parent_support_status') == 'Y') echo 'selected' ?> >Yes</option>
								<option value="N" <?php if (set_value('parent_support_status') == 'N') echo 'selected' ?> >No</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="scholarship_remarks">Remarks<span class="text-info">*</span></label>
						<div class="col-sm-10">	
							<input type="text" class="form-control" name="scholarship_remarks" value="<?php echo set_value('scholarship_remarks'); ?>" />
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<!-- audit trail temp values -->
							<input type="hidden" id="altered" name="altered" value="" />
							<!-- audit trail temp values -->
							<input type="hidden" name="action" value="1" />
							<button type="submit" class="btn btn-default">Submit</button>
						</div>
					</div>
				


				<!--
				<div class="form-group">
					<label class="control-label col-sm-2" for="address">Address<span class="text-info">*</span></label>
					<div class="col-sm-10">	
						<input type="text" class="form-control" name="address" value="<?php echo set_value('address'); ?>" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="barangay">Barangay<span class="text-info">*</span></label>
					<div class="col-sm-10">
						<select class="form-control" name="barangay"> 
							<option value="">Select</option>
							<option value="Concepcion Uno" <?php if (set_value('barangay') == 'Concepcion Uno') echo 'selected' ?> >Concepcion Uno</option>
							<option value="Concepcion Dos" <?php if (set_value('barangay') == 'Concepcion Dos') echo 'selected' ?> >Concepcion Dos</option>
							<option value="Fortune" <?php if (set_value('barangay') == 'Fortune') echo 'selected' ?> >Fortune</option>
							<option value="Marikina Heights" <?php if (set_value('barangay') == 'Marikina Heights') echo 'selected' ?> >Marikina Heights</option>
							<option value="Nangka" <?php if (set_value('barangay') == 'Nangka') echo 'selected' ?> >Nangka</option>
							<option value="Parang" <?php if (set_value('barangay') == 'Parang') echo 'selected' ?> >Parang</option>
							<option value="Tumana" <?php if (set_value('barangay') == 'Tumana') echo 'selected' ?> >Tumana</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="district">District<span class="text-info">*</span></label>
					<div class="col-sm-10">
						<select class="form-control" name="district">
							<option value="">Select</option>
							<option value="1" <?php if (set_value('district') == '1') echo 'selected' ?> >1</option>
							<option value="2" <?php if (set_value('district') == '2') echo 'selected' ?> >2</option>
						</select>
					</div>	
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="sex">Sex<span class="text-info">*</span></label>
					<div class="col-sm-10">
						<select class="form-control" name="sex">
							<option value="">Select</option>
							<option value="M" <?php if (set_value('sex') == 'M') echo 'selected' ?> >Male</option>
							<option value="F" <?php if (set_value('sex') == 'F') echo 'selected' ?> >Female</option>
						</select>
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-sm-2" for="mobile_no">Mobile No.</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="mobile_no" value="<?php echo set_value('mobile_no'); ?>" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="email">Email</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="email" value="<?php echo set_value('email'); ?>" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="referee">Referee</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="referee" value="<?php echo set_value('referee'); ?>" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="status">Status<span class="text-info">*</span></label>
					<div class="col-sm-10">
						<select class="form-control" name="status">
							<option value="">Select</option>
							<option value="1" <?php if (set_value('status', '1') == '1') echo 'selected' ?> >Active</option>
							<option value="0" <?php if (set_value('status') == '0') echo 'selected' ?> >Inactive</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="remarks">Remarks</label>
					<div class="col-sm-10">
						<textarea name="remarks" class="form-control" rows="5"><?php echo set_value('remarks'); ?></textarea>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<input type="hidden" name="new_record" id="new_record" value="0" />
						<input type="hidden" name="action" id="action" value="1" />
						<input type="hidden" name="nv_id" id="nv_id" value="" />
						<input type="hidden" name="id_no_comelec" id="id_no_comelec" value="" />
						<button type="submit" class="btn btn-default" id="final_submit">Submit</button>
					</div>
				</div>
				-->

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
			"url" : "<?php echo base_url('beneficiaries/match_find'); ?>",
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