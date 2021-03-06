<div class="container">
	<h2><?php echo $title; ?></h2>
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
					Historical grant entry added.
				</div>
			<?php
			}
		
				$attributes = array('class' => 'form-horizontal', 'role' => 'form');
				echo form_open('grants/add_historic', $attributes); 
			?>
				<div class="form-group">
					<label class="control-label col-sm-2" for="title">Title<span class="text-info">*</span></label>
					<div class="col-sm-10">
						<input type="input" class="form-control" name="title" required />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="proponent">Proponent<span class="text-info">*</span></label>
					<div class="col-sm-10">
						<input type="input" class="form-control" name="proponent" required />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="site">Site</label>
					<div class="col-sm-10">
						<input type="input" class="form-control" name="site" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="description">Description</label>
					<div class="col-sm-10">
						<textarea name="description" class="form-control" rows="5"></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="grant_amount">Grant amount</label>
					<div class="col-sm-10">	
						<input type="input" class="form-control" name="grant_amount" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="currency">Currency</label>
					<div class="col-sm-10">	
						<select class="form-control" name="currency" >
							<option class="form-control" value="" >Select currecy</option>
							<option class="form-control" value="PHP" >PHP</option>
							<option class="form-control" value="USD" >USD</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="grant_type">Grant type</label>	
					<div class="col-sm-10">
						<input type="input" class="form-control" name="grant_type" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="phase">Phase</label>	
					<div class="col-sm-10">
						<select class="form-control" name="phase" >
							<option class="form-control" value="">Select phase</option>
							<option class="form-control" value="Pilot">Pilot</option>
							<option class="form-control" value="1">1</option>
							<option class="form-control" value="2">2</option>
							<option class="form-control" value="3">3</option>
							<option class="form-control" value="4">4</option>
							<option class="form-control" value="COMPACT">COMPACT</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="remarks">Remarks</label>
					<div class="col-sm-10">
						<textarea name="remarks" class="form-control" rows="5"></textarea>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<button type="submit" class="btn btn-default">Submit</button>
					</div>
				</div>
			</form>
			</div>
	</div>
</div>
