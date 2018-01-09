<div class="container-fluid">
	<h2><span class="glyphicon glyphicon-folder-open"></span>&nbsp; <?php echo $title; ?></h2>
	<?php
	if ($this->ion_auth->in_group('admin'))
	{
	?>
	<div class="container-fluid text-right"><a href="grants/add"><span class="glyphicon glyphicon-plus-sign"></span> New entry</a></div>
	<?php
	}
	?>
	<p>&nbsp;</p>
	<div class="container-fluid text-right">
		<?php 
			$attributes = array('class' => 'form-inline', 'role' => 'form');
			echo form_open('rvoters/', $attributes); 
		?>
			<div class="form-group">
				<label class="control-label" for="title">Search Voter</label> &nbsp; 
				<input type="input" class="form-control" name="search_param" />
				<input type="submit" class="form-control" value="&raquo;" />
			</div>
		<?php echo form_close();?>
	</div>
	<div class="container-fluid">
		<?php 
			$attributes = array('class' => 'form-inline', 'role' => 'form');
			echo form_open('rvoters/', $attributes); 
		?>
			<div class="form-group">
				<label class="control-label" for="title">Filter by:</label> &nbsp; 
				<select name="filter_by" id="filter_by" class="form-control">
					<option value=""></option>
					<option value="brgy">Barangay</option>
				</select>
				<select name="filter_by_brgy" id="filter_by_brgy" class="form-control" style="display:none">
					<option value="Concepcion Uno">Concepcion Uno</option>
					<option value="Concepcion Dos">Concepcion Dos</option>
					<option value="Fortune">Fortune</option>
					<option value="Marikina Heights">Marikina Heights</option>
					<option value="Nangka">Nangka</option>
					<option value="Parang">Parang</option>
					<option value="Tumana">Tumana</option>
				</select>
				<input type="submit" class="form-control" value="&raquo;" />
			</div>
		<?php echo form_close();?>
	</div>
	<p>&nbsp;</p>
	<h3>
		<span class="glyphicon glyphicon-folder-open"></span>&nbsp; Registered Voters
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
			
			//echo '<a href="'.$url.'" target="_blank">Export to Excel &raquo;</a>';	
		?>
		</small>
	</div>
	<div class="table-responsive">
		<table class="table table-striped">
			<thead>
				<tr>
					<th width="15%">Full Name</th>
					<th width="5%">DOB</th>
					<th width="20%">Complete Address</th>
					<th width="10%">Barangay</th>
					<th width="5%">Sex</th>
					<th width="5%">Precinct No.</th>
					<th width="10%">Mobile Number</th>
					<th width="10%">Email</th>
					<th width="10%">Referee</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($rvoters as $rvoter): ?>
				<tr>
					<td>
						<a href="<?php echo site_url('rvoters/'.$rvoter['id']); ?>">
							<span class="glyphicon glyphicon-file"></span> <?php echo $rvoter['lname'].', '.$rvoter['fname']; ?>
						</a>
					</td>
					<td><?php echo $rvoter['dob']; ?></td>
					<td><?php echo $rvoter['address']; ?></td>
					<td><?php echo $rvoter['barangay']; ?></td>
					<td><?php echo $rvoter['sex']; ?></td>
					<td><?php echo $rvoter['precinct']; ?></td>
					<td><?php echo $rvoter['mobile_no']; ?></td>
					<td><?php echo $rvoter['email']; ?></td>
					<td><?php echo $rvoter['referee']; ?></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
	
	<!--
	<h3><span class="glyphicon glyphicon-folder-open"></span>&nbsp; Non-regisered Constituents</h3>
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
	-->
</div>
<script>
	$('#filter_by').on('change', function(){
		var myval = $(this).val();
		//alert(myval);
		
    	if (myval == 'brgy') {
    		$('#filter_by_brgy').show();
    		$('#filter_by_somethingelse').hide();
    	}
    	else if(myval == 'somethingelse'){
    		$('#filter_by_brgy').hide();
    		$('#filter_by_somethingelse').show();
    	}
    	else{
    		
    	}
    	
	});
</script>
