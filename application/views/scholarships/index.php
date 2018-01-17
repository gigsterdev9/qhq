<div class="container">
	<h2><span class="glyphicon glyphicon-folder-open"></span>&nbsp; <?php echo $title; ?></h2>
	<?php
		if ($this->ion_auth->in_group('admin')) {
			echo '<div class="container-fluid text-right"><a href="'.base_url('scholarships/add').'"><span class="glyphicon glyphicon-plus-sign"></span> New entry</a></div>';
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
		<a href="scholarships/advanced">Advanced Search &raquo;</a>
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
				<select name="filter_by_district" id="filter_by_district" class="form-control" style="display:none">
					<option value="1">1</option>
					<option value="2">2</option>
				</select>
				<select name="filter_by_gender" id="filter_by_gender" class="form-control" style="display:none">
					<option value="M">Male</option>
					<option value="F">Female</option>
				</select>
				<input type="submit" class="form-control" value="&raquo;" />
			</div>
		<?php echo form_close();?>
	</div>
	<p>&nbsp;</p>
	<h3>
		<span class="glyphicon glyphicon-folder-open"></span>&nbsp; List of Scholars
	</h3>
	<div class="container-fluid message"><?php echo $record_count ?> records found.
		<?php 
			if (isset($filterval)) {
				$filter = (is_array($filterval)) ? '<br />Filter parameters: '. ucfirst($filterval[0]).' / '.$filterval[1] : '' ; 
				echo $filter; 
			}
		?>
	</div>
	<div class="container-fluid">
		<small>
		<?php 
			if (isset($filterval)) 			{ 
				$url = 'scholarships/filtered_to_excel/'.$filterval[0].'/'.$filterval[1];
			}
			else if (isset($searchval))	{
				$url = 'scholarships/results_to_excel/'.$searchval;
			}
			else {
				$url = 'scholarships/all_to_excel';
			}
			
			if ($record_count > 0) echo '<a href="'.$url.'" target="_blank">Export to Excel &raquo;</a>';	
		?>
		</small>
	</div>
	
	<div class="panel panel-default">
		<div class="table-responsive show-records">
		
			<?php if ($record_count > 0) { ?>	
			<div class="page-links"><?php echo $links; ?></div>
			
				<?php if (count($r_scholars) > 0) { ?>
					<div class="index-section-title"><h4>Registered Voters</h4></div>
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
							//echo '<pre>'; print_r($r_scholars); echo '</pre>';
							foreach ($r_scholars as $scholar) :
							if (is_array($scholar)) { //do not display 'result_count' 
								$fullname = strtoupper($scholar['lname'].', '.$scholar['fname']);
						?>
						<tr>
							<td>
								<a href="<?php echo site_url('scholarships/view/'.$scholar['scholarship_id']); ?>">
									<span class="glyphicon glyphicon-file"></span> <?php echo $fullname ?>
								</a>
							</td>
							<td><?php echo $scholar['dob']; ?></td>
							<td><?php echo $scholar['age']; ?></td>
							<td><?php echo $scholar['school_name']; ?></td>
							<td><?php echo $scholar['district']; ?></td>
							<td><?php echo $scholar['sex']; ?></td>
							<td><?php echo $scholar['mobile_no']; ?></td>
							<td><?php echo $scholar['email']; ?></td>
						</tr>
						<?php 
							} 
							endforeach; 
						?>
					</tbody>
					</table>

				<?php 
					} 
					else{
						echo '<div class="message">Currently, there are no registered voters found in this page of the Scholarships list.</div>';
					}

					if (count($n_scholars) > 0) {
				?>
					
					<div class="index-section-title"><h4>Non Voters</h4></div>
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
							//echo '<pre>'; print_r($r_scholars); echo '</pre>';
							foreach ($n_scholars as $scholar) :
							if (is_array($scholar)) { //do not display 'result_count' 
								$fullname = strtoupper($scholar['lname'].', '.$scholar['fname']);
						?>
						<tr>
							<td>
								<a href="<?php echo site_url('scholarships/view/'.$scholar['scholarship_id']); ?>">
									<span class="glyphicon glyphicon-file"></span> <?php echo $fullname ?>
								</a>
							</td>
							<td><?php echo $scholar['dob']; ?></td>
							<td><?php echo $scholar['age']; ?></td>
							<td><?php echo $scholar['school_name']; ?></td>
							<td><?php echo $scholar['district']; ?></td>
							<td><?php echo $scholar['sex']; ?></td>
							<td><?php echo $scholar['mobile_no']; ?></td>
							<td><?php echo $scholar['email']; ?></td>
						</tr>
						<?php 
							} 
							endforeach; 
						?>
					</tbody>
					</table>

				<?php 
					}
					else{
						echo '<div class="message">Currently, there are no non-voters found in this page of the Scholarships list.</div>';
					}
				?>
			
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
    		$('#filter_by_school').hide();
			$('#filter_by_district').hide();
			$('#filter_by_gender').hide();
    	}
    	else if(myval == 'school'){
    		$('#filter_by_brgy').hide();
    		$('#filter_by_school').show();
			$('#filter_by_district').hide();
			$('#filter_by_gender').hide();
    	}
		else if(myval == 'district'){
    		$('#filter_by_brgy').hide();
    		$('#filter_by_school').hide();
			$('#filter_by_district').show();
			$('#filter_by_gender').hide();
    	}
		else if(myval == 'gender'){
    		$('#filter_by_brgy').hide();
    		$('#filter_by_school').hide();
			$('#filter_by_district').hide();
			$('#filter_by_gender').show();
    	}
    	else{
    		
    	}
    	
	});
</script>
