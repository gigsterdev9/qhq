<div class="container">
	<h2><span class="glyphicon glyphicon-folder-open"></span>&nbsp; Registered Voter Details</h2>
	<h3><span class="glyphicon glyphicon-file"></span> <?php echo strtoupper($rvoter['fname'].' '.$rvoter['lname'].' ('.$rvoter['id_no'].')'); ?> 
	<?php if ($this->ion_auth->in_group('admin'))
	{
	?>
	<small>[&nbsp;<a href="<?php echo site_url('rvoters/edit/'.$rvoter['id']); ?>">Edit</a>&nbsp;]</small>
	<?php
	}
	?>
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
					<div class="col-sm-9 control-value"><?php echo $rvoter['fname']; ?>&nbsp;</div>

					<div class="col-sm-3 control-label">Middle Name</div>
					<div class="col-sm-9 control-value"><?php echo $rvoter['mname']; ?>&nbsp;</div>

					<div class="col-sm-3 control-label">Last Name</div>
					<div class="col-sm-9 control-value"><?php echo $rvoter['lname']; ?>&nbsp;</div>

					<div class="col-sm-3 control-label">Birthdate</div>
					<div class="col-sm-9 control-value"><?php echo $rvoter['dob']; ?>&nbsp;</div>

					<div class="col-sm-3 control-label">Address</div>
					<div class="col-sm-9 control-value"><?php echo $rvoter['address']; ?>&nbsp;</div>

					<div class="col-sm-3 control-label">Barangay</div>
					<div class="col-sm-9 control-value"><?php echo $rvoter['barangay']; ?>&nbsp;</div>

					<div class="col-sm-3 control-label">District</div>
					<div class="col-sm-9 control-value"><?php echo $rvoter['district']; ?>&nbsp;</div>

					<div class="col-sm-3 control-label">Sex</div>
					<div class="col-sm-9 control-value">
						<?php 
						switch ($rvoter['sex']) {
							case 'M': echo 'Male'; break;
							case 'F': echo 'Female'; break;
							default:
						}
						?>&nbsp;
					</div>

					<div class="col-sm-3 control-label">Precinct</div>
					<div class="col-sm-9 control-value"><?php echo $rvoter['precinct']; ?>&nbsp;</div>

					

				</div>

				<div class="col-sm-6">
					<div class="col-sm-3 control-label" >Code</div>
					<div class="col-sm-9 control-value" ><?php echo $rvoter['code']; ?></div>

					<div class="col-sm-3 control-label ">ID No.</div>
					<div class="col-sm-9 control-value"><?php echo $rvoter['id_no']; ?>&nbsp;</div>

					<div class="col-sm-3 control-label ">Comelec ID No.</div>
					<div class="col-sm-9 control-value"><?php echo $rvoter['id_no_comelec']; ?>&nbsp;</div>
				
					<div class="col-sm-12 buffer">&nbsp;</div>

					<div class="col-sm-3 control-label">Mobile No.</div>
					<div class="col-sm-9 control-value"><?php echo $rvoter['mobile_no']; ?>&nbsp;</div>

					<div class="col-sm-3 control-label">Email</div>
					<div class="col-sm-9 control-value"><?php echo $rvoter['email']; ?>&nbsp;</div>

					<div class="col-sm-3 control-label">Remarks</div>
					<div class="col-sm-9 control-value"><?php echo $rvoter['remarks']; ?>&nbsp;</div>

				</div>

			</div>
		</div>
		
		<div class="service-history-details text-left">
			<h3>AVAILMENT HISTORY</h3>
			<div class="table-responsive show-records" >
			
			<h4>Social Services</h4>	
			<table class="table table-striped">
				<thead>
					<tr>
						<th width="2%">&nbsp;</th>
						<th width="10%">Date</th>
						<th width="20%">Assistance Type</th>
						<th width="10%">Amount</th>
						<th width="10%">Institution</th>
						<th width="10%">Release Date</th>
						<th>Remarks</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						$services = array(
										array('date' => '2017-11-02', 
											'assistance_type' => 'Burial Assistance', 
											'amount' => '10,000.00', 
											'institution' => 'N/A',
											'release_date' => '2017-11-04',
											'remarks' => 'Lorem ipsum dolor consectitur sit amet.'),
										array('date' => '2017-10-01', 
											'assistance_type' => 'Medical Assistance', 
											'amount' => '5,000.00', 
											'institution' => 'PGH',
											'release_date' => '2017-10-03',
											'remarks' => 'Lorem ipsum dolor consectitur sit amet.'),
										array('date' => '2017-08-10', 
											'assistance_type' => 'Medical Assistance', 
											'amount' => '2,000.00', 
											'institution' => 'PGH',
											'release_date' => '2017-08-11',
											'remarks' => 'Lorem ipsum dolor consectitur sit amet.'),
										array('date' => '2017-02-20', 
											'assistance_type' => 'Financial Assistance', 
											'amount' => '1,500.00', 
											'institution' => 'N/A',
											'release_date' => '2017-02-25',
											'remarks' => 'Lorem ipsum dolor consectitur sit amet.'),
									);

						foreach ($services as $service): 
						//echo '<pre>'; print_r($rvoter); echo '</pre>';
						if (is_array($rvoter)) { //do not display 'result_count' 
					?>
					<tr>
						<td><a href="#"><span class="glyphicon glyphicon-file"></span></a></td>
						<td><?php echo $service['date']; ?></td>
						<td><?php echo $service['assistance_type']; ?></td>
						<td><?php echo $service['amount']; ?></td>
						<td><?php echo $service['institution']; ?></td>
						<td><?php echo $service['release_date']; ?></td>
						<td><?php echo $service['remarks']; ?></td>
					</tr>
					<?php 
						}
						endforeach;
					?>
				</tbody>
			</table>

			<h4>Scholarship <small>[ <a href="<?php base_url('scholarships/add') ?>">New Entry</a> ]</small></h4>
			<?php if (!empty($scholarships)) { ?>}
			<table class="table table-striped">
				<thead>
					<tr>
						<th width="2%">&nbsp;</th>
						<th width="10%">Batch</th>
						<th width="20%">School</th>
						<th width="10%"></th>
						<th width="10%">Institution</th>
						<th width="10%">Release Date</th>
						<th>Remarks</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						//echo '<pre>'; print_r($scholarships); echo '</pre>';
						foreach ($scholarships as $scholarship): 
						
							if (is_array($scholarship)) { //do not display 'result_count' 
					?>
						<tr>
							<td><a href="<?php echo base_url('scholarships/view/'.$scholarship['scholarship_id']); ?>"><span class="glyphicon glyphicon-file"></span></a></td>
							<td><?php echo $scholarship['batch']; ?></td>
							<td><?php echo $scholarship['school_name']; ?></td>
							<td><?php echo $scholarship['course']; ?></td>
							<td><?php echo $scholarship['major']; ?></td>
							<td><?php echo $scholarship['scholarship_status']; ?></td>
							<td><?php echo $scholarship['scholarship_remarks']; ?></td>
						</tr>
					<?php 
							}
						
						endforeach;
					?>
				</tbody>
			</table>
			<?php } ?>
			<!--
			<h4>Livelihood</h4>	
			<table class="table table-striped">
				<thead>
					<tr>
						<th width="2%">&nbsp;</th>
						<th width="10%">Date</th>
						<th width="20%">Assistance Type</th>
						<th width="10%">Amount</th>
						<th width="10%">Institution</th>
						<th width="10%">Release Date</th>
						<th>Remarks</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						$services = array(
										array('date' => '2017-11-02', 
											'assistance_type' => 'Burial Assistance', 
											'amount' => '10,000.00', 
											'institution' => 'N/A',
											'release_date' => '2017-11-04',
											'remarks' => 'Lorem ipsum dolor consectitur sit amet.'),
										array('date' => '2017-02-20', 
											'assistance_type' => 'Financial Assistance', 
											'amount' => '1,500.00', 
											'institution' => 'N/A',
											'release_date' => '2017-02-25',
											'remarks' => 'Lorem ipsum dolor consectitur sit amet.'),
									);

						foreach ($services as $service): 
						//echo '<pre>'; print_r($rvoter); echo '</pre>';
						if (is_array($rvoter)) { //do not display 'result_count' 
					?>
					<tr>
						<td><a href="#"><span class="glyphicon glyphicon-file"></span></a></td>
						<td><?php echo $service['date']; ?></td>
						<td><?php echo $service['assistance_type']; ?></td>
						<td><?php echo $service['amount']; ?></td>
						<td><?php echo $service['institution']; ?></td>
						<td><?php echo $service['release_date']; ?></td>
						<td><?php echo $service['remarks']; ?></td>
					</tr>
					<?php 
						}
						endforeach;
					?>
				</tbody>
			</table>
			-->
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
