<div class="container">
	<h2><span class="glyphicon glyphicon-folder-open"></span>&nbsp; <?php echo $title; ?></h2>
	<?php
	if ($this->ion_auth->in_group('admin'))
	{
	?>
	<div class="container-fluid text-right"><a href="scholarships/add"><span class="glyphicon glyphicon-plus-sign"></span> New entry</a></div>
	<?php
	}
	?>
	<p>&nbsp;</p>
	<div class="container-fluid text-right">
		<?php 
			$attributes = array('class' => 'form-inline', 'role' => 'form');
			echo form_open('scholarships/', $attributes); 
		?>
			<div class="form-group">
				<label class="control-label" for="title">Search Scholars</label> &nbsp; 
				<input type="input" class="form-control" name="search_param" />
				<input type="submit" class="form-control" value="&raquo;" />
			</div>
		<?php echo form_close();?>
	</div>
	<div class="container-fluid">
		<?php 
			$attributes = array('class' => 'form-inline', 'role' => 'form');
			echo form_open('scholarships/', $attributes); 
		?>
			<div class="form-group">
				<label class="control-label" for="title">Filter by:</label> &nbsp; 
				<select name="filter_by" id="filter_by" class="form-control">
					<option value=""></option>
					<option value="brgy">Barangay</option>
					<option value="school">School</option>
					<option value="district">District</option>
					<option value="gender">Gender</option>
				</select>
				<select name="filter_by_brgy" id="filter_by_brgy" class="form-control" style="display:none">
					<option value="Concepcion Uno">Concepcion Uno</option>
					<option value="Concepcion Dos">Concepcion Dos</option>
					<option value="Fortune">Fortune</option>
					<option value="Marikina Heights">Marikina Heights</option>
					<option value="Nangka">Nangka</option>
					<option value="Parang">Parang</option>
					<option value="Tumana">Tumana</option>
				</select>
				<select name="filter_by_school" id="filter_by_school" class="form-control" style="display:none">
					<?php foreach ($schools as $school): ?>
						<option value="<?php echo $school['school_id'] ?>" ><?php echo $school['school_name'] ?></option>
					<?php endforeach; ?>
				</select>
				<input type="submit" class="form-control" value="&raquo;" />
			</div>
		<?php echo form_close();?>
	</div>
	<p>&nbsp;</p>
	<h3>
		<span class="glyphicon glyphicon-folder-open"></span>&nbsp; List of Scholars
	</h3>
	<div class="container-fluid message"><?php echo $scholarships['result_count'] ?> records found.</div>
	<div class="container-fluid">
		<small>
		<?php 
			if (isset($filterval)) 
			{ 
				$url = 'scholarships/filtered_to_excel/'.$filterval[0].'/'.$filterval[1];
			}
			else if (isset($searchval))
			{
				$url = 'scholarships/results_to_excel/'.$searchval;
			}
			else
			{
				$url = 'scholarships/all_to_excel';
			}
			
			//echo '<a href="'.$url.'" target="_blank">Export to Excel &raquo;</a>';	
		?>
		</small>
	</div>
	
	<div class="panel panel-default">
		<div class="table-responsive show-records">
		
			<?php if ($scholarships['result_count'] > 0) { ?>	
			<div class="page-links"><?php echo $links; ?></div>
			
				<table class="table table-striped">
				<thead>
					<tr>
						<th width="20%">Full Name</th>
						<th width="10%">Birthdate</th>
						<th width="5%">Age</th>
						<th width="20%">School</th>
						<th width="5%">District</th>
						<th width="5%">Sex</th>
						<th width="10%">Mobile Number</th>
						<th width="10%">Email</th>
					</tr>
				</thead>
				<tbody>
					<?php
						//echo '<pre>'; print_r($scholarships); echo '</pre>';
						foreach ($scholarships as $scholarship) :
						if (is_array($scholarship)) { //do not display 'result_count' 
							$fullname = strtoupper($scholarship['lname'].', '.$scholarship['fname']);
					?>
					<tr>
						<td>
							<a href="<?php echo site_url('scholarships/view/'.$scholarship['scholarship_id']); ?>">
								<span class="glyphicon glyphicon-file"></span> <?php echo $fullname ?>
							</a>
						</td>
						<td><?php echo $scholarship['dob']; ?></td>
						<td><?php echo $scholarship['age']; ?></td>
						<td><?php echo $scholarship['school_name']; ?></td>
						<td><?php echo $scholarship['district']; ?></td>
						<td><?php echo $scholarship['sex']; ?></td>
						<td><?php echo $scholarship['mobile_no']; ?></td>
						<td><?php echo $scholarship['email']; ?></td>
					</tr>
					<?php 
						} 
						endforeach; 
					?>
				</tbody>
				</table>

			<div class="page-links"><?php echo $links; ?></div>

			<?php } ?>

		</div>
	</div>
	
	
</div>
<script>
	$('#filter_by').on('change', function(){
		var myval = $(this).val();
		//alert(myval);
		
    	if (myval == 'brgy') {
    		$('#filter_by_brgy').show();
    		$('#filter_by_somethingelse').hide();
    	}
    	else if(myval == 'school'){
    		$('#filter_by_brgy').hide();
    		$('#filter_by_school').show();
    	}
    	else{
    		
    	}
    	
	});
</script>
