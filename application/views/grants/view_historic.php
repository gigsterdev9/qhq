<div class="container">
	<h2><span class="glyphicon glyphicon-folder-open"></span>&nbsp;Historical Grants</h2>
	<h3><span class="glyphicon glyphicon-file"></span> <?php echo $historical_item['title']; ?> <small>[ <a href="<?php echo site_url('grants/edit_historic/'.$historical_item['id']); ?>">Edit</a> ]</small></h3>
	<div class="panel-body">
		<div class="table-responsive">
			<table class="table">
				<tbody>
				<tr>
					<td>Proponent</td>
					<td><?php echo $historical_item['proponent']; ?></td>
				</tr><tr>
					<td>Site</td> 
					<td><?php echo $historical_item['site']; ?></td>
				</tr><tr>
					<td>Description</td>
					<td><?php echo nl2br($historical_item['description']); ?></td>
				</tr><tr>
					<td>Grant amount</td>
					<td><?php echo strtoupper($historical_item['currency']).' '. number_format($historical_item['grant_amount'], 2); ?></td>
				</tr><tr>
					<td>Grant type</td>
					<td><?php echo $historical_item['grant_type']; ?></td> 
				</tr><tr>
					<td>Phase</td>
					<td><?php echo $historical_item['phase']; ?></td> 
				</tr><tr>
					<td>Remarks</td>
					<td><?php echo $historical_item['remarks']; ?></td>
				</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
