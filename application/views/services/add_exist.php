<?php //echo '<pre>'; print_r($_POST); echo '</pre>'; ?>
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
			echo form_open('scholarships/add_term', $attributes); 
		?>
				<!-- begin: hidden div -->
				<div class="with-match" id="with-match">
						
					<div class="form-group">
						<label class="control-label col-sm-2" for="recipient_fullname">Recipient<span class="text-info">*</span></label>
						<div class="col-sm-10">	
							<input type="text" class="form-control" name="recipient_fullname" id="recipient_fullname" value="<?php echo $recipient_fullname ?>" readonly />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="req_id">Requested by<span class="text-info">*</span></label>
						<div class="col-sm-10">	
							<input type="text" class="form-control" name="req_id" value="<?php echo set_value('req_id'); ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="relationship">Relationship<span class="text-info">*</span></label>
						<div class="col-sm-10">	
							<input type="text" class="form-control" name="relationship" value="<?php echo set_value('relationship'); ?>" />
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
						<label class="control-label col-sm-2" for="amount">Amount (in Php)</label>
						<div class="col-sm-10">	
						<input type="text" class="form-control" name="amount" value="<?php echo set_value('amount'); ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="s_status">Status</label>
						<div class="col-sm-10">	
							<select name="s_status" class="form-control select2-single">
								<option value="">Select</option>
								<option value="pending" <?php if (set_value('service_type') == 'pending') echo 'selected'; ?> >Pending</option>
								<option value="released" <?php if (set_value('service_type') == 'released') echo 'selected'; ?> >Released</option>
								<option value="endorsed" <?php if (set_value('service_type') == 'endorsed') echo 'selected'; ?> >Endorsed</option>
								<option value="cancelled" <?php if (set_value('service_type') == 'cancelled') echo 'selected'; ?> >Cancelled</option>
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
						<label class="control-label col-sm-2" for="s_remarks">Remarks<span class="text-info">*</span></label>
						<div class="col-sm-10">	
							<input type="text" class="form-control" name="s_remarks" value="<?php echo set_value('s_remarks'); ?>" />
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<!-- audit trail temp values -->
							<input type="hidden" id="altered" name="altered" value="" />
							<!-- audit trail temp values -->
							<input type="hidden" name="ben_id" value="<?php echo $ben_id ?>" />
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

	

});
</script>