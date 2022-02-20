<?php defined('BASEPATH') OR exit('No direct script access allowed');
$form = $model->form(); // array of fields
$errors = $this->session->flashdata('errors'); // errors value
$password = 'Password';
if(!empty($model->id_user)){
	$form['username']['readonly'] = 'readonly';
	$password = 'New '.$password;
}
?>
<?php echo form_open('user/save', 'class="form-horizontal"', array('id_user'=>$model->id_user));?>

	<div class="control-group">
		<?php echo form_label('Username', 'username', array('class'=>'control-label'));?>
		<div class="controls">
			<?php echo form_input($form['username']);?>
			<span class="help-inline" id="error-username"></span>
		</div>
	</div>

	<div class="control-group">
		<?php echo form_label($password, 'password', array('class'=>'control-label'));?>
		<div class="controls">
			<?php echo form_input($form['password']);?>
			<span class="help-inline" id="error-password"></span>
		</div>
	</div>

	<div class="control-group">
		<?php echo form_label('Confirm '.$password, 'confirm_password', array('class'=>'control-label'));?>
		<div class="controls">
			<?php echo form_input($form['confirm_password']);?>
			<span class="help-inline" id="error-confirm_password"></span>
		</div>
	</div>

	<div class="control-group">
		<?php echo form_label('Status', 'status', array('class'=>'control-label'));?>
		<div class="controls">
			<?php echo form_dropdown($form['status']['name'], $form['status']['options'], $form['status']['value'], $form['status']['extra']);?>
			<span class="help-inline" id="error-status"></span>
		</div>
	</div>

	<div class="form-actions">
		<button class="btn btn-primary" type="submit">
			<i class="fa fa-save"></i>
			Save
		</button>
	</div>

<?php echo form_close();?>

<script type="text/javascript">
// global vars
var errors = <?php echo json_encode($errors);?>;
$(function(){
	if(errors !== null) printerrors(errors);
	$('[data-rel="chosen"],[rel="chosen"]').chosen();
})

</script>