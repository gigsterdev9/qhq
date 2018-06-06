<?php include_once('templates/header.php') ?>
<h1>Q-CRM System</h1>
<h2>Login</h2>
<p>This is the Q-CRM System, the Constituent Relationship Management System for the <strong>Office of Representative Romero Federico Quimbo</strong>.<br />
Please log in with your credentials to access.</p>
<hr />

<div id="infoMessage"><?php echo $message;?></div>

<?php 
	$attributes = array('class' => 'form-inline', 'role' => 'form');	
	echo form_open("auth/login", $attributes);
?>

  <div class="form-group">
  	<?php $attrib_input = array('class' => 'form-control'); ?>
    <?php echo lang('login_identity_label', 'identity');?>
    <?php echo form_input($identity, '', $attrib_input);?>
  </div>

  <div class="form-group">
    <?php echo lang('login_password_label', 'password');?>
    <?php echo form_input($password, '', $attrib_input);?>
  </div>

<!--
  <div class="form-group">
    <small>
    <?php echo lang('login_remember_label', 'remember');?>
    <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"');?>
    </small>
  </div>
-->

  <div class="form-group">
  	<?php $attrib_btn = array('class' => 'btn btn-default'); ?>
  	<?php echo form_submit('submit', lang('login_submit_btn'), $attrib_btn);?>
  </div>

<?php echo form_close();?>
<br />
<p><a href="forgot_password"><?php echo lang('login_forgot_password');?></a></p>

<?php include_once('templates/footer.php') ?>
