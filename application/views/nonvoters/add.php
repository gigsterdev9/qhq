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
	
			//begin form
			$attributes = array('class' => 'form-horizontal', 'role' => 'form');
			echo form_open('nonvoters/add', $attributes); 
		?>
				<div class="form-group">
					<label class="control-label col-sm-2" for="fname">First Name<span class="text-info">*</span></label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="fname" value="<?php echo ($this->input->get('fname') !== null) ? $this->input->get('fname') : set_value('fname'); ?>" required />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="fname">Middle Name<span class="text-info">*</span></label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="mname" value="<?php echo ($this->input->get('mname') !== null) ? $this->input->get('mname') : set_value('mname'); ?>" required />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="lname">Last Name<span class="text-info">*</span></label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="lname" value="<?php echo ($this->input->get('lname') !== null) ? $this->input->get('lname') : set_value('lname'); ?>" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="dob">Birthdate<span class="text-info">*</span></label>
					<div class="col-sm-10">
						<input type='text' class="form-control" name="dob" id='datetimepicker1' value="<?php echo ($this->input->get('dob') !== null) ? $this->input->get('dob') : set_value('dob'); ?>" />
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
						<input type="text" class="form-control" name="address" value="<?php echo set_value('address'); ?>" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="barangay">Barangay<span class="text-info">*</span></label>
					<div class="col-sm-10">
						<select class="form-control select2-single" name="barangay"> 
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
						<select class="form-control select2-single" name="district">
							<option value="">Select</option>
							<option value="1" <?php if (set_value('district') == '1') echo 'selected' ?> >1</option>
							<option value="2" <?php if (set_value('district') == '2') echo 'selected' ?> >2</option>
						</select>
					</div>	
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="sex">Sex<span class="text-info">*</span></label>
					<div class="col-sm-10">
						<select class="form-control select2-single" name="sex">
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
						<select class="form-control select2-single" name="status">
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
						<button type="submit" class="btn btn-default">Submit</button>
					</div>
				</div>
			</form>
	</div>
</div>
</div>