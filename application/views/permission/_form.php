<?php defined('BASEPATH') OR exit('No direct script access allowed');
$form = $model->form(); // array of fields
$errors = $this->session->flashdata('errors'); // errors value
?>
<?php echo form_open('permission/save', 'class="form-horizontal"', array('id_permission'=>$model->id_permission));?>

	<div class="control-group">
		<?php echo form_label('Modul', 'modul_id', array('class'=>'control-label'));?>
		<div class="controls">
			<?php echo form_dropdown($form['modul_id']['name'], $form['modul_id']['options'], $form['modul_id']['value'], $form['modul_id']['extra']);?>
			<span class="help-inline" id="error-modul_id"></span>
		</div>
	</div>

	<div class="control-group">
		<?php echo form_label('Name', 'name', array('class'=>'control-label'));?>
		<div class="controls">
			<?php echo form_input($form['name']);?>
			<span class="help-inline" id="error-name"></span>
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