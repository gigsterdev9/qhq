<div class="container">
	<h2><span class="glyphicon glyphicon-folder-open"></span>&nbsp; Grant Details</h2>
	<h3><span class="glyphicon glyphicon-file"></span> <?php echo $grants_item['project_title'].' ('.$grants_item['moa_number'].')'; ?> 
	<?php if ($this->ion_auth->in_group('admin'))
	{
	?>
	<small>[&nbsp;<a href="<?php echo site_url('grants/edit/'.$grants_item['slug']); ?>">Edit</a>&nbsp;]</small>
	<?php
	}
	?>
	</h3>
	<div class="panel panel-default">
		<div class="text-right back-link"><a href="javascript:history.go(-1)">&laquo; Back</a></div>
		<!--
		<div class="mod-history text-right">
		<?php
			if ($tracker['created'] != NULL) 
			{
				echo 'Created: '.$tracker['created']['timestamp'].' by '.ucfirst($tracker['created']['user']);
			}
			else
			{
				echo 'Creation date undefined.';
			}
			echo ' &nbsp; | &nbsp; ';;
			
			if ($tracker['modified'] != NULL) 
			{
				echo 'Last Modified: '.$tracker['modified']['timestamp'].' by '.ucfirst($tracker['modified']['user']);
			}
			else
			{
				echo 'No modifications since.';
			}
		?>
		</div>
		-->
		<div class="panel-body">
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
			<div class="control-label col-sm-2">Proponent</div>
			<div class="col-sm-10">
				<?php echo '<a href="'.site_url('proponents/'.$grants_item['proponent_id']).'">'.$grants_item['organization_name'].'</a>'; ?>&nbsp;
			</div>
			
			<div class="control-label col-sm-2">Title</div>
			<div class="col-sm-10">
				<?php echo $grants_item['project_title']; ?>&nbsp;
			</div>
			
			<div class="control-label col-sm-2">Grant type</div>
			<div class="col-sm-10">
				<?php 
					switch ($grants_item['grant_type']) 
					{
						case 'Small': $grant_type = 'Small Grant'; break;
						case 'Planning': $grant_type = 'Planning Grant'; break; 
						case 'Strategic': $grant_type = 'Strategic Project'; break;
						default: break;
					} 
					echo $grant_type; 
				?>&nbsp;
			</div>
			
			<div class="control-label col-sm-2">Location</div>
			<div class="col-sm-10">
				<?php echo $grants_item['location']; ?>&nbsp;
			</div>
			
			<div class="control-label col-sm-2">Location name</div>
			<div class="col-sm-10">
				<?php echo $grants_item['location_name']; ?>&nbsp;
			</div>
			
			<div class="control-label col-sm-2">Project objectives</div>
			<div class="col-sm-10">
				<?php echo $grants_item['project_objectives']; ?>&nbsp;
			</div>
			
			<hr />
			<div class="control-label col-sm-2">Outcome 1 contribution</div>
			<div class="col-sm-10">
				<?php 
					if (isset($outcome))
					{
						if (array_key_exists('1', $outcome)) 
						{
							foreach ($outcome['1'] as $key => $value) 
							{
								foreach ($value as $code => $value) 
								{
									echo 'Indicator Code: '.$code.' / Contribution: '.$value;
									echo '<br />';
								}
							}
						}
						else
						{
							echo 'None';
						}
					}
				?>&nbsp;
			</div>
			<div class="control-label col-sm-2">Outcome 2 contribution</div>
			<div class="col-sm-10">
				<?php 
					if (isset($outcome))
					{
						if (array_key_exists('2', $outcome)) 
						{
							foreach ($outcome['2'] as $key => $value) 
							{
								foreach ($value as $code => $value) 
								{
									echo 'Indicator Code: '.$code.' / Contribution: '.$value;
									echo '<br />';
								}
							}
						}
						else
						{
							echo 'None';
						}
					
					}
				?>&nbsp;
			</div>
			<div class="control-label col-sm-2">Outcome 3 contribution</div>
			<div class="col-sm-10">
				<?php 
					if (isset($outcome))
					{
						if (array_key_exists('3', $outcome)) 
						{
							foreach ($outcome['3'] as $key => $value) 
							{
								foreach ($value as $code => $value) 
								{
									echo 'Indicator Code: '.$code.' / Contribution: '.$value;
									echo '<br />';
								}
							}
						}
						else
						{
							echo 'None';
						}
					}
				?>&nbsp;
			</div>
			<hr />
			<div class="control-label col-sm-2">Key partners</div>
			<div class="col-sm-10">
				<?php echo $grants_item['key_partners']; ?>&nbsp;
			</div>
			<div class="control-label col-sm-2">Beneficiaries</div>
			<div class="col-sm-10">
				<?php echo $grants_item['beneficiaries']; ?>&nbsp;
			</div>
			<div class="control-label col-sm-2">Grant amount <small>(in PHP)</small></div>
			<div class="col-sm-10">
				Total budget: <?php echo number_format($grants_item['project_budget'], 2); ?><br />
				Amount requested: <?php echo number_format($grants_item['amount_requested'], 2); ?><br />
				Co-financing: <?php echo number_format($grants_item['co_financing'], 2); ?>&nbsp;
			</div>
			
			<!-- Tranches -->
			<div class="table-responsive col-sm-12">
				<table class="table table-striped">
				<thead>
					<tr>
						<th width="14.3%">&nbsp;</th>
						<th width="14.3%">Tranche 1</th>
						<th width="14.3%">Tranche 2</th>
						<th width="14.3%">Tranche 3</th>
						<th width="14.3%">Tranche 4</th>
						<th width="14.3%">Tranche 5</th>
						<th width="14.3%">Tranche 6</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="control-label">
						Amount<br />
						Amount released<br />
						Date released
						</td>
					<?php
					if (isset($tranches) && $tranches <> 0) 
					{ 
						foreach ($tranches as $tranche) 
						{
							echo '<td>';
							echo number_format($tranche['amount'], 2).'<br />';
							if ($tranche['amount_released'] != '0.00') 
							{ 
								echo number_format($tranche['amount_released'], 2);
							}
							else
							{
								echo 'N/A';
							}
							echo '<br />';
							if ($tranche['date_released'] != '0000-00-00') 
							{ 
								echo $tranche['date_released'];
							}
							else
							{
								echo 'N/A';
							}
							echo '</td>';
						}
					} 
					?>
					</tr>
				</tbody>
				</table>
			</div>
			<!-- end: Tranches -->
			
			<!--
			<div class="control-label col-sm-2">Requirements submitted</div>
			<div class="col-sm-10">
				<?php
					$cover_letter_icon = ($submitted_docs['cover_letter'] == 1) ? 'glyphicon-check' : 'glyphicon-unchecked';
					$summary_sheet_icon = ($submitted_docs['summary_sheet'] == 1) ? 'glyphicon-check' : 'glyphicon-unchecked';
					$proj_proposal_icon = ($submitted_docs['proj_proposal'] == 1) ? 'glyphicon-check' : 'glyphicon-unchecked';
					$proof_of_registration_icon = ($submitted_docs['proof_of_registration'] == 1) ? 'glyphicon-check' : 'glyphicon-unchecked';
					$financial_statements_icon = ($submitted_docs['financial_statements'] == 1) ? 'glyphicon-check' : 'glyphicon-unchecked';
					$commitments_icon = ($submitted_docs['commitments'] == 1) ? 'glyphicon-check' : 'glyphicon-unchecked';
					$endorsements_icon = ($submitted_docs['endorsements'] == 1) ? 'glyphicon-check' : 'glyphicon-unchecked';
					$others_icon = ($submitted_docs['others'] == 1) ? 'glyphicon-check' : 'glyphicon-unchecked';
				?>
				<p><span class="glyphicon <?php echo $cover_letter_icon ?>"></span> Cover letter</p>
				<p><span class="glyphicon <?php echo $summary_sheet_icon ?>"></span> Project summary sheet</p>
				<p><span class="glyphicon <?php echo $proj_proposal_icon ?>"></span> Project proposal</p>
				<p><span class="glyphicon <?php echo $proof_of_registration_icon ?>"></span> Proof of registration with gov't agency</p>
				<p><span class="glyphicon <?php echo $financial_statements_icon ?>"></span> Audited financial statements for last 3 years</p>
				<p><span class="glyphicon <?php echo $commitments_icon ?>"></span> Commitments to partner/support project</p>
				<p><span class="glyphicon <?php echo $endorsements_icon ?>"></span> Endorsement from NCIP/PAMB</p>
				<p><span class="glyphicon <?php echo $others_icon ?>"></span> Others</p>
			</div>
			-->
			<div class="control-label col-sm-2">Project Status</div>
			<div class="col-sm-10">
				<?php 
					switch ($grants_item['project_status']) 
					{
						case 1: $project_status = 'Pending approval'; break;
						case 2: $project_status = 'Approved'; break;
						case 3: $project_status = 'Declined'; break;
						case 4: $project_status = 'Completed'; break;
						case 5: $project_status = 'Cancelled'; break;
						case 6: $project_status = 'Ongoing'; break;
						default: 
							$project_status = '<span class="alert-danger">Error encountered. Contact the Administrator.</span>';
							break;
					}
					echo $project_status;
				?>&nbsp;
			</div>
			<div class="control-label col-sm-2">MOA Number</div>
			<div class="col-sm-10">
				<?php echo $grants_item['moa_number']; ?>&nbsp;
			</div>	
			<div class="control-label col-sm-2">Remarks</div>
			<div class="col-sm-10">
				<?php echo $grants_item['prx']; ?>&nbsp;
			</div>
			<div class="text-right back-link"><a href="javascript:history.go(-1)">&laquo; Back</a></div>
		</div>
		
		<?php 
		//show change history if admin
		if ($this->ion_auth->in_group('admin'))
		{
		?>
			<div class="mod-history-details text-left">
				<h3>CHANGE HISTORY</h3>
				<?php
				//echo '<pre>'; print_r($tracker); echo '</pre>';
				if ($tracker['modified'] != NULL) 
				{
					echo 'Modified: : <br />';
					foreach ($tracker['modified'] as $track) 
					{
						echo $track['timestamp'].' by '.ucfirst($track['user']).'<br >';
						$mod_details = str_replace('|', '<br  />', $track['mod_details']);
						echo 'Details: <br />'.$mod_details.'<br />';
					}
				
				}
				else
				{
					echo 'No modifications since.';
				}
			
				echo '<br />';
			
				if ($tracker['created'] != NULL) 
				{
					echo 'Created: '.$tracker['created']['timestamp'].' by '.ucfirst($tracker['created']['user']);
				}
				else
				{
					echo 'Creation date undefined.';
				}
		
			?>
			</div>
		<?php
		}
		else //show mod request form instead
		{ 
		?>
		<hr />
		<div class="panel-body">
			<div class="form-group" style="padding-bottom: 30px">
				<label class="control-label col-sm-12">DATA MODIFICATION REQUEST FORM</label>
			</div>
		<?php
			$attributes = array('class' => 'form-horizontal', 'role' => 'form');
			echo form_open('grants/change_request', $attributes); 
		?>
			<div class="form-group">
				<label class="control-label col-sm-2" for="">Field(s)<span class="text-info">*</span></label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="fields" />
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2" for="title">New Value(s)<span class="text-info">*</span></label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="new_values" />
				</div>
			</div>	
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<input type="hidden" name="project_id" value="<?php echo $grants_item['project_id']; ?>" />
					<button type="submit" class="btn btn-default">Send Request</button>
				</div>
			</div>
			</form>
		</div>
		<?php
		}
		?>
	</div>
</div>
