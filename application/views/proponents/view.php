<div class="container">
	<h2>Proponent Details</h2>
	<h3><?php echo $proponent_item['organization_name']; ?> 
	<?php if ($this->ion_auth->in_group('admin'))
	{
	?>
	<small>[ <a href="<?php echo site_url('proponents/edit/'.$proponent_item['proponent_id']); ?>">Edit</a> ]</small>
	<?php
	}
	?>
	</h3>
	<div class="panel panel-default">
		<div class="text-right back-link"><a href="javascript:history.go(-1)">&laquo; Back</a></div>
		<div class="panel-body">
			<div class="control-label col-sm-2">Alias</div>
			<div class="col-sm-10">
				<?php echo $proponent_item['alias']; ?>&nbsp;
			</div>
			<div class="control-label col-sm-2">Year established</div>
			<div class="col-sm-10">
				<?php echo $proponent_item['year_established']; ?>&nbsp;
			</div>
			<div class="control-label col-sm-2">Gov't agency registered</div>
			<div class="col-sm-10">
				<?php echo $proponent_item['govt_agency_registered']; ?>&nbsp;
			</div>
			<div class="control-label col-sm-2">Address</div>
			<div class="col-sm-10">
				<?php echo $proponent_item['address']; ?>&nbsp;
			</div>
			<div class="control-label col-sm-2">Telephone</div>
			<div class="col-sm-10">
				<?php echo $proponent_item['telephone']; ?>&nbsp;
			</div>
			<div class="control-label col-sm-2">Fax</div>
			<div class="col-sm-10">
				<?php echo $proponent_item['fax']; ?>&nbsp;
			</div>
			<div class="control-label col-sm-2">Email</div>
			<div class="col-sm-10">
				<?php echo '<a href="mailto:'.$proponent_item['email'].'" target="_blank">'.$proponent_item['email'].'</a>'; ?>&nbsp;
			</div>
			<div class="control-label col-sm-2">Website</div>
			<div class="col-sm-10">
				<?php echo '<a href="'.$proponent_item['website'].'" target="_blank">'.$proponent_item['website'].'</a>'; ?>&nbsp;
			</div>
			<div class="control-label col-sm-2">Signatory name</div>
			<div class="col-sm-10">
				<?php echo $proponent_item['signatory_name']; ?>&nbsp;
			</div>
			<div class="control-label col-sm-2">Signatory position</div>
			<div class="col-sm-10">
				<?php echo $proponent_item['signatory_position']; ?>&nbsp;
			</div>
			<div class="control-label col-sm-2">Contact person</div>
			<div class="col-sm-10">
				<?php echo $proponent_item['contact_person']; ?>&nbsp;
			</div>
			<div class="control-label col-sm-2">Contact position</div>
			<div class="col-sm-10">
				<?php echo $proponent_item['contact_position']; ?>&nbsp;
			</div>
			<div class="control-label col-sm-2">Contact address</div>
			<div class="col-sm-10">
				<?php echo $proponent_item['contact_address']; ?>&nbsp;
			</div>
			<div class="control-label col-sm-2">Contact phone</div>
			<div class="col-sm-10">
				<?php echo $proponent_item['contact_phone']; ?>&nbsp;
			</div>
			<div class="control-label col-sm-2">Contact email</div>
			<div class="col-sm-10">
				<?php echo '<a href="mailto:'.$proponent_item['contact_email'].'">'.$proponent_item['contact_email'].'</a>'; ?>&nbsp;
			</div>
			<div class="control-label col-sm-2">Remarks</div>
			<div class="col-sm-10">
				<?php echo $proponent_item['remarks']; ?>&nbsp;
			</div>
			<div class="col-sm-12"><hr /></div>
			<div class="control-label col-sm-2">Related projects</div>
			<div class="col-sm-10">
				<?php 
					if (is_array($proponent_projects)) 
					{
						//print_r($proponent_projects);
						foreach ($proponent_projects as $project) 
						{
							echo '<a href="'.site_url('grants/'.$project['slug']).'">'.$project['project_title'].'</a>';
							echo '<br />';
						}
					} 
				?>&nbsp;
			</div>
			<div class="text-right back-link"><a href="javascript:history.go(-1)">&laquo; Back</a></div>
		</div>
	</div>
</div>
