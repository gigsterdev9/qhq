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
					<?php echo $alert_success ?>
				</div>
			<?php
			}
			
				$attributes = array('class' => 'form-horizontal', 'role' => 'form');
				echo form_open('grants/edit_historic/'.$grant_item['id'], $attributes); 
			?>
				<div class="form-group">
					<label class="control-label col-sm-2" for="title">Title<span class="text-info">*</span></label>
					<div class="col-sm-10">
						<input type="input" class="form-control" name="title" value="<?php echo $grant_item['title'] ?>" required />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="proponent">Proponent<span class="text-info">*</span></label>
					<div class="col-sm-10">
						<input type="input" class="form-control" name="proponent" value="<?php echo $grant_item['proponent'] ?>"required />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="site">Site</label>
					<div class="col-sm-10">
						<input type="input" class="form-control" name="site" value="<?php echo $grant_item['site'] ?>" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="description">Description</label>
					<div class="col-sm-10">
						<textarea name="description" class="form-control" rows="5"><?php echo $grant_item['description'] ?></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="grant_amount">Grant amount</label>
					<div class="col-sm-10">	
						<input type="input" class="form-control" name="grant_amount" value="<?php echo $grant_item['grant_amount'] ?>"/>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="currency">Currency</label>
					<div class="col-sm-10">	
						<select class="form-control" name="currency" >
							<option class="form-control" value="" >Select currecy</option>
							<option class="form-control" value="PHP" <?php if ($grant_item['currency'] == 'PHP') echo 'selected'; ?> >PHP</option>
							<option class="form-control" value="USD" <?php if ($grant_item['currency'] == 'USD') echo 'selected'; ?> >USD</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="grant_type">Grant type</label>	
					<div class="col-sm-10">
						<input type="input" class="form-control" name="grant_type" value="<?php echo $grant_item['grant_type'] ?>" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="phase">Phase</label>	
					<div class="col-sm-10">
						<select class="form-control" name="phase" >
							<option class="form-control" value="" >Select phase</option>
							<option class="form-control" value="Pilot" <?php if ($grant_item['phase'] == 'Pilot') echo 'selected'; ?> >Pilot</option>
							<option class="form-control" value="1" <?php if ($grant_item['phase'] == '1') echo 'selected'; ?> >1</option>
							<option class="form-control" value="2" <?php if ($grant_item['phase'] == '2') echo 'selected'; ?> >2</option>
							<option class="form-control" value="3" <?php if ($grant_item['phase'] == '3') echo 'selected'; ?> >3</option>
							<option class="form-control" value="4" <?php if ($grant_item['phase'] == '4') echo 'selected'; ?> >4</option>
							<option class="form-control" value="COMPACT" <?php if ($grant_item['phase'] == 'COMPACT') echo 'selected'; ?> >COMPACT</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="remarks">Remarks</label>
					<div class="col-sm-10">
						<textarea name="remarks" class="form-control" rows="5"><?php echo $grant_item['remarks'] ?></textarea>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<div class="checkbox">
							<?php $trash_flag = ($grant_item['trash'] == 1) ? 'checked' : ''; ?>
							<label><input type="checkbox" name="trash" value="1" <?php echo $trash_flag ?> >Delete this entry</label>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<input type="hidden" name="action" value="1" />
						<input type="hidden" name="id" value="<?php echo $grant_item['id'] ?>" />
						<button type="submit" class="btn btn-default">Submit</button>
					</div>
				</div>
			</form>
			</div>
	</div>
</div>
