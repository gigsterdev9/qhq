<div class="container">
	<h2><span class="glyphicon glyphicon-user"></span>&nbsp; <?php echo $title; ?></h2>
	<div class="container-fluid text-right">
		<!-- <a href="<?php echo base_url('tracker/add') ?>">
        <span class="glyphicon glyphicon-plus-sign"></span> New user</a>  -->
        &nbsp;
	</div>
	<p>&nbsp;</p>
	<div class="container-fluid text-right">
        <!--
		<?php 
			$attributes = array('class' => 'form-inline', 'role' => 'form');
			echo form_open('tracker/', $attributes); 
		?>
			<div class="form-group">
				<label class="control-label" for="title">Search Activity</label> &nbsp; 
				<input type="input" class="form-control" name="search_param" />
				<input type="submit" class="form-control" value="&raquo;" />
			</div>
        <?php echo form_close();?>
        -->
        &nbsp;
	</div>
	<p>&nbsp;</p>
	<div class="panel panel-default">
		<div class="table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
						<th width="10%">Activity</th>
						<th width="27%">Details</th>
						<th width="10%">User</th>
                        <th width="10%">Ben ID</th>
                        <th width="10%">COMELEC ID</th>
                        <th width="10%">Scholarship ID</th>
                        <th width="10%">Service ID</th>
                        <th width="13%">Time Stamp</th>
					</tr>
				</thead>
				<tbody>
					<?php
					
					foreach ($activities as $activity) {
					?>
					<tr>
                        <td><?php echo $activity['activity']; ?></td>
						<td><?php echo $activity['mod_details']; ?></td>
						<td><?php echo $activity['user']; ?></td>
                        <td><?php echo $activity['ben_id']; ?></td>
                        <td><?php echo $activity['id_no_comelec']; ?></td>
                        <td><?php echo $activity['scholarship_id']; ?></td>
                        <td><?php echo $activity['service_id']; ?></td>
                        <td><?php echo $activity['timestamp']; ?></td>
					</tr>
					<?php
					}
					
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>
