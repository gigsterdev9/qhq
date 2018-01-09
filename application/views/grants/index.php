<div class="container-fluid">
	<h2><span class="glyphicon glyphicon-folder-open"></span>&nbsp; <?php echo $title; ?></h2>
	<?php
	if ($this->ion_auth->in_group('admin'))
	{
	?>
	<div class="container-fluid text-right"><a href="grants/add"><span class="glyphicon glyphicon-plus-sign"></span> Add new grant</a> &nbsp; | &nbsp;
	<a href="grants/add_historic"><span class="glyphicon glyphicon-plus-sign"></span> Add historical grant</a></div>
	<?php
	}
	?>
	<p>&nbsp;</p>
	<div class="container-fluid text-right">
		<?php 
			$attributes = array('class' => 'form-inline', 'role' => 'form');
			echo form_open('grants/', $attributes); 
		?>
			<div class="form-group">
				<label class="control-label" for="title">Search Grant</label> &nbsp; 
				<input type="input" class="form-control" name="search_param" />
				<input type="submit" class="form-control" value="&raquo;" />
			</div>
		<?php echo form_close();?>
	</div>
	<div class="container-fluid">
		<?php 
			$attributes = array('class' => 'form-inline', 'role' => 'form');
			echo form_open('grants/', $attributes); 
		?>
			<div class="form-group">
				<label class="control-label" for="title">Filter by:</label> &nbsp; 
				<select name="filter_by" id="filter_by" class="form-control">
					<option value=""></option>
					<option value="site">Site</option>
					<option value="type">Grant type</option>
					<option value="status">Status</option>
					<option value="year">Year Approved</option>
					<option value="output">Output</option>
				</select>
				<select name="filter_by_site" id="filter_by_site" class="form-control" style="display:none">
					<option value="1">Palawan</option>
					<option value="2">Samar Island</option>
					<option value="3">Sierra Madre</option>
				</select>
				<select name="filter_by_type" id="filter_by_type" class="form-control" style="display:none">
					<option value="small">Small</option>
					<option value="planning">Planning grant</option>
					<option value="strategic">Strategic grant</option>
				</select>
				<select name="filter_by_status" id="filter_by_status" class="form-control" style="display:none">
					<option value="1">Pending approval</option>
					<option value="2">Approved</option>
					<option value="3">Declined</option>
					<option value="4">Completed</option>
					<option value="5">Cancelled</option>
					<option value="6">Ongoing</option>
				</select>
				<select name="filter_by_year" id="filter_by_year" class="form-control" style="display:none">
					<option value="2014">2014</option>
					<option value="2015">2015</option>
					<option value="2016">2016</option>
					<option value="2017">2017</option>
				</select>
				<select name="filter_by_output" id="filter_by_output" class="form-control" style="display:none">
					<option value="1.1.1">1.1</option>
					<option value="1.1.2">1.2</option>
					<option value="1.1.3">1.3</option>
					<option value="1.1.4">1.4</option>
					<option value="2.2.1">2.1</option>
					<option value="2.2.2">2.2</option>
					<option value="2.3.1">3.1</option>
					<option value="3.4.1">4.1</option>
					<option value="3.4.2">4.2</option>
					<option value="3.4.3">4.3</option>
					<option value="3.4.4">4.4</option>
					<option value="3.5.1">5.1</option>
					<option value="3.5.2">5.2</option>
					<option value="3.5.3">5.3</option>
				</select>	
				<input type="submit" class="form-control" value="&raquo;" />
			</div>
		<?php echo form_close();?>
	</div>
	<p>&nbsp;</p>
	<h3>
		<span class="glyphicon glyphicon-folder-open"></span>&nbsp; Phase 5 Grants
	</h3>
	<div class="container-fluid">
		<small>
		<?php 
			if (isset($filterval)) 
			{ 
				$url = 'grants/filtered_to_excel/'.$filterval[0].'/'.$filterval[1];
			}
			else if (isset($searchval))
			{
				$url = 'grants/results_to_excel/'.$searchval;
			}
			else
			{
				$url = 'grants/all_to_excel';
			}
			
			echo '<a href="'.$url.'" target="_blank">Export to Excel &raquo;</a>';	
		?>
		</small>
	</div>
	<div class="table-responsive">
		<table class="table table-striped">
			<thead>
				<tr>
					<th width="50%">Title</th>
					<th width="20%">Proponent</th>
					<th width="10%">Site</th>
					<th width="10%">Project budget<br /><small>(in PHP)</small></th>
					<th width="5%">Grant type</th>
					<th width="5%">Status</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($grants as $grants_item): ?>
				<tr>
					<td>
						<a href="<?php echo site_url('grants/'.$grants_item['slug']); ?>">
							<span class="glyphicon glyphicon-file"></span> <?php echo $grants_item['project_title'].' ('.$grants_item['moa_number'].')'; ?>
						</a>
					</td>
					<td>
						<a href="<?php echo site_url('proponents/'.$grants_item['proponent_id']); ?>">	
							<?php echo $grants_item['organization_name']; ?>
						</a>
					</td>
					<td><?php echo $grants_item['location_name']; ?></td>
					<td><?php echo number_format($grants_item['project_budget'], 2); ?></td>
					<td><?php echo $grants_item['grant_type']; ?></td>
					<td>
					<?php 
						switch ($grants_item['project_status'])
							{
							case '1': $status = 'Pending approval'; break;
							case '2': $status = 'Approved'; break;
							case '3': $status = 'Declined'; break;
							case '4': $status = 'Completed'; break;							
							case '5': $status = 'Cancelled'; break;
							case '6': $status = 'Ongoing'; break;
							default: $status = null; break;
							} 
						echo $status;
					?>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
	
	<h3><span class="glyphicon glyphicon-folder-open"></span>&nbsp; Historical Grants</h3>
	<div class="table-responsive">
		<table class="table table-striped">
			<thead>
				<tr>
					<th width="50%">Title</th>
					<th width="20%">Proponent</th>
					<th width="10%">Site</th>
					<th width="10%">Project budget</th>
					<th width="5%">Grant type</th>
					<th>&nbsp;</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($historical_grants as $grants_item): ?>
				<tr>
					<td>
						<a href="<?php echo site_url('grants/historic/'.$grants_item['slug']); ?>">
							<span class="glyphicon glyphicon-file"></span> <?php echo $grants_item['title']; ?>
						</a>
					</td>
					<td><?php echo $grants_item['proponent']; ?></td>
					<td><?php echo $grants_item['site']; ?></td>
					<td><?php echo number_format($grants_item['grant_amount'], 2) . ' <small>('.$grants_item['currency'].')</small> '; ?></td>
					<td><?php echo $grants_item['grant_type']; ?></td>
					<td>&nbsp;</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>
<script>
	$('#filter_by').on('change', function(){
		var myval = $(this).val();
		//alert(myval);
		
    	if (myval == 'site') {
    		$('#filter_by_site').show();
    		$('#filter_by_type').hide();
    		$('#filter_by_status').hide();
    		$('#filter_by_year').hide();
    		$('#filter_by_output').hide();
    	}
    	else if(myval == 'type'){
    		$('#filter_by_site').hide();
    		$('#filter_by_type').show();
    		$('#filter_by_status').hide();
    		$('#filter_by_year').hide();
    		$('#filter_by_output').hide();
    	}
    	else if(myval == 'status'){
    		$('#filter_by_site').hide();
    		$('#filter_by_type').hide();
    		$('#filter_by_status').show();
    		$('#filter_by_year').hide();
    		$('#filter_by_output').hide();
    	}
    	else if(myval == 'year'){
    		$('#filter_by_site').hide();
    		$('#filter_by_type').hide();
    		$('#filter_by_status').hide();
    		$('#filter_by_year').show();
    		$('#filter_by_output').hide();
    	}
    	else if(myval == 'output'){
    		$('#filter_by_site').hide();
    		$('#filter_by_type').hide();
    		$('#filter_by_status').hide();
    		$('#filter_by_year').hide();
    		$('#filter_by_output').show();
    	}
    	else{
    		
    	}
    	
	});
</script>
