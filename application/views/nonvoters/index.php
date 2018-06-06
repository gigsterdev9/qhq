<div class="container">
	<h2><span class="glyphicon glyphicon-folder-open"></span>&nbsp; <?php echo $title; ?></h2>
	<?php
	if ($this->ion_auth->in_group('admin'))
	{
	?>
	<div class="container-fluid text-right"><a href="<?php echo base_url('nonvoters/add') ?>"><span class="glyphicon glyphicon-plus-sign"></span> New entry</a></div>
	<?php
	}
	?>
	<p>&nbsp;</p>
	<div class="container-fluid text-right">
		<?php 
			$attributes = array('class' => 'form-inline', 'role' => 'form', 'method' => 'GET');
			echo form_open('nonvoters/', $attributes); 
		?>
			<div class="form-group" id="search_bar">
				<label class="control-label" for="title">Search</label> &nbsp; 
				<input type="input" class="form-control" name="search_param" />
				<input type="submit" class="form-control" value="&raquo;" />
				<br />
				<span id="search_in">
				Search in: 
					<input type="checkbox" name="s_key[]" value="s_name" checked /> Name
					<input type="checkbox" name="s_key[]" value="s_address" />Address
				</span> 
			</div>
		<?php echo form_close();?>
		<!-- <a href="nonvoters/advanced">Advanced Search &raquo;</a> -->
	</div>
	<div class="container-fluid">
		<?php 
			$attributes = array('class' => 'form-inline', 'role' => 'form', 'method' => 'GET');
			echo form_open('nonvoters/', $attributes); 
		?>
			<div class="form-group">
				<label class="control-label" for="title">Filter by:</label> &nbsp; 
				<select name="filter_by" id="filter_by" class="form-control	">
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
		<span class="glyphicon glyphicon-folder-open"></span>&nbsp; Non-Voters
	</h3>
	<div class="container-fluid message"><?php echo $nonvoters['result_count'] ?> records found. 
		<?php 
			if (isset($filterval)) {
				$filter = (is_array($filterval)) ? '<br />Filter parameters: '. ucfirst($filterval[0]).' / '.$filterval[1] .' '. $filterval[2] : '' ; 
				echo strtoupper($filter); 
			}
			if (isset($searchval)){
				$search = '<br />Search parameters: '. ucfirst($searchval);
				echo strtoupper($search);
			}
		?>
	</div> 
	<div class="container-fluid">
		<small>
        <?php 
            /*
			if (isset($filterval)) { 
				$url = 'nonvoters/filtered_to_excel/'.$filterval[0].'/'.$filterval[1];
			} 
			else if (isset($searchval)) {
				$url = 'nonvoters/results_to_excel/'.$searchval;
			}
			else {
				$url = 'nonvoters/all_to_excel';
			}
            */
            $url = 'nonvoters/all_to_excel';
			if ($nonvoters['result_count'] > 0) echo '<a href="'.$url.'" target="_blank">Export to Excel &raquo;</a>';	
				//echo '<a href="#">Export to Excel &raquo;</a>';	
		?>
		</small>
	</div>
	
	<div class="panel panel-default">
		<div class="table-responsive show-records">
		
			<?php if ($nonvoters['result_count'] > 0) { ?>	
			<div class="page-links"><?php echo $links; ?></div>
			<table class="table table-striped">
				<thead>
					<tr>
						<th width="30%">Full Name</th>
						<th width="9%">Birthdate</th>
						<th width="2%">Age</th>
						<th width="40%">Address</th>
						<th width="15%">Barangay</th>
						<th width="2%">District</th>
						<th width="2%">Sex</th>
						<!--
						<th width="10%">Mobile Number</th>
						<th width="10%">Email</th>
						<th width="10%">Referee</th>
						-->
					</tr>
				</thead>
				<tbody>
					<?php 
						foreach ($nonvoters as $rvoter): 
						//echo '<pre>'; print_r($rvoter); echo '</pre>';
						if (is_array($rvoter)) { //do not display 'result_count' 
					?>
					<tr>
						<td>
							<a href="<?php echo site_url('nonvoters/view/'.$rvoter['nv_id']); ?>">
								<span class="glyphicon glyphicon-file"></span> <?php echo strtoupper($rvoter['lname'].', '.$rvoter['fname']) ?>
							</a>
						</td>
						<td><?php echo $rvoter['dob']; ?></td>
						<td><?php echo $rvoter['age']; ?></td>
						<td><?php echo $rvoter['address']; ?></td>
						<td><?php echo $rvoter['barangay']; ?></td>
						<td><?php echo $rvoter['district']; ?></td>
						<td><?php echo $rvoter['sex']; ?></td>
						<!--
						<td><?php echo $rvoter['mobile_no']; ?></td>
						<td><?php echo $rvoter['email']; ?></td>
						<td><?php echo $rvoter['referee']; ?></td>
						-->
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
