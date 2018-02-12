 <?php 
 //echo '<pre>'; print_r($service); echo '</pre>'; //die(); 
 $profile_id = ($service['id_no_comelec'] == '') ? $service['nv_id'] : $service['id_no_comelec'] ;
 $link_id = ($service['id_no_comelec'] == '') ? $service['nv_id'] : $service['id'] ;
 $module = ($service['id_no_comelec'] == '') ? 'nonvoters' : 'rvoters' ;
  ?>
 <div class="container">
	<h2><span class="glyphicon glyphicon-folder-open"></span>&nbsp; Service Availment Details</h2> 
	<h3><a href="<?php echo site_url($module.'/view/'.$link_id); ?>">
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
						if (empty($service['n_req_id'])) {
							$req_link = base_url('rvoters/view/'.$service['req_id']);
						}
						else { 
							$req_link = base_url('nonvoters/view/'.$service['n_req_id']);
						}
						echo '<a href="'.$req_link.'">';
						echo $service['req_fname'].' '.$service['req_lname'].'</a>';
						?>
						&nbsp;
					</div>

					<div class="col-sm-3 control-label">Relationship</div>
					<div class="col-sm-9 control-value"><?php echo $service['relationship']; ?>&nbsp;</div>

					<div class="col-sm-3 control-label">Service Type</div>
					<div class="col-sm-9 control-value"><?php echo $service['service_type']; ?>&nbsp;</div>
					
					<div class="col-sm-3 control-label">Amount</div>
					<div class="col-sm-9 control-value"><?php echo $service['amount']; ?>&nbsp;</div>

					<div class="col-sm-3 control-label">Particulars</div>
					<div class="col-sm-9 control-value"><?php echo $service['particulars']; ?>&nbsp;</div>

				</div>

				<div class="col-sm-6">
					<div class="col-sm-3 control-label">Request status</div>
					<div class="col-sm-9 control-value"><?php echo $service['s_status']; ?>&nbsp;</div>

					<div class="col-sm-3 control-label">Action officer</div>
					<div class="col-sm-9 control-value"><?php echo $service['action_officer']; ?>&nbsp;</div>

					<div class="col-sm-3 control-label" >Recommendation</div>
					<div class="col-sm-9 control-value" ><?php echo $service['recommendation']; ?>&nbsp;</div>

					<div class="col-sm-12 buffer">&nbsp;</div>
					
					<div class="col-sm-3 control-label" >Remarks</div>
					<div class="col-sm-9 control-value" ><?php echo $service['s_remarks']; ?>&nbsp;</div>

				</div>
				<?php //echo '<pre>'; print_r($scholar); echo '</pre>'; ?>
			</div>
		</div>
		
		<div class="service-history-details text-left">
			<h3>OTHER AVAILMENT RECORDS</h3>
			<div class="text-right"><a href="<?php echo base_url(); ?>"><span class="glyphicon glyphicon-plus-sign"></span> New Entry </a></div>
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
						<th width="10%">Amount</th>
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
						<td><a href="#"><span class="glyphicon glyphicon-file"></span></a></td>
						<td><?php echo $s['req_date']; ?></td>
						<td><?php echo $s['service_type']; ?></td>
						<td><?php echo $s['amount']; ?></td>
						<td>
							<?php 
								if (empty($s['n_req_id'])) {
									$req_link = base_url('rvoters/view/'.$s['req_id']);
								}
								else { 
									$req_link = base_url('nonvoters/view/'.$s['nv_id']);
								}
								echo '<a href="'.$req_link.'">';
								echo $s['req_fname'].' '.$s['req_lname']; //echo $s['r_req_id'] . $s['n_req_id'] ; 
								echo '</a>';
							?>
						</td>
						<td><?php echo $s['relationship']; ?></td>
						<td><?php echo $s['s_status']; ?></td>
						<td><?php echo $s['s_remarks']; ?></td>
						<td>
							<a href="<?php echo base_url('services/edit/'.$s['service_id']); ?>"><span class="glyphicon glyphicon-edit"></span></a> &nbsp; 
							<a href="<?php echo base_url('services/trash/'.$s['service_id']); ?>"><span class="glyphicon glyphicon-remove-circle"></span></a>
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
