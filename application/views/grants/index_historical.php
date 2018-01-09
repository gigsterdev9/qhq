<div class="container-fluid">
	<h2><span class="glyphicon glyphicon-folder-open"></span>&nbsp; <?php echo $title; ?></h2>
	<div class="container-fluid text-right"><a href="grants/add"><span class="glyphicon glyphicon-plus-sign"></span> New grant</a> &nbsp; | &nbsp;
	<a href="grants/add_historic"><span class="glyphicon glyphicon-plus-sign"></span> Add historical grant</a></div>
	<p>&nbsp;</p>

	<h3><span class="glyphicon glyphicon-folder-open"></span>&nbsp; Historical Grants</h3>
	<div class="table-responsive">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Title</th>
					<th>Proponent</th>
					<th>Site</th>
					<th>Grant amount<br /><small>(in PHP)</small></th>
					<th>Grant type</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($historical_grants as $grants_item): ?>
				<tr>
					<td>
						<a href="<?php echo site_url('grants/historic/'.$grants_item['slug']); ?>">
							<strong><span class="glyphicon glyphicon-file"></span> <?php echo $grants_item['title']; ?></strong>
						</a>
					</td>
					<td><?php echo $grants_item['proponent']; ?></td>
					<td><?php echo $grants_item['site']; ?></td>
					<td><?php echo number_format($grants_item['grant_amount'], 2); ?></td>
					<td><?php echo $grants_item['grant_type']; ?></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>

