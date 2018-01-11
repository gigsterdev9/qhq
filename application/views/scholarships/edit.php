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
				Entry added. <a href="<?php echo base_url('scholarships') ?>">Return to Index.</a>
			</div>
		<?php
		}
	
			//begin form
			$attributes = array('class' => 'form-horizontal', 'role' => 'form');
			echo form_open('scholarships/edit/'.$scholarship_id, $attributes); 
		?>
				<div class="form-group">
					<div class="col-sm-12">
						<h4><?php echo $scholarship['fname'].' '.$scholarship['mname'].' '.$scholarship['lname']; ?></h4>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="batch">Batch<span class="text-info">*</span></label>
					<div class="col-sm-10">	
						<input type="text" class="form-control" name="batch" value="<?php echo set_value('batch', $scholarship['batch']); ?>" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="school_id">School Name<span class="text-info">*</span></label>
					<div class="col-sm-10">	
						<select name="school_id" class="form-control">
						<?php foreach ($schools as $school): ?>
							<option value="<?php echo $school['school_id'] ?>" <?php if (set_value('school_id', $scholarship['school_id']) == $school['school_id'] ) echo 'selected' ?>><?php echo $school['school_name'] ?></option>
						<?php endforeach; ?>
						</select>
					</div>
				</div>
				<!-- add other school not in the list -->
				<div class="form-group">
					<label class="control-label col-sm-2" for="course">Course<span class="text-info">*</span></label>
					<div class="col-sm-10">	
						<input type="text" class="form-control" name="course" value="<?php echo set_value('course', $scholarship['course']); ?>" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="major">Major</label>
					<div class="col-sm-10">	
						<input type="text" class="form-control" name="major" value="<?php echo set_value('major', $scholarship['major']); ?>" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="scholarship_status">Scholarship Status<span class="text-info">*</span></label>
					<div class="col-sm-10">	
						<select class="form-control" name="scholarship_status">
							<option value="">Select</option>
							<option value="Freshman" <?php if (set_value('scholarship_status', $scholarship['scholarship_status']) == 'Freshman') echo 'selected' ?> >Freshman</option>
							<option value="Ongoing" <?php if (set_value('scholarship_status', $scholarship['scholarship_status']) == 'Ongoing') echo 'selected' ?> >Ongoing</option>
							<option value="Completed" <?php if (set_value('scholarship_status', $scholarship['scholarship_status']) == 'Completed') echo 'selected' ?> >Completed</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="disability">Disability?</label>
					<div class="col-sm-10">	
						<input type="text" class="form-control" name="disability" value="<?php echo set_value('disability', $scholarship['disability']); ?>" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="senior_citizen">Senior Citizen?</label>
					<div class="col-sm-10">	
						<select class="form-control" name="senior_citizen">
							<option value="">Select</option>
							<option value="Y" <?php if (set_value('senior_citizen', $scholarship['senior_citizen']) == 'Y') echo 'selected' ?> >Yes</option>
							<option value="N" <?php if (set_value('senior_citizen', $scholarship['senior_citizen']) == 'N') echo 'selected' ?> >No</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="parent_support_status">Solo Parent?</label>
					<div class="col-sm-10">	
						<select class="form-control" name="parent_support_status">
							<option value="">Select</option>
							<option value="Y" <?php if (set_value('parent_support_status', $scholarship['parent_support_status']) == 'Y') echo 'selected' ?> >Yes</option>
							<option value="N" <?php if (set_value('parent_support_status', $scholarship['parent_support_status']) == 'N') echo 'selected' ?> >No</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="scholarship_remarks">Remarks<span class="text-info">*</span></label>
					<div class="col-sm-10">	
						<input type="text" class="form-control" name="scholarship_remarks" value="<?php echo set_value('scholarship_remarks', $scholarship['scholarship_remarks']); ?>" />
					</div>
				</div>

				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<!-- audit trail temp values -->
						<input type="hidden" id="altered" name="altered" value="" />
						<!-- audit trail temp values -->
						<input type="hidden" name="action" value="1" />
						<input type="hidden" name="scholarship_id" value="<?php echo $scholarship['scholarship_id'] ?>" />
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