<?php defined('BASEPATH') OR exit('No direct script access allowed');

$errors = $this->session->flashdata('errors'); // errors value
?>
<?php echo form_open('userrole/save', 'class="form-horizontal"', array('id_user'=>$model[0]->id_user));?>

	<div class="control-group">
		<?php echo form_label('Username', 'username', array('class'=>'control-label'));?>
		<div class="controls">
			<?php echo form_input('', $model[0]->username, array('readonly'=>'readonly'));?>
			<span class="help-inline" id="error-username"></span>
		</div>
	</div>

	<div class="control-group">
		<?php echo form_label('Role Name', 'rolename', array('class'=>'control-label'));?>
		<div class="controls">
			<div class="row-fluid">
			    <div class="box span4">
			    	<?php echo form_dropdown('', $roles, '', array('class'=>'form-control', 'size'=>8, 'multiple'=>'multiple', 'id'=>'multiselect'));?>
			    </div>
			    
			    <div class="box span3">
			        <button type="button" id="multiselect_rightAll" class="btn btn-block">
			        	<i class="icon-forward"></i>
			        </button>
			        <button type="button" id="multiselect_rightSelected" class="btn btn-block">
			        	<i class="icon-chevron-right"></i>
			        </button>
			        <button type="button" id="multiselect_leftSelected" class="btn btn-block">
			        	<i class="icon-chevron-left"></i>
			        </button>
			        <button type="button" id="multiselect_leftAll" class="btn btn-block">
			        	<i class="icon-backward"></i>
			        </button>
			    </div>
			    
			    <div class="box span4">
			    	<?php echo form_dropdown('rolename[]', $rolenames, '', array('class'=>'form-control', 'size'=>8, 'multiple'=>'multiple', 'id'=>'multiselect_to'));?>
			    </div>
			</div>
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
$(function(){
	$('#multiselect').multiselect();
})

</script>