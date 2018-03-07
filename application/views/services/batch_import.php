<?php 
//echo CI_VERSION;
?>
<div class="container">
	<h2><?php echo $title; ?></h2>
	<p><a href="javascript:history.go(-1)" ><span class="glyphicon glyphicon-remove-sign"></span> Cancel</a></p>
	<div class="panel panel-default">
		<div class="panel-body">
			<p>This process will upload data from a previously prepared text file. Remember to ONLY upload a properly structured CSV file. </p>
			
			<?php 
			if (isset($error)) {
			?>
				<div class="alert alert-danger">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					Data processing failed. <?php echo $error['error']; ?> 
					<a href="<?php echo base_url('services') ?>">Return to Index.</a>
				</div>
			<?php 
			}

			if (isset($import_success) && ($import_success == TRUE)) { 
			?>
				<div class="alert alert-success">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					Data upload successful. <?php //echo '<pre>'; print_r($upload_details); echo '</pre>' ?> 
					<a href="<?php echo base_url('services') ?>">Return to Index.</a>
				</div>
			<?php
			}
		
			$attributes = array('class' => 'form-horizontal', 'role' => 'form', 'id' => 'form-upload-csv', 'method' => 'post');
			echo form_open_multipart('services/batch_import', $attributes); 
			?>
						<!-- <input type="text" class="form-control" name="source_file" id="source_file" required /> -->
						<input name="userfile" class="form-control" type="file" id="userfile" />
						<!-- <button type="submit" class="btn btn-default" id="match_submit">Submit</button> -->
						<input type="hidden" name="action" value="upload" />
						<input type="submit" class="btn btn-default" id="upload_csv" name="upload_csv" value="Upload file" />
			
			<?php 
			echo form_close(); 
			
			if (isset($import_success) && ($import_success == TRUE)) {  
				echo '<pre>'; print_r($flow); echo '</pre>';
			}
			
			?>

		</div>

	</div>
</div>
