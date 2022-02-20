<?php defined('BASEPATH') OR exit('No direct script access allowed');
$form = $model->form(); // array of fields
$errors = $this->session->flashdata('errors'); // errors value
?>
<?php echo form_open('modul/save', 'class="form-horizontal"', array('id_modul'=>$model->id_modul));?>

	<div class="control-group">
		<?php echo form_label('Parent', 'parent_id', array('class'=>'control-label'));?>
		<div class="controls">
			<?php echo form_dropdown($form['parent_id']['name'], $form['parent_id']['options'], $form['parent_id']['value'], $form['parent_id']['extra']);?>
			<span class="help-inline" id="error-parent_id"></span>
		</div>
	</div>

	<div class="control-group">
		<?php echo form_label('Url', 'url', array('class'=>'control-label'));?>
		<div class="controls">
			<?php echo form_dropdown($form['url']['name'], $form['url']['options'], $form['url']['value'], $form['url']['extra']);?>
			<span class="help-inline" id="error-url"></span>
		</div>
	</div>

	<div class="control-group">
		<?php echo form_label('Name', 'name', array('class'=>'control-label'));?>
		<div class="controls">
			<?php echo form_input($form['name']);?>
			<span class="help-inline" id="error-name"></span>
		</div>
	</div>

	<div class="control-group">
		<?php echo form_label('Icon', 'icon', array('class'=>'control-label'));?>
		<div class="controls">
			<?php echo form_input($form['icon']);?>
			<span class="help-inline" id="error-icon"></span>
		</div>
	</div>

	<div class="form-actions">
		<button class="btn btn-primary" type="submit">
			<i class="fa fa-save"></i>
			Save
		</button>
	</div>

<?php echo form_close();?>

<div class="modal hide fade" id="icon-modals" style="width: 75%; margin-left: -35%;">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">×</button>
		<h3>Settings</h3>
	</div>
	<div class="modal-body">
		<?php $this->load->view('templates/bootstrap/_icons', array('selector'=>'input[name="icon"]'));?>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal">Close</a>
	</div>
</div>

<script type="text/javascript">
// global vars
var errors = <?php echo json_encode($errors);?>;
$(function(){
	if(errors !== null) printerrors(errors);
	$('[data-rel="chosen"],[rel="chosen"]').chosen();
})

function showicons() {
	$('#icon-modals').modal('show');
}
</script>