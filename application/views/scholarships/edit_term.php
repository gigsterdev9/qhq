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
				<?php echo $alert_success ?> <a href="<?php echo base_url('scholarships/view/'.$s_id) ?>">Return to Scholarship details.</a>
			</div>
		<?php
		}

			//begin main add scholarship form
			$attributes = array('class' => 'form-horizontal', 'role' => 'form', 'id' => 'form-new-scholarship');
			echo form_open('scholarships/edit_term', $attributes); 
		?>
				<!-- begin: hidden div -->
				<div class="with-match" id="with-match">
						
					<div class="form-group">
						<label class="control-label col-sm-2" for="award_no">Award No.</label>
						<div class="col-sm-10">	
							<input type="text" class="form-control" name="award_no" value="<?php echo set_value('award_no', $s_term['award_no']); ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="year_level">Year Level<span class="text-info">*</span></label>
						<div class="col-sm-10">	
							<select name="year_level select2-single" class="form-control">
								<option value="">Select</option>
								<option value="1" <?php if (set_value('year_level', $s_term['year_level']) == 1) echo 'selected'; ?> >1</option>
								<option value="2" <?php if (set_value('year_level', $s_term['year_level']) == 2) echo 'selected'; ?> >2</option>
								<option value="3" <?php if (set_value('year_level', $s_term['year_level']) == 3) echo 'selected'; ?> >3</option>
								<option value="4" <?php if (set_value('year_level', $s_term['year_level']) == 4) echo 'selected'; ?> >4</option>
								<option value="5" <?php if (set_value('year_level', $s_term['year_level']) == 5) echo 'selected'; ?> >5</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="school_year">School Year<span class="text-info">*</span></label>
						<div class="col-sm-10">	
							<input type="text" class="form-control" name="school_year" value="<?php echo set_value('school_year', $s_term['school_year']); ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="guardian_combined_income">Guardian Combined Income<span class="text-info">*</span></label>
						<div class="col-sm-10">	
							<input type="text" class="form-control" name="guardian_combined_income" value="<?php echo set_value('guardian_combined_income', $s_term['guardian_combined_income']); ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="gwa_1">GWA 1</label>
						<div class="col-sm-10">	
						<input type="text" class="form-control" name="gwa_1" value="<?php echo set_value('gwa_1', $s_term['gwa_1']); ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="gwa_2">GWA 2</label>
						<div class="col-sm-10">	
						<input type="text" class="form-control" name="gwa_2" value="<?php echo set_value('gwa_2', $s_term['gwa_2']); ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="3_4_gwa">3rd &amp; 4th GWA</label>
						<div class="col-sm-10">	
						<input type="text" class="form-control" name="3_4_gwa" value="<?php echo set_value('3_4_gwa', $s_term['3_4_gwa']); ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="grade_points">Grade Points</label>
						<div class="col-sm-10">	
							<input type="text" class="form-control" name="grade_points" value="<?php echo set_value('grade_points', $s_term['grade_points']); ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="income_points">Income Points</label>
						<div class="col-sm-10">	
							<input type="text" class="form-control" name="income_points" value="<?php echo set_value('income_points', $s_term['income_points']); ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="rank_points">Rank Points</label>
						<div class="col-sm-10">	
							<input type="text" class="form-control" name="rank_points" value="<?php echo set_value('rank_points', $s_term['rank_points']); ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="notes">Remarks<span class="text-info">*</span></label>
						<div class="col-sm-10">	
							<input type="text" class="form-control" name="notes" value="<?php echo set_value('notes', $s_term['notes']); ?>" />
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<!-- audit trail temp values -->
							<input type="hidden" id="altered" name="altered" value="" />
							<!-- audit trail temp values -->
							<input type="hidden" name="scholarship_id" value="<?php echo $s_id ?>" />
							<input type="hidden" name="term_id" value="<?php echo $t_id ?>" />
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