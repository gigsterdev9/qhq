<?php include_once('templates/header.php') ?>
<h1>UNDP-SGP5 Grants Info System</h1>
<h2><?php echo lang('change_password_heading');?></h2>

<div id="infoMessage" class="alert alert-warning"><?php echo $message;?></div>

<?php 
	$attributes = array('class' => '', 'role' => 'form');	
	echo form_open("auth/change_password", $attributes);
?>

      <div class="form-group">
  			<?php $attrib_input = array('class' => 'form-control'); ?>
            <?php echo lang('change_password_old_password_label', 'old_password');?> 
            <?php echo form_input($old_password, '', $attrib_input);?>
      </div>

      <div class="form-group">
            <label for="new_password"><?php echo sprintf(lang('change_password_new_password_label'), $min_password_length);?></label> 
            <?php echo form_input($new_password, '', $attrib_input);?>
      </div>

      <div class="form-group">
            <?php echo lang('change_password_new_password_confirm_label', 'new_password_confirm');?> 
            <?php echo form_input($new_password_confirm, '', $attrib_input);?>
      </div>

      <?php echo form_input($user_id);?>
      <div class="form-group">
      	<?php $attrib_btn = array('class' => 'btn btn-default'); ?>
      	<?php echo form_submit('submit', lang('change_password_submit_btn'), $attrib_btn);?>
      </div>

<?php echo form_close();?>
<a href="javascript:history.go(-1)"><span class="glyphicon glyphicon-remove-sign"></span> Cancel</a>
<?php include_once('templates/footer.php') ?>
