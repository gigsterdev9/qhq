<?php include_once('templates/header.php') ?>

<h1>Q-CRM System</h1>
<h2><?php echo lang('forgot_password_heading');?></h2>
<p><?php echo sprintf(lang('forgot_password_subheading'), $identity_label);?></p>

<div id="infoMessage"><?php echo $message;?></div>

<?php 
	$attributes = array('class' => 'form-inline', 'role' => 'form');
	echo form_open("auth/forgot_password");
?>

    <div class="form-group">
      	<label for="identity">
      		<?php echo (($type=='email') ? sprintf(lang('forgot_password_email_label'), $identity_label) : sprintf(lang('forgot_password_identity_label'), $identity_label));?>
      	</label> 
      	<?php $attrib_input = array('class' => 'form-control'); ?>
		<?php echo form_input($identity, '', $attrib_input);?>
	</div>

	<div class="form-group">
  		<?php $attrib_btn = array('class' => 'btn btn-default'); ?>
      	<?php echo form_submit('submit', lang('forgot_password_submit_btn'), $attrib_btn);?>
	</div>

<?php echo form_close();?>
<a href="javascript:history.go(-1)"><span class="glyphicon glyphicon-remove-sign"></span> Cancel</a>
<?php include_once('templates/footer.php') ?>
