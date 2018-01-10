<?php //echo '<pre>'; print_r($nonvoter); echo '</pre>'; ?>
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
			
			if (isset($alert_success)) { 
			?>
				<div class="alert alert-success">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<?php echo $alert_success; ?> <a href="<?php echo base_url('nonvoters') ?>">Return to Index.</a>
				</div>
			<?php
			}
			
			if (isset($alert_trash)) { 
			?>
				<div class="alert alert-danger">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<?php echo $alert_trash; ?> <a href="<?php echo base_url('nonvoters') ?>">Return to Index.</a>
				</div>
			<?php
			}
			
				//begin form
				$attributes = array('class' => 'form-horizontal', 'role' => 'form', 'id' => 'main_form');
				echo form_open('nonvoters/edit/'.$id, $attributes); 
			?>
					<div class="form-group">
					<label class="control-label col-sm-2" for="fname">First Name<span class="text-info">*</span></label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="fname" value="<?php echo set_value('fname', $nonvoter['fname']); ?>" required />
					</div>
					</div>
					<div class="form-group">
					<label class="control-label col-sm-2" for="mname">Middle Name<span class="text-info">*</span></label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="mname" value="<?php echo set_value('mname', $nonvoter['mname']); ?>" required />
					</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="lname">Last Name<span class="text-info">*</span></label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="lname" value="<?php echo set_value('lname', $nonvoter['lname']); ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="dob">Birthdate<span class="text-info">*</span></label>
						<div class="col-sm-10">
							<input type='text' class="form-control" name="dob" id='datetimepicker1' value="<?php echo set_value('dob', $nonvoter['dob']); ?>" />
							<script type="text/javascript">
								$(function () {
									$('#datetimepicker1').datetimepicker({
										format: 'YYYY-MM-DD',
										viewMode: 'years'
									});
								});
							</script>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="address">Address<span class="text-info">*</span></label>
						<div class="col-sm-10">	
							<input type="text" class="form-control" name="address" value="<?php echo set_value('address', $nonvoter['address']); ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="barangay">Barangay<span class="text-info">*</span></label>
						<div class="col-sm-10">
							<select class="form-control" name="barangay"> 
								<option value="">Select</option>
								<option value="Concepcion Uno" <?php if (set_value('barangay', $nonvoter['barangay']) == 'Concepcion Uno') echo 'selected' ?> >Concepcion Uno</option>
								<option value="Concepcion Dos" <?php if (set_value('barangay', $nonvoter['barangay']) == 'Concepcion Dos') echo 'selected' ?> >Concepcion Dos</option>
								<option value="Fortune" <?php if (set_value('barangay', $nonvoter['barangay']) == 'Fortune') echo 'selected' ?> >Fortune</option>
								<option value="Marikina Heights" <?php if ($nonvoter['barangay'] == 'Marikina Heights') echo 'selected' ?> >Marikina Heights</option>
								<option value="Nangka" <?php if (set_value('barangay', $nonvoter['barangay']) == 'Nangka') echo 'selected' ?> >Nangka</option>
								<option value="Parang" <?php if (set_value('barangay', $nonvoter['barangay']) == 'Parang') echo 'selected' ?> >Parang</option>
								<option value="Tumana" <?php if (set_value('barangay', $nonvoter['barangay']) == 'Tumana') echo 'selected' ?> >Tumana</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="district">District<span class="text-info">*</span></label>
						<div class="col-sm-10">
							<select class="form-control" name="district">
								<option value="">Select</option>
								<option value="1" <?php if (set_value('district', $nonvoter['district']) == '1') echo 'selected' ?> >1</option>
								<option value="2" <?php if (set_value('district', $nonvoter['district']) == '2') echo 'selected' ?> >2</option>
							</select>
						</div>	
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="sex">Sex<span class="text-info">*</span></label>
						<div class="col-sm-10">
							<select class="form-control" name="sex">
								<option value="">Select</option>
								<option value="M" <?php if (set_value('sex', $nonvoter['sex']) == 'M') echo 'selected' ?> >Male</option>
								<option value="F" <?php if (set_value('sex', $nonvoter['sex']) == 'F') echo 'selected' ?> >Female</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="code">Code</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="code" value="<?php echo set_value('code', $nonvoter['code']); ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="id_no">ID No.</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="id_no" value="<?php echo set_value('id_no', $nonvoter['id_no']); ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="mobile_no">Mobile No.</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="mobile_no" value="<?php echo set_value('mobile_no', $nonvoter['mobile_no']); ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="email">Email</label>
						<div class="col-sm-10">
							<input type="email" class="form-control" name="email" value="<?php echo set_value('email', $nonvoter['email']); ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="referee">Referee</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="referee" value="<?php echo set_value('referee', $nonvoter['referee']); ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="status">Status<span class="text-info">*</span></label>
						<div class="col-sm-10">
							<select class="form-control" name="nv_status">
								<option value="">Select</option>
								<option value="1" <?php if (set_value('status', $nonvoter['nv_status']) == '1') echo 'selected' ?> >Active</option>
								<option value="0" <?php if (set_value('status', $nonvoter['nv_status']) == '0') echo 'selected' ?> >Inactive</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="remarks">Remarks</label>
						<div class="col-sm-10">
							<textarea name="remarks" class="form-control" rows="5"><?php echo set_value('remarks', $nonvoter['nv_remarks']); ?></textarea>
						</div>
					</div>		
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<!-- audit trail temp values -->
							<input type="hidden" id="altered" name="altered" value="" />
							<!-- audit trail temp values -->
							<input type="hidden" name="action" value="1" />
							<input type="hidden" name="nv_id" value="<?php echo $nonvoter['nv_id'] ?>" />
							<button type="submit" class="btn btn-default">Submit</button>
						</div>
					</div>
					<!--
					<div class="form-group">
						<?php //echo '<pre>'; print_r($nonvoter); echo '</pre>'; ?>
					</div>		
					-->
					
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