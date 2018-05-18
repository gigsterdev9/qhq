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

			if (isset($notice)) {
				?>
					<div class="alert alert-warning">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<?php 
							echo 'Data issues encountered. ';
							echo '('. count($notice) .')';
							echo '<br />';
							if (array($notice)) {
								foreach ($notice as $n) {
									echo $n.'<br />';
								}
							}
						?> 
						<!--<a href="<?php echo base_url('services') ?>">Return to Index.</a>-->
					</div>
				<?php 
				}

			if (isset($import_success) && ($import_success == TRUE)) { 
			?>
				<div class="alert alert-success">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					Process completed. <?php //echo '<pre>'; print_r($upload_details); echo '</pre>' ?> 
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
			
			/*
			if (isset($import_success) && ($import_success == TRUE)) {  
				echo '<pre>'; print_r($flow); echo '</pre>';
			}
			*/

			?>

		</div>
	</div>

    <div class="panel panel-default">
		<div class="panel-body">
            <h3>Proper Usage Guide</h3>
                <ul>
                    <li>ONLY upload a properly structured CSV file. Refer to the <a href="<?php echo (base_url('downloads/test-data-services-insti.csv') ); ?>">sample CSV file</a>. 
                    <li>It is mportant to keep the column headers UNCHANGED (i.e. order, spelling and capitalization).</li>
                    <li>Use the date format: (YYYY-MM-DD); Feb 15, 2018 would thus be 2018-02-15</li>
                    <li>Be mindful of the values for the barangay column, including <u>Capitalization</u>: 
                        <ul>
                            <li>Barangka</li>
                            <li>Concepcion Uno</li>
                            <li>Concepcion Dos</li>
                            <li>Fortune</li>
                            <li>Industrial Valley Complex</li>
                            <li>Jesus Dela Peña</li>
                            <li>Kalumpang</li>
                            <li>Malanday</li>
                            <li>Marikina Heights</li>
                            <li>Nangka</li>
                            <li>Parang</li>
                            <li>Santo Niño</li>
                            <li>San Roque</li>
                            <li>Santa Elena</li>
                            <li>Tañong</li>
                            <li>Tumana</li>
                        </ul>
                    </li>
                    <li>Be mindful of the values for the service type column, including <u>capitalization</u>: 
                        <ul>
                            <li>burial</li>
                            <li>endorsements</li>
                            <li>financial</li>
                            <li>legal</li>
                            <li>medical</li>
                            <li>referral</li>
                        </ul>
                    </li>
                    <li>Ensure all entries are CLEAN (e.g. no extra spaces before or after) and free of spelling errors. Helen is not the same as Helne.</li>
                    <li>After adding in the entries, make sure it is still saved as CSV; set the field delimiter: semi-colon, values encapsulation: quote marks</li>
                    <li>Double check the CSV file by opening it in a text editor like Notepad and comparing them with the entries in the spreadsheet.</li>
                    <li>Limit entries to a max of 1000 per file upload to facilitate damage control, if any; the lesser the number of erroneous entries, the less tedious damage control will be. operators should always double check the entries of uploaded files. for the first few uploads (until operator is already comfortable, I suggest starting with a low number, like 100)</li>
                </ul>    
                    <p>Note that requestors will all be tagged as “SELF” (as all requestors must be in the beneficiaries table. Unless the data to be imported contains enough data to check/load requestor info into system, i.e. same data as beneficiary) - this will be an issue with burials and should probably be manually addressed.</p>

                    <p>&nbsp;</p>

                    <p>Here is a demo video for a better understanding of the process:</p>
                    <iframe width="630" height="394" src="https://www.useloom.com/embed/fb5cfcbea98c4db594ff0a28309e68fa" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                    <p>In the video, note that the file was processed twice. The second time, it detected that the records  already exist.</p>
                    <p>If the video above isn't working, follow this link <a href="https://www.useloom.com/share/fb5cfcbea98c4db594ff0a28309e68fa">[Q-CRM] CSV upload of services records video</a>.</p>
                    
                    <p>&nbsp;</p>

                    <h5>Addendum:</h5>
                    <p>The field name INSTITUTION has been added into the services table and into the import process. The instructions and process remain the same, only the CSV file structure is modified. A column for INSTITUTION now appears between PARTICULARS and AMOUNT. An updated sample CSV is attached. Again, the instructions are to be followed to the letter. </p>

                    <hr />
                    <p><a href="<?php echo (base_url('downloads/test-data-services-insti.csv') ); ?>">Download sample CSV data here</a>.</p>
                    <p>&nbsp;</p>
                    <p><a href="<?php echo base_url('services'); ?>"><?php echo base_url('services'); ?></a></p>

        </div>
    </div>
</div>
