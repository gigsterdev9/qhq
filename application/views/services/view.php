 <?php 
 //echo '<pre>'; print_r($service); echo '</pre>'; //die(); 
 $profile_id = ($service['id_no_comelec'] == '') ? $service['nv_id'] : $service['id_no_comelec'] ;
 //$link_id = ($service['id_no_comelec'] == '') ? $service['nv_id'] : $service['id'] ;
 //$module = ($service['id_no_comelec'] == '') ? 'nonvoters' : 'rvoters' ;
  ?>
 <div class="container">
	<h2><span class="glyphicon glyphicon-folder-open"></span>&nbsp; Service Availment Details</h2> 
	<h3><a href="<?php echo site_url('beneficiaries/view/'.$service['ben_id']) //echo site_url($module.'/view/'.$link_id); ?>">
			<span class="glyphicon glyphicon-file"></span> <?php echo $service['fname'].' '.$service['lname'].' ('.$profile_id.')'; ?> 
 		</a>
		<?php if ($this->ion_auth->in_group('admin')) { ?>
			<small>[&nbsp;<a href="<?php echo base_url('services/edit/'.$service['service_id']); ?>">Edit</a>&nbsp;]</small>
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
					<div class="col-sm-3 control-label">Request date</div>
					<div class="col-sm-9 control-value"><?php echo $service['req_date']; ?>&nbsp;</div>

					<div class="col-sm-3 control-label">Requested by</div>
					<div class="col-sm-9 control-value">
						<?php 
						$fullname = strtoupper($service['req_fname'].' '.$service['req_lname']);
						$req_link = base_url('beneficiaries/view/'.$service['req_ben_id']);
						echo '<a href="'.$req_link.'">';
						echo $fullname;
						echo '</a>';
						?>
						&nbsp;
					</div>

					<div class="col-sm-3 control-label">Relationship</div>
					<div class="col-sm-9 control-value"><?php echo ucfirst($service['relationship']); ?>&nbsp;</div>

					<div class="col-sm-3 control-label">Service Type</div>
					<div class="col-sm-9 control-value"><?php echo ucfirst($service['service_type']); ?>&nbsp;</div>
					
					<div class="col-sm-3 control-label">Amount (Php)</div>
					<div class="col-sm-9 control-value"><?php echo number_format($service['amount'], 2); ?>&nbsp;</div>

					<div class="col-sm-3 control-label">Particulars</div>
					<div class="col-sm-9 control-value"><?php echo $service['particulars']; ?>&nbsp;</div>

				</div>

				<div class="col-sm-6">
					<div class="col-sm-3 control-label">Request status</div>
					<div class="col-sm-9 control-value"><?php echo ucfirst($service['s_status']); ?>&nbsp;</div>

					<div class="col-sm-3 control-label">Action officer</div>
					<div class="col-sm-9 control-value"><?php echo $service['action_officer']; ?>&nbsp;</div>

					<div class="col-sm-3 control-label" >Recommendation</div>
					<div class="col-sm-9 control-value" ><?php echo $service['recommendation']; ?>&nbsp;</div>

					<div class="col-sm-12 buffer">&nbsp;</div>
					
					<div class="col-sm-3 control-label" >Remarks</div>
					<div class="col-sm-9 control-value" ><?php echo $service['s_remarks']; ?>&nbsp;</div>

					<div class="col-sm-12 buffer">&nbsp;</div>

					<div class="col-sm-12 buffer">[ <a href="<?php echo base_url('services/delete/'.$service['service_id'].'/'.$service['ben_id']); ?>">Delete</a> ]</div>

				</div>
				<?php //echo '<pre>'; print_r($scholar); echo '</pre>'; ?>
			</div>
		</div>
		
		<div class="service-history-details text-left">
			<h3>OTHER AVAILMENT RECORDS</h3>
			<div class="text-right"><a href="<?php echo base_url('services/add_exist/'.$services[0]['ben_id']); ?>"><span class="glyphicon glyphicon-plus-sign"></span> New Entry </a></div>
			<div class="table-responsive show-records" >
			<?php 
			if (count($services) > 1) { 	
			?>
			<table class="table table-striped">
				<thead>
					<tr>
						<th width="2%">&nbsp;</th>
						<th width="10%">Request date</th>
						<th width="10%">Type</th>
						<th width="10%">Amount (Php)</th>
						<th width="15%">Requested by</th>
						<th width="10%">Relationship</th>
						<th width="10%">Status</th>
						<th width="28%">Remarks</th>
						<th widht="5%">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						foreach ($services as $s): 
						//echo '<pre>'; print_r($rvoter); echo '</pre>';
						if ($service['service_id'] != $s['service_id']) { 
					?>
					<tr>
						<td><a href="<?php echo site_url('services/view/'.$s['service_id']); ?>"><span class="glyphicon glyphicon-file"></span></a></td>
						<td><?php echo $s['req_date']; ?></td>
						<td><?php echo ucfirst($s['service_type']); ?></td>
						<td class="text-right"><?php echo number_format($s['amount'], 2); ?></td>
						<td>
							<?php 
								$fullname = strtoupper($s['req_fname'].' '.$s['req_lname']);
								$req_link = base_url('beneficiaries/view/'.$s['req_ben_id']);
								echo '<a href="'.$req_link.'">';
								//echo $s['req_fname'].' '.$s['req_lname']; //echo $s['r_req_id'] . $s['n_req_id'] ; 
								echo $fullname;
								echo '</a>';
							?>
						</td>
						<td><?php echo ucfirst($s['relationship']); ?></td>
						<td><?php echo ucfirst($s['s_status']); ?></td>
						<td><?php echo $s['s_remarks']; ?></td>
						<td>
							<a href="<?php echo base_url('services/edit/'.$s['service_id']); ?>"><span class="glyphicon glyphicon-edit"></span></a> &nbsp; 
							<a href="<?php echo base_url('services/delete/'.$s['service_id'].'/'.$service['ben_id']); ?>"><span class="glyphicon glyphicon-remove-circle"></span></a>
						</td>
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
				echo 'No other availment records found.';
			}
			?>
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
