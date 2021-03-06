<div class="container">
	<h2><span class="glyphicon glyphicon-user"></span>&nbsp; <?php echo $title; ?></h2>
	<div class="container-fluid text-right">
		<a href="<?php echo base_url('users/add') ?>">
		<span class="glyphicon glyphicon-plus-sign"></span> New user</a>
	</div>
	<p>&nbsp;</p>
	<div class="container-fluid text-right">
		<?php 
			$attributes = array('class' => 'form-inline', 'role' => 'form');
			echo form_open('users/', $attributes); 
		?>
			<div class="form-group">
				<label class="control-label" for="title">Search User</label> &nbsp; 
				<input type="input" class="form-control" name="search_param" />
				<input type="submit" class="form-control" value="&raquo;" />
			</div>
		<?php echo form_close();?>
	</div>
	<p>&nbsp;</p>
	<div class="panel panel-default">
		<div class="table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
						<th width="20%">Username</th>
						<th width="20%">Name</th>
						<th width="20%">Email</th>
						<th width="20%">Organization/Affiliation</th>
						<th width="10%">User Group</th>
						<th width="10%">Status</th>
					</tr>
				</thead>
				<tbody>
					<?php
					
					foreach ($users as $user) 
					{
						$status = ($user['active'] == 1) ? 'Active' : 'Inactive';
					?>
					<tr>
						<td>
							<a href="<?php echo base_url('users/edit/'.$user['user_id']); ?>">
							<span class="glyphicon glyphicon-user"></span> &nbsp;<?php echo $user['username']; ?></a>
						</td>
						<td><?php echo $user['first_name'].' '.$user['last_name']; ?></td>
						<td><?php echo $user['email']; ?></td>
						<td><?php echo $user['company']; ?></td>
						<td><?php echo $user['description']; ?></td>
						<td><?php echo $status ?></td>
					</tr>
					<?php
					}
					
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>
