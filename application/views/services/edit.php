<?php 
//echo '<pre>'; print_r($service); echo '</pre>'; 
$recipient_fullname = $service['fname'].' '.$service['mname'].' '.$service['lname'];
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
				<?php echo $alert_success; ?>
				<a href="<?php echo base_url('services/view/'.$service['service_id']) ?>">Return to details view.</a>
			</div>
		<?php
		}
	
			//begin form
			$attributes = array('class' => 'form-horizontal', 'role' => 'form', 'id' => 'main_form');
			echo form_open('services/edit/'.$service_id, $attributes); 
		?>
				<div class="form-group">
						<label class="control-label col-sm-2" for="req_date">Request date<span class="text-info">*</span></label>
						<div class="col-sm-10">
							<input type='text' class="form-control" name="req_date" id='datetimepicker1' value="<?php echo set_value('req_date', $service['req_date']); ?>" />
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
									echo '<option value="'.$r['ben_id'].'"';
									if ($service['req_ben_id'] == $r['ben_id']) echo 'selected';
									echo '>'.$r['fullname'].'</option>';
								}
								?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="relationship">Relationship<span class="text-info">*</span></label>
						<div class="col-sm-10">	
							<input type="text" class="form-control" name="relationship" value="<?php echo set_value('relationship', $service['relationship']); ?>" placeholder="e.g. self, mother, uncle, guardian"/>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="service_type">Type<span class="text-info">*</span></label>
						<div class="col-sm-10">	
							<select name="service_type" class="form-control select2-single">
								<option value="">Select</option>
								<option value="burial" <?php if (set_value('service_type', $service['service_type']) == 'burial') echo 'selected'; ?> >Burial</option>
								<option value="endorsement" <?php if (set_value('service_type', $service['service_type']) == 'endorsement') echo 'selected'; ?> >Endorsement</option>
								<option value="financial" <?php if (set_value('service_type', $service['service_type']) == 'financial') echo 'selected'; ?> >Financial</option>
								<option value="legal" <?php if (set_value('service_type', $service['service_type']) == 'legal') echo 'selected'; ?> >Legal</option>
								<option value="medical" <?php if (set_value('service_type', $service['service_type']) == 'medical') echo 'selected'; ?> >Medical</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="particulars">Particulars<span class="text-info">*</span></label>
						<div class="col-sm-10">	
							<input type="text" class="form-control" name="particulars" value="<?php echo set_value('particulars', $service['particulars']); ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="amount">Amount (in Php)</label>
						<div class="col-sm-10">	
						<input type="text" class="form-control" name="amount" value="<?php echo set_value('amount', $service['amount']); ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="s_status">Status<span class="text-info">*</span></label>
						<div class="col-sm-10">	
							<select name="s_status" class="form-control select2-single">
								<option value="">Select</option>
								<option value="pending" <?php if (set_value('s_status', $service['s_status']) == 'pending') echo 'selected'; ?> >Pending</option>
								<option value="released" <?php if (set_value('s_status', $service['s_status']) == 'released') echo 'selected'; ?> >Released</option>
								<option value="endorsed" <?php if (set_value('s_status', $service['s_status']) == 'endorsed') echo 'selected'; ?> >Endorsed</option>
								<option value="cancelled" <?php if (set_value('s_status', $service['s_status']) == 'cancelled') echo 'selected'; ?> >Cancelled</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="action_officer">Action Officer</label>
						<div class="col-sm-10">	
						<input type="text" class="form-control" name="action_officer" value="<?php echo set_value('action_officer', $service['action_officer']); ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="recommendation">Recommendation</label>
						<div class="col-sm-10">	
							<input type="text" class="form-control" name="recommendation" value="<?php echo set_value('recommendation', $service['recommendation']); ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="s_remarks">Remarks</label>
						<div class="col-sm-10">	
							<input type="text" class="form-control" name="s_remarks" value="<?php echo set_value('s_remarks', $service['s_remarks']); ?>" />
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<!-- audit trail temp values -->
							<input type="hidden" id="altered" name="altered" value="" />
							<!-- audit trail temp values -->
							<input type="hidden" name="ben_id" value="<?php echo (isset($ben_id)) ? $ben_id : set_value('ben_id', $service['ben_id']) ?>" />
							<input type="hidden" name="service_id" value="<?php echo (isset($service_id)) ? $service_id : set_value('service_id', $service['service_id']) ?>" />
							<input type="hidden" name="action" value="1" />
							<button type="submit" class="btn btn-default">Submit</button>
						</div>
					</div>
			</form>
	</div>
</div>
</div>

<script>
$(function () {
	
	$("form").submit(function(e){
		
		var x = '';
		
		//step through each input elements
		$('#main_form *').filter(':input').each(function(){
		    var f = $(this).attr('name'); 
			var g = $(this).prop('defaultValue'); 
			var h = $(this).val();
			
			
			if (g != null && g != '0000-00-00') 
			{
				if (g != h) 
				{
					x += 'field: ' + f + ', old value: ' + g + ', new value: ' + h + ' | ';
					console.log(f + '::' + g + '::' + h + '| ');
		    	}
			}
			
		});
		
		//step through each select elements
		//??
		
		$("#altered").val(x);
		//console.log(x);
		
		//alert('submit intercepted');
		//alert(x);
        //e.preventDefault(e);
        
    });
});		
</script>