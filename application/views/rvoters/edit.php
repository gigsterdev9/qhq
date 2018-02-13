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
					<?php echo $alert_success; ?> <a href="<?php echo base_url('rvoters') ?>">Return to Index.</a>
				</div>
			<?php
			}
			
			if (isset($alert_trash)) { 
			?>
				<div class="alert alert-danger">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<?php echo $alert_trash; ?> <a href="<?php echo base_url('rvoters') ?>">Return to Index.</a>
				</div>
			<?php
			}
			
				//begin form
				$attributes = array('class' => 'form-horizontal', 'role' => 'form', 'id' => 'main_form');
				echo form_open('rvoters/edit/'.$id, $attributes); 
			?>
					<div class="form-group">
					<label class="control-label col-sm-2" for="fname">First Name<span class="text-info">*</span></label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="fname" value="<?php echo set_value('fname', $rvoter['fname']); ?>" required />
					</div>
					</div>
					<div class="form-group">
					<label class="control-label col-sm-2" for="mname">Middle Name<span class="text-info">*</span></label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="mname" value="<?php echo set_value('mname', $rvoter['mname']); ?>" required />
					</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="lname">Last Name<span class="text-info">*</span></label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="lname" value="<?php echo set_value('lname', $rvoter['lname']); ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="dob">Birthdate<span class="text-info">*</span></label>
						<div class="col-sm-10">
							<input type='text' class="form-control" name="dob" id='datetimepicker1' value="<?php echo set_value('dob', $rvoter['dob']); ?>" />
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
							<input type="text" class="form-control" name="address" value="<?php echo set_value('address', $rvoter['address']); ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="barangay">Barangay<span class="text-info">*</span></label>
						<div class="col-sm-10">
							<select class="form-control select2-single" name="barangay"> 
								<option value="">Select</option>
								<option value="Concepcion Uno" <?php if (set_value('barangay', $rvoter['barangay']) == 'Concepcion Uno') echo 'selected' ?> >Concepcion Uno</option>
								<option value="Concepcion Dos" <?php if (set_value('barangay', $rvoter['barangay']) == 'Concepcion Dos') echo 'selected' ?> >Concepcion Dos</option>
								<option value="Fortune" <?php if (set_value('barangay', $rvoter['barangay']) == 'Fortune') echo 'selected' ?> >Fortune</option>
								<option value="Marikina Heights" <?php if ($rvoter['barangay'] == 'Marikina Heights') echo 'selected' ?> >Marikina Heights</option>
								<option value="Nangka" <?php if (set_value('barangay', $rvoter['barangay']) == 'Nangka') echo 'selected' ?> >Nangka</option>
								<option value="Parang" <?php if (set_value('barangay', $rvoter['barangay']) == 'Parang') echo 'selected' ?> >Parang</option>
								<option value="Tumana" <?php if (set_value('barangay', $rvoter['barangay']) == 'Tumana') echo 'selected' ?> >Tumana</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="district">District<span class="text-info">*</span></label>
						<div class="col-sm-10">
							<select class="form-control select2-single" name="district">
								<option value="">Select</option>
								<option value="1" <?php if (set_value('district', $rvoter['district']) == '1') echo 'selected' ?> >1</option>
								<option value="2" <?php if (set_value('district', $rvoter['district']) == '2') echo 'selected' ?> >2</option>
							</select>
						</div>	
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="sex">Sex<span class="text-info">*</span></label>
						<div class="col-sm-10">
							<select class="form-control select2-single" name="sex">
								<option value="">Select</option>
								<option value="M" <?php if (set_value('sex', $rvoter['sex']) == 'M') echo 'selected' ?> >Male</option>
								<option value="F" <?php if (set_value('sex', $rvoter['sex']) == 'F') echo 'selected' ?> >Female</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="code">Code<span class="text-info">*</span></label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="code" required value="<?php echo set_value('code', $rvoter['code']); ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="id_no">ID No.<span class="text-info">*</span></label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="id_no" value="<?php echo set_value('id_no', $rvoter['id_no']); ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="id_no_comelec">Comelec ID No.<span class="text-info">*</span></label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="id_no_comelec" value="<?php echo set_value('id_no_comelec', $rvoter['id_no_comelec']); ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="precinct">Precinct</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="precinct" value="<?php echo set_value('precinct', $rvoter['precinct']); ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="mobile_no">Mobile No.</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="mobile_no" value="<?php echo set_value('mobile_no', $rvoter['mobile_no']); ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="email">Email</label>
						<div class="col-sm-10">
							<input type="email" class="form-control" name="email" value="<?php echo set_value('email', $rvoter['email']); ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="referee">Referee</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="referee" value="<?php echo set_value('referee', $rvoter['referee']); ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="status">Status<span class="text-info">*</span></label>
						<div class="col-sm-10">
							<select class="form-control" name="status">
								<option value="">Select</option>
								<option value="1" <?php if (set_value('status', $rvoter['status']) == '1') echo 'selected' ?> >Active</option>
								<option value="0" <?php if (set_value('status', $rvoter['status']) == '0') echo 'selected' ?> >Inactive</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="remarks">Remarks</label>
						<div class="col-sm-10">
							<textarea name="remarks" class="form-control" rows="5"><?php echo set_value('remarks', $rvoter['remarks']); ?></textarea>
						</div>
					</div>		
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<!-- audit trail temp values -->
							<input type="hidden" id="altered" name="altered" value="" />
							<!-- audit trail temp values -->
							<input type="hidden" name="action" value="1" />
							<input type="hidden" name="id" value="<?php echo $rvoter['id'] ?>" />
							<button type="submit" class="btn btn-default">Submit</button>
						</div>
					</div>
					<!--
					<div class="form-group">
						<?php //echo '<pre>'; print_r($rvoter); echo '</pre>'; ?>
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
        //e.preventDefault(e);
        
    });
});		
</script>