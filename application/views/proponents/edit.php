<div class="container">
	<h2>Edit Details</h2>
	<h3><?php echo $title; ?></h3>
	<p><a href="javascript:history.go(-1)" ><span class="glyphicon glyphicon-remove-sign"></span> Cancel</a></p>
	<div class="panel panel-default">
		<div class="panel-body">
			<p class="small"><span class="text-info">*</span> Indicates a required field</p>
			<?php 
			echo '<div class="text-warning">';
			echo validation_errors();
			echo '</div>'; 

			if (isset($alert_success)) 
			{ 
			?>
				<div class="alert alert-success">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					Proponent updated. <a href="<?php echo base_url('proponents') ?>">Return to Index.</a>
				</div>
			<?php
			}
				
				
				$attributes = array('class' => 'form-horizontal', 'role' => 'form');
				echo form_open('proponents/edit/'.$proponent_item['proponent_id'], $attributes); 
			?>
				<div class="form-group">
					<label class="control-label col-sm-2" for="organization_name">Organization Name<span class="text-info">*</span></label>
					<div class="col-sm-10">
						<input type="input" class="form-control" name="organization_name" value="<?php echo $proponent_item['organization_name'] ?>" required />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="alias">Alias</label>
					<div class="col-sm-10">
						<input type="input" class="form-control" name="alias" value="<?php echo $proponent_item['alias'] ?>" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="year_established">Year established</label>
					<div class="col-sm-10">
						<input type="input" class="form-control" name="year_established" value="<?php echo $proponent_item['year_established'] ?>"/>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="govt_agency_registered">Gov't agency registered</label>
					<div class="col-sm-10">	
						<input type="input" class="form-control" name="govt_agency_registered" value="<?php echo $proponent_item['govt_agency_registered'] ?>" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="address">Address</label>
					<div class="col-sm-10">
						<input type="input" class="form-control" name="address" value="<?php echo $proponent_item['address'] ?>"/>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="telephone">Telephone</label>
					<div class="col-sm-10">
						<input type="input" class="form-control" name="telephone" value="<?php echo $proponent_item['telephone'] ?>" />
					</div>	
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="fax">Fax</label>
					<div class="col-sm-10">
						<input type="input" class="form-control" name="fax" value="<?php echo $proponent_item['fax'] ?>" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="email">Email<span class="text-info">*</span></label>
					<div class="col-sm-10">
						<input type="email" class="form-control" name="email" value="<?php echo $proponent_item['email'] ?>" required />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="website">Website</label>
					<div class="col-sm-10">
						<input type="input" class="form-control" name="website" value="<?php echo $proponent_item['website'] ?>" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="signatory_name">Signatory name<span class="text-info">*</span></label>
					<div class="col-sm-10">
						<input type="input" class="form-control" name="signatory_name" value="<?php echo $proponent_item['signatory_name'] ?>" required />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="signatory_position">Signatory position<span class="text-info">*</span></label>
					<div class="col-sm-10">
						<input type="input" class="form-control" name="signatory_position" value="<?php echo $proponent_item['signatory_position'] ?>" required />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="contact_person">Contact person<span class="text-info">*</span></label>
					<div class="col-sm-10">
						<input type="input" class="form-control" name="contact_person" value="<?php echo $proponent_item['contact_person'] ?>" required />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="contact_position">Contact position</label>
					<div class="col-sm-10">
						<input type="input" class="form-control" name="contact_position" value="<?php echo $proponent_item['contact_position'] ?>" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="contact_address">Contact address<span class="text-info">*</span></label>
					<div class="col-sm-10">
						<input type="input" class="form-control" name="contact_address" value="<?php echo $proponent_item['contact_address'] ?>" required />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="contact_phone">Contact phone<span class="text-info">*</span></label>
					<div class="col-sm-10">
						<input type="input" class="form-control" name="contact_phone" value="<?php echo $proponent_item['contact_phone'] ?>" required />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="contact_email">Contact email<span class="text-info">*</span></label>
					<div class="col-sm-10">
						<input type="email" class="form-control" name="contact_email" value="<?php echo $proponent_item['contact_email'] ?>" required />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="remarks">Remarks</label>
					<div class="col-sm-10">
						<textarea name="remarks" class="form-control" rows="5"><?php echo $proponent_item['remarks'] ?></textarea>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<input type="hidden" name="action" value="1" />
						<input type="hidden" name="proponent_id" value="<?php echo $proponent_item['proponent_id'] ?>" />
						<button type="submit" class="btn btn-default">Submit</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<?php
//$this->output->enable_profiler(TRUE);
?>
