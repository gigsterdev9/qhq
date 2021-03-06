<div class="container-fluid">
	<h2><span class="glyphicon glyphicon-link"></span>&nbsp; <?php echo $title; ?></h2>
	<?php
	if ($this->ion_auth->in_group('admin'))
	{
	?>
	<div class="container-fluid text-right">
		<a href="<?php echo base_url('proponents/add') ?>">
		<span class="glyphicon glyphicon-plus-sign"></span> New Proponent</a>
	</div>
	<?php
	}
	?>
	<p>&nbsp;</p>
	<div class="container-fluid text-right">
		<?php 
			$attributes = array('class' => 'form-inline', 'role' => 'form');
			echo form_open('proponents', $attributes); 
		?>
			<div class="form-group">
				<label class="control-label" for="title">Search Proponent</label> &nbsp; 
				<input type="input" class="form-control" name="search_param" />
				<input type="submit" class="form-control" value="&raquo;" />
			</div>
		<?php echo form_close();?>
	</div>
	<p>&nbsp;</p>
	<div class="table-responsive">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Organization name</th>
					<th>Signatory</th>
					<th>Contact person</th>
					<th>Contact phone/email</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($proponents as $proponent): ?>
				<tr>
					<td>
						<a href="<?php echo base_url('proponents/'.$proponent['proponent_id']); ?>"> 
							<span class="glyphicon glyphicon-link"></span> &nbsp;<?php echo $proponent['organization_name']; ?>
							(<?php echo $proponent['alias']; ?>)
						</a>
					</td>
					<td><?php echo $proponent['signatory_name'].' ('.$proponent['signatory_position'].')'; ?></td>
					<td><?php echo $proponent['contact_person'].' ('.$proponent['contact_position'].')'; ?></td>
					<td>
						<?php echo $proponent['contact_phone'].' / '; ?>
						<?php echo '<a href="mailto:'.$proponent['contact_email'].'" target="_blank">'.$proponent['contact_email'].'</a>'; ?>
					</td>					
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
	
</div>

