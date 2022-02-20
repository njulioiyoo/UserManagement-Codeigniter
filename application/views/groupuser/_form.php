<?php defined('BASEPATH') OR exit('No direct script access allowed');?>

<?php echo form_open('groupuser/save', 'class="form-horizontal" id="form-save-groupuser"', array('id_groupuser'=>$model->id_groupuser));?>

	<div class="form-group">
		<?php echo form_label('Name','name', array('class'=>'col-sm-2 control-label'));?>
		<div class="col-sm-10">
			<?php echo form_input('name', $model->name, 'class="form-control"');?>
		</div>
	</div>

	<div class="form-group">
		<?php echo form_label('Status','status', array('class'=>'col-sm-2 control-label'));?>
		<div class="col-sm-10">
			<?php echo form_dropdown('status', $status, $model->status, 'class="form-control" id="status-list"');?>
		</div>
	</div>

	<div class="form-group">
		<?php echo form_label('Description','remarks', array('class'=>'col-sm-2 control-label'));?>
		<div class="col-sm-10">
			<?php echo form_textarea('remarks', $model->remarks, 'class="form-control"');?>
		</div>
	</div>

	<div class="form-group">
		<?php echo form_label('','action', array('class'=>'col-sm-2 control-label'));?>
		<div class="col-sm-10">
			<button class="btn btn-sm btn-default" type="reset">
				<i class="fa fa-refresh"></i>
				Cancel
			</button>
			<button class="btn btn-sm btn-success" type="submit">
				<i class="fa fa-save"></i>
				Save
			</button>
		</div>
	</div>

<?php echo form_close();?>

<script type="text/javascript">
$(function(){
	$('#status-list').select2();
});
</script>