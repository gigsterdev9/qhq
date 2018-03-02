<div class="container">
	<h2><span class="glyphicon glyphicon-folder-open"></span>&nbsp; <?php echo $title; ?></h2>
	<?php
		if ($this->ion_auth->in_group('admin')) {
			echo '<div class="container-fluid text-right"><a href="'.base_url('services/add').'"><span class="glyphicon glyphicon-plus-sign"></span> New entry</a></div>';
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
				<br />
				<span id="search_in">
				Search in: 
					<input type="checkbox" name="s_key[]" value="s_name" checked /> Name
					<input type="checkbox" name="s_key[]" value="s_address" />Address
				</span> 
			</div>
		<?php echo form_close();?>
		<!--<a href="services/advanced">Advanced Search &raquo;</a> -->
	</div>
	<div class="container-fluid">
		<?php 
			$attributes = array('class' => 'form-inline', 'role' => 'form');
			echo form_open('services/', $attributes); 
		?>
			<div class="form-group">
				<label class="control-label" for="title">Filter by:</label> &nbsp; 
				<select name="filter_by" id="filter_by" class="form-control">
					<option value=""></option>
					<option value="type">Type</option>
					<option value="brgy">Barangay</option>
					<option value="district">District</option>
					<!--<option value="date_single">Single Date</option>
					<option value="date_range">Date Range</option> -->	
					<!--<option value="gender">Gender</option>-->
				</select>
				<select name="filter_by_type" id="filter_by_type" class="form-control" style="display:none">
					<option value="burial">Burial</option>
					<option value="endorsement">Endorsement</option>
					<option value="financial">Financial</option>
					<option value="legal">Legal</option>
					<option value="medical">Medical</option>
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
				<!--<select name="filter_by_gender" id="filter_by_gender" class="form-control" style="display:none">
					<option value="M">Male</option>
					<option value="F">Female</option>
				</select>-->
				<input type="submit" class="form-control" value="&raquo;" />
			</div>
		<?php echo form_close();?>
	</div>
	<p>&nbsp;</p>
	<h3>
		<span class="glyphicon glyphicon-folder-open"></span>&nbsp; List of Service Availment
	</h3>
	<div class="container-fluid message"><?php echo $total_result_count ?> records found.
		<?php 
			if (isset($filterval)) {
				$filter = (is_array($filterval)) ? '<br />Filter parameters: '. ucfirst($filterval[0]).' / '.$filterval[1] : '' ; 
				echo $filter; 
			}
			if (isset($searchval)){
				$search = '<br />Search parameters: '. ucfirst($searchval);
				echo $search;
			}
		?>
	</div>
	<div class="container-fluid">
		<small>
		<?php 
			if (isset($filterval)) 			{ 
				$url = 'services/filtered_to_excel/'.$filterval[0].'/'.$filterval[1];
			}
			else if (isset($searchval))	{
				$url = 'services/results_to_excel/'.$searchval;
			}
			else {
				$url = 'services/all_to_excel';
			}
			
			if ($total_result_count > 0) echo '<a href="'.$url.'" target="_blank">Export to Excel &raquo;</a>';	
		?>
		</small>
	</div>
	
	<div class="panel panel-default">
		<div class="table-responsive show-records">
		
			<?php if ($total_result_count > 0) { ?>	

			<div class="page-links"><?php echo $links; ?></div>
			
				<?php if (count($r_services) > 0 && !empty($r_services)) { //echo '<pre>'; print_r($r_services); echo '</pre>'; ?>
				
					<div class="index-section-title"><h4>Registered Voters</h4></div>
					<table class="table table-striped">
					<thead>
						<tr>
							<th width="2%">&nbsp;</th>
							<th width="10%">Request date</th>
							<th width="20%">Recipient</th>
							<th width="10%">Type</th>
							<th width="10%">Amount</th>
							<th width="20%">Requested by</th>
							<th width="15%">Relationship</th>
							<th width="10%">Status</th>
							<!-- <th widht="5%">Action</th> -->
						</tr>
					</thead>
					<tbody>
						<?php
							//echo '<pre>'; print_r($r_services); echo '</pre>';
							foreach ($r_services as $service) :
							if (is_array($service)) { //do not display 'result_count' 
								$fullname = strtoupper($service['lname'].', '.$service['fname']);
						?>
						<tr>
							<td>
								<a href="<?php echo site_url('services/view/'.$service['service_id']); ?>">
									<span class="glyphicon glyphicon-file"></span>
								</a>
							</td>
							<td>
								<?php echo $service['req_date']; ?>
							</td>
							<td>
								<a href="<?php echo site_url('beneficiaries/view/'.$service['ben_id']); ?>">
									 <?php echo $fullname ?>
								</a>
							</td>
							<td><?php echo $service['service_type']; ?></td>
							<td><?php echo $service['amount']; ?></td>
							<td>
								<?php 
									$req_link = base_url('beneficiaries/view/'.$service['req_ben_id']);
									echo '<a href="'.$req_link.'">';
									echo $service['req_fname'].' '.$service['req_lname']; //echo $service['r_req_id'] . $service['n_req_id'] ; 
									echo '</a>';
								?>
							</td>
							<td><?php echo $service['relationship']; ?></td>
							<td><?php echo $service['s_status']; ?></td>
							<!--
							<td>
								<a href="<?php echo base_url('services/edit/'.$service['service_id']); ?>"><span class="glyphicon glyphicon-edit"></span></a> &nbsp; 
								<a href="<?php echo base_url('services/trash/'.$service['service_id']); ?>"><span class="glyphicon glyphicon-remove-circle"></span></a>
							</td>
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

						if (isset($searchval)) {
							echo '<div class="message">No matches found on registered voters.</div>';
						}
						else{
							echo '<div class="message">&nbsp;</div>';
						}

					}

					if (count($n_services) > 0 && !empty($n_services)) {
						//echo '<pre>'; print_r($n_services); echo '</pre>';
				?>
					
					<div class="index-section-title"><h4>Non Voters</h4></div>
					<table class="table table-striped">
					<thead>
						<tr>
							<th width="2%">&nbsp;</th>
							<th width="10%">Request date</th>
							<th width="20%">Recipient</th>
							<th width="10%">Type</th>
							<th width="10%">Amount</th>
							<th width="20%">Requested by</th>
							<th width="15%">Relationship</th>
							<th width="10%">Status</th>
							<!--<th widht="5%">Action</th>-->
						</tr>
					</thead>
					<tbody>
						<?php
							//echo '<pre>'; print_r($n_services); echo '</pre>';
							foreach ($n_services as $service) :
							if (is_array($service)) { //do not display 'result_count' 
								$fullname = strtoupper($service['lname'].', '.$service['fname']);
						?>
						<tr>
							<td>
								<a href="<?php echo site_url('services/view/'.$service['service_id']); ?>">
									<span class="glyphicon glyphicon-file"></span> 
								</a>
							</td>
							<td>
								<?php echo $service['req_date']; ?>
							</td>
							<td>
								<a href="<?php echo site_url('beneficiaries/view/'.$service['ben_id']); ?>">
								 <?php echo $fullname ?>
								</a>
							</td>
							<td>
								<?php echo $service['service_type']; ?>
							</td>
							<td><?php echo $service['amount']; ?></td>
							<td>
								<?php 
									$req_link = base_url('beneficiaries/view/'.$service['req_ben_id']);
									echo '<a href="'.$req_link.'">';
									echo $service['req_fname'].' '.$service['req_lname']; //echo $service['r_req_id'] . $service['n_req_id'] ; 
									echo '</a>';
								?>
							</td>
							<td><?php echo $service['relationship']; ?></td>
							<td><?php echo $service['s_status']; ?></td>
							<!--
							<td>
								<a href="<?php echo base_url('services/edit/'.$service['service_id']); ?>"><span class="glyphicon glyphicon-edit"></span></a> &nbsp; 
								<a href="<?php echo base_url('services/trash/'.$service['service_id']); ?>"><span class="glyphicon glyphicon-remove-circle"></span></a>
							</td>
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

						if (isset($searchval)) {
							echo '<div class="message">No matches found on non-voters.</div>';
						}
						else{
							echo '<div class="message">&nbsp;</div>';
						}
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
		
    	if (myval == 'type') {
			$('#filter_by_type').show();
			$('#filter_by_brgy').hide();
    		$('#filter_by_school').hide();
			$('#filter_by_district').hide();
			$('#filter_by_gender').hide();
		}
		else if (myval == 'brgy') {
			$('#filter_by_type').hide();
    		$('#filter_by_brgy').show();
    		$('#filter_by_school').hide();
			$('#filter_by_district').hide();
			$('#filter_by_gender').hide();
    	}
    	else if(myval == 'district'){
			$('#filter_by_type').hide();
    		$('#filter_by_brgy').hide();
    		$('#filter_by_school').hide();
			$('#filter_by_district').show();
			$('#filter_by_gender').hide();
    	}
		else if(myval == 'gender'){
			$('#filter_by_type').hide();
    		$('#filter_by_brgy').hide();
    		$('#filter_by_school').hide();
			$('#filter_by_district').hide();
			$('#filter_by_gender').show();
    	}
    	else{
    		
    	}
    	
	});
</script>
