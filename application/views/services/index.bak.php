<?php //echo '<pre>'; print_r($nonvoters); echo '</pre>'; ?>
<div class="container">
	<h2><span class="glyphicon glyphicon-folder-open"></span>&nbsp; <?php echo $title; ?></h2>
	<?php
		if ($this->ion_auth->in_group('admin')) {
			echo '<div class="container-fluid text-right"><a href="services/add"><span class="glyphicon glyphicon-plus-sign"></span> New entry</a></div>';
		}
	?>
	<p>&nbsp;</p>
	<div class="container-fluid text-right">
		<?php 
			$attributes = array('class' => 'form-inline', 'role' => 'form', 'method' => 'GET');
			echo form_open('services/', $attributes); 
		?>
			<div class="form-group" id="search_bar">
				<label class="control-label" for="title">Search</label> &nbsp; 
				<input type="input" class="form-control" name="search_param" />
				<input type="submit" class="form-control" value="&raquo;" />
			</div>
		<?php echo form_close();?>
		<a href="services/advanced">Advanced Search &raquo;</a>
	</div>
	<div class="container-fluid">
		<?php 
			$attributes = array('class' => 'form-inline', 'role' => 'form', 'method' => 'GET');
			echo form_open('services/', $attributes); 
		?>
			<div class="form-group">
				<label class="control-label" for="title">Filter by:</label> &nbsp; 
				<select name="filter_by" id="filter_by" class="form-control">
					<option value=""></option>
					<option value="brgy">Barangay</option>
					<option value="district">District</option>
					<option value="age">Age</option>
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
				<select name="filter_by_district" id="filter_by_district" class="form-control" style="display:none">
					<option value="1">1</option>
					<option value="2">2</option>
				</select>
				<select name="filter_by_age_operand" id="filter_by_age_operand" class="form-control" style="display:none">
					<option value="above">Above</option>
					<option value="below">Below</option>
					<option value="between">Between</option>
				</select>
				<input type="input" class="form-control" name="filter_by_age_value" id="filter_by_age_value" style="display:none" />
				<input type="submit" class="form-control" value="&raquo;" />
			</div>
		<?php echo form_close();?>
	</div>
	<p>&nbsp;</p>
		
	<h3>
		<span class="glyphicon glyphicon-folder-open"></span>&nbsp; List of Recipients
	</h3>
	<div class="container-fluid message"><?php echo $total_result_count ?> records found. 
		<?php 
			if (isset($filterval)) {
				$filter = (is_array($filterval)) ? '<br />Filter parameters: '. ucfirst($filterval[0]).' / '.$filterval[1] .' '. $filterval[2] : '' ; 
				echo $filter; 
			}
		?>
	</div> 
	<div class="container-fluid">
		<small>
		<?php 
			if (isset($filterval)) { 
				$url = 'services/filtered_to_excel/'.$filterval[0].'/'.$filterval[1];
			} 
			else if (isset($searchval)) {
				$url = 'services/results_to_excel/'.$searchval;
			}
			else {
				$url = 'services/all_to_excel';
			}
			
			if ($total_result_count > 0) //echo '<a href="'.$url.'" target="_blank">Export to Excel &raquo;</a>';	
				echo '<a href="#">Export to Excel &raquo;</a>';	
		?>
		</small>
	</div>
	
	<div class="panel panel-default">
		<div class="table-responsive show-records">
		
			<?php if ($total_result_count > 0) { ?>	
			<div class="page-links"><?php echo $links; ?></div>
			
			<?php if (count($rvoters) > 0) { ?>
				<div class="index-section-title"><h4>Registered Voters</h4></div>
				<table class="table table-striped">
					<thead>
						<tr>
							<th width="30%">Full Name</th>
							<th width="10%">Birthdate</th>
							<th width="30%">Address</th>
							<th width="10%">Barangay</th>
							<th width="5%">District</th>
							<th width="5%">Sex</th>
							<!--
							<th width="10%">Mobile Number</th>
							<th width="10%">Email</th>
							<th width="10%">Referee</th>
							-->
						</tr>
					</thead>
					<tbody>
						<?php 
							foreach ($rvoters as $rv): 
							//echo '<pre>'; print_r($rvoter); echo '</pre>';
							if (is_array($nv)) { //do not display 'result_count' 
						?>
						<tr>
							<td>
								<a href="<?php echo site_url('services/view/'.$rv['id']); ?>">
									<span class="glyphicon glyphicon-file"></span> <?php echo $rv['lname'].', '.$nv['fname']; ?>
								</a>
							</td>
							<td><?php echo $rv['dob']; ?></td>
							<td><?php echo $rv['address']; ?></td>
							<td><?php echo $rv['barangay']; ?></td>
							<td><?php echo $rv['district']; ?></td>
							<td><?php echo $rv['sex']; ?></td>
							<!--
							<td><?php echo $rv['mobile_no']; ?></td>
							<td><?php echo $rv['email']; ?></td>
							<td><?php echo $rv['referee']; ?></td>
							-->
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
					echo '<div class="message">No registered voters found in the services list.</div>';
				}

				if (count($nonvoters) > 0) {
			?>

			<div class="index-section-title"><h4>Non Voters</h4></div>
			<table class="table table-striped">
				<thead>
					<tr>
						<th width="30%">Full Name</th>
						<th width="10%">Birthdate</th>
						<th width="30%">Address</th>
						<th width="10%">Barangay</th>
						<th width="5%">District</th>
						<th width="5%">Sex</th>
						<!--
						<th width="10%">Mobile Number</th>
						<th width="10%">Email</th>
						<th width="10%">Referee</th>
						-->
					</tr>
				</thead>
				<tbody>
					<?php 
						foreach ($nonvoters as $nv): 
						//echo '<pre>'; print_r($rvoter); echo '</pre>';
						if (is_array($nv)) { //do not display 'result_count' 
					?>
					<tr>
						<td>
							<a href="<?php echo site_url('services/view/'.$nv['nv_id']); ?>">
								<span class="glyphicon glyphicon-file"></span> <?php echo $nv['lname'].', '.$nv['fname']; ?>
							</a>
						</td>
						<td><?php echo $nv['dob']; ?></td>
						<td><?php echo $nv['address']; ?></td>
						<td><?php echo $nv['barangay']; ?></td>
						<td><?php echo $nv['district']; ?></td>
						<td><?php echo $nv['sex']; ?></td>
						<!--
						<td><?php echo $nv['mobile_no']; ?></td>
						<td><?php echo $nv['email']; ?></td>
						<td><?php echo $nv['referee']; ?></td>
						-->
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
					echo '<div class="message">No non-voters found in the services list.</div>';
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
		
		switch (myval) {
			case 'brgy':
				$('#filter_by_brgy').show();
					$('#filter_by_brgy').prop('disabled', false);
				$('#filter_by_district').hide();
					$('#filter_by_district').prop('disabled', true);
				$('#filter_by_age_operand').hide();
					$('#filter_by_age_operand').prop('disabled', true);
				$('#filter_by_age_value').hide();
					$('#filter_by_age_value').prop('disabled', true);
				break;
			case 'district':
				$('#filter_by_brgy').hide();
					$('#filter_by_brgy').prop('disabled', true);
				$('#filter_by_district').show();
					$('#filter_by_district').prop('disabled', false);
				$('#filter_by_age_operand').hide();
					$('#filter_by_age_operand').prop('disabled', true);
				$('#filter_by_age_value').hide();
					$('#filter_by_age_value').prop('disabled', true);
				break;
			case 'age':
				$('#filter_by_brgy').hide();
					$('#filter_by_brgy').prop('disabled', true);
				$('#filter_by_district').hide();
					$('#filter_by_district').prop('disabled', true);
				$('#filter_by_age_operand').show();
					$('#filter_by_age_operand').prop('disabled', false);
				$('#filter_by_age_value').show();
					$('#filter_by_age_value').prop('disabled', false);
				break;
			default:
			
		}

	});


	$('#filter_by_age_operand').on('change', function(){
		var myval = $(this).val();
		
		if (myval == 'between') {
			$('#filter_by_age_value').attr("placeholder", "18 and 25");
		}
		
	});
</script>
