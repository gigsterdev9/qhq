 <div class="container">
	<h2><span class="glyphicon glyphicon-folder-open"></span>&nbsp; Scholarship Grant Details</h2> 
	<h3><a href="<?php echo site_url('beneficiaries/view/'.$scholar['ben_id']); ?>">
			<span class="glyphicon glyphicon-file"></span> <?php echo $scholar['fname'].' '.$scholar['lname'].' ('.$scholar['id_no'].')'; ?> 
 		</a>
		<?php if ($this->ion_auth->in_group('admin')) { ?>
			<small>[&nbsp;<a href="<?php echo base_url('scholarships/edit/'.$scholar['scholarship_id']); ?>">Edit</a>&nbsp;]</small>
		<?php } ?>
	</h3>
	<div class="panel panel-default">
		<div class="text-right back-link"><a href="javascript:history.go(-1)">&laquo; Back</a></div>
		<div class="panel-body">
			<div class="row">
				<?php
				if (isset($alert_success)) 
				{ 
				?>
					<div class="alert alert-success">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<?php echo $alert_success; ?> <a href="<?php echo base_url('grants') ?>">Return to Index.</a>
					</div>
				<?php
				}
				?>
				<div class="col-sm-6" >
					<div class="col-sm-3 control-label">First Name</div>
					<div class="col-sm-9 control-value"><?php echo $scholar['fname']; ?>&nbsp;</div>

					<div class="col-sm-3 control-label">Middle Name</div>
					<div class="col-sm-9 control-value"><?php echo $scholar['mname']; ?>&nbsp;</div>

					<div class="col-sm-3 control-label">Last Name</div>
					<div class="col-sm-9 control-value"><?php echo $scholar['lname']; ?>&nbsp;</div>

					<div class="col-sm-3 control-label">Birthdate</div>
					<div class="col-sm-9 control-value"><?php echo $scholar['dob']; ?>&nbsp;</div>

					<div class="col-sm-3 control-label">Address</div>
					<div class="col-sm-9 control-value"><?php echo $scholar['address']; ?>&nbsp;</div>

					<div class="col-sm-3 control-label">Barangay</div>
					<div class="col-sm-9 control-value"><?php echo $scholar['barangay']; ?>&nbsp;</div>

					<div class="col-sm-3 control-label">District</div>
					<div class="col-sm-9 control-value"><?php echo $scholar['district']; ?>&nbsp;</div>

					<div class="col-sm-3 control-label">Sex</div>
					<div class="col-sm-9 control-value">
						<?php 
						switch ($scholar['sex']) {
							case 'M': echo 'Male'; break;
							case 'F': echo 'Female'; break;
							default:
						}
						?>&nbsp;
					</div>

					<div class="col-sm-12 buffer">&nbsp;</div>

					<div class="col-sm-3 control-label">Mobile No.</div>
					<div class="col-sm-9 control-value"><?php echo $scholar['mobile_no']; ?>&nbsp;</div>

					<div class="col-sm-3 control-label">Email</div>
					<div class="col-sm-9 control-value"><?php echo $scholar['email']; ?>&nbsp;</div>

					

				</div>

				<div class="col-sm-6">
					<div class="col-sm-3 control-label" >Batch</div>
					<div class="col-sm-9 control-value" ><?php echo $scholar['batch']; ?>&nbsp;</div>

					<div class="col-sm-3 control-label" >School</div>
					<div class="col-sm-9 control-value" ><?php echo $scholar['school_name']; ?>&nbsp;</div>

					<div class="col-sm-3 control-label ">Course</div>
					<div class="col-sm-9 control-value"><?php echo $scholar['course']; ?>&nbsp;</div>

					<div class="col-sm-3 control-label ">Major</div>
					<div class="col-sm-9 control-value"><?php echo $scholar['major']; ?>&nbsp;</div>
				
					<div class="col-sm-3 control-label ">Status</div>
					<div class="col-sm-9 control-value"><?php echo $scholar['scholarship_status']; ?>&nbsp;</div>

					<div class="col-sm-12 buffer">&nbsp;</div>

					<div class="col-sm-3 control-label" >Disability</div>
					<div class="col-sm-9 control-value" ><?php echo $scholar['disability']; ?>&nbsp;</div>

					<div class="col-sm-3 control-label ">Senior Citizen</div>
					<div class="col-sm-9 control-value"><?php echo $scholar['senior_citizen']; ?>&nbsp;</div>

					<div class="col-sm-3 control-label ">Parental Support</div>
					<div class="col-sm-9 control-value"><?php echo $scholar['parent_support_status']; ?>&nbsp;</div>

					<div class="col-sm-12 buffer">&nbsp;</div>

					<div class="col-sm-3 control-label">Remarks</div>
					<div class="col-sm-9 control-value"><?php echo $scholar['scholarship_remarks']; ?>&nbsp;</div>

				</div>
				<?php //echo '<pre>'; print_r($scholar); echo '</pre>'; ?>
			</div>
		</div>
		
		<div class="service-history-details text-left">
			<h3>SCHOLARSHIP AVAILMENT HISTORY</h3>
			<div class="text-right"><a href="<?php echo base_url('scholarships/add_term/'.$scholar['scholarship_id']); ?>"><span class="glyphicon glyphicon-plus-sign"></span> New Entry </a></div>
			<div class="table-responsive show-records" >
				
			<table class="table table-striped">
				<thead>
					<tr>
						<th width="2%">&nbsp;</th>
						<th width="15%">Award No.</th>
						<th width="10%">School Year</th>
						<th width="5%">Year Level</th>
						<th width="5%">GWA 1</th>
						<th width="5%">GWA 2</th>
						<th width="10%">Parent/Guardian Income *</th>
						<th width="5%">Grade Points</th>
						<th width="5%">Income Points</th>
						<th width="5%">Rank Points</th>
						<th>Remarks</th>
						<th width="5%">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						foreach ($availments as $availment): 
						//echo '<pre>'; print_r($scholar); echo '</pre>';
							if (is_array($availment)) { 
						?>
						<tr>
							<td><a href="#"><span class="glyphicon glyphicon-file"></span></a></td>
							<td><?php echo $availment['award_no']; ?></td>
							<td><?php echo $availment['school_year']; ?></td>
							<td><?php echo $availment['year_level']; ?></td>
							<td><?php echo $availment['gwa_1']; ?></td>
							<td><?php echo $availment['gwa_2']; ?></td>
							<td><?php echo $availment['guardian_combined_income']; ?></td>
							<td><?php echo $availment['grade_points']; ?></td>
							<td><?php echo $availment['income_points']; ?></td>
							<td><?php echo $availment['rank_points']; ?></td>
							<td><?php echo $availment['notes']; ?></td>
							<td>
								<a href="<?php echo base_url('scholarships/edit_term/'.$scholar['scholarship_id']); ?>"><span class="glyphicon glyphicon-edit"></span></a> &nbsp; 
								<a href="<?php echo base_url('scholarships/rem_term/'.$scholar['scholarship_id']); ?>"><span class="glyphicon glyphicon-remove-circle"></span></a>
							</td>
						</tr>
						<?php 
							}
						endforeach;
					?>
				</tbody>
			</table>
			<i>* Combined income. 1.00 signifies indigent.</i>

				<?php 
					/*
					if (is_array($proponent_projects)) 
					{
						//print_r($proponent_projects);
						foreach ($proponent_projects as $project) 
						{
							echo '<a href="'.site_url('scholarships/'.$project['slug']).'">'.$project['project_title'].'</a>';
							echo '<br />';
						}
					}
					*/
				?>&nbsp;
			</div>
			<div class="text-right back-link"><a href="javascript:history.go(-1)">&laquo; Back</a></div>
		</div>


		<?php 
		//show change history if admin
		if ($this->ion_auth->in_group('admin')) {
		?>
		<div class="mod-history-details text-left">
			<button type="button" class="btn btn-sm" data-toggle="collapse" data-target="#history">Data change log</button>
			<div class="col-sm-12 buffer">&nbsp;</div>
			<div id="history" class="collapse">
				<?php
					//debug
					//echo '<pre>'; print_r($tracker); echo '</pre>';
					if ($tracker['modified'] != NULL) {
						echo 'Modified: : <br />';
						foreach ($tracker['modified'] as $track) 
						{
							echo $track['timestamp'].' by '.ucfirst($track['user']).'<br >';
							$mod_details = str_replace('|', '<br  />', $track['mod_details']);
							echo 'Details: <br />'.$mod_details.'<br />';
						}
					}
					else{
						echo 'No modifications since.';
					}
					echo '<br />';
					if ($tracker['created'] != NULL) {
						echo 'Created: '.$tracker['created']['timestamp'].' by '.ucfirst($tracker['created']['user']);
					}
					else{
						echo 'Creation date undefined.';
					}
				?>
			</div>
		</div>
		<?php
		}
		?>

	</div>
</div>
