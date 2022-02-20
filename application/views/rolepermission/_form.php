<?php defined('BASEPATH') OR exit('No direct script access allowed');
$errors = $this->session->flashdata('errors'); // errors value
?>
<?php echo form_open('rolepermission/save', 'class="form-horizontal"', array('id_role'=>$role_id));?>
	
	<?php if(sizeof($moduls['modulname'])>0):?>
	<div class="control-group">
		<div class="row">
		<?php $i=0;?>
		<?php foreach($moduls['modulname'] as $uri => $name):?>
			<div class="span3">
				<div class="control-group">
					<label class="control-label">
						<?php echo form_checkbox(
										'', 
										'',
										isset($rolepermission[$uri]),
										array('data-parent'=>$uri)
									);?>
						<?php echo $name;?>
					</label>
					<div class="controls">
						<?php foreach($moduls['permissionlist'][$uri] as $value):?>
							<label class="checkbox">
								<div class="checkbox">
									<?php $_rp_id = ""?>
									<?php $input = array();?>
									<?php $input['data-permissionid'] = $value['permission_id'];?>
									<?php $input['disabled'] = 'disabled';?>

									<?php if(isset($rolepermission[$value['permission_id']])):?>
										<?php $_rp_id = $rolepermission[$value['permission_id']];?>
										<?php unset($input['disabled']);?>
									<?php endif;?>

									<?php $input['name'] = 'id_rolepermission[]';?>
									<?php $input['value'] = $_rp_id;?>
									<?php $input['type'] = 'hidden';?>
									<?php echo form_input($input);?>

									<?php echo form_checkbox(
													'permission_id[]', 
													$value['permission_id'],
													isset($rolepermission[$value['permission_id']]),
													array('data-child'=>$uri)
												);?>

									<?php echo $value['permissionname'];?>

								</div>
							</label>
							<div style="clear:both"></div>
						<?php endforeach;?>
					</div>
				</div>
			</div>
		<?php $i++; if ($i%3 == 0) echo '</div><div class="row">';?>
		<?php endforeach;?>
	</div>
	<?php endif;?>

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
})

$('input[type="checkbox"]').on('click', function(){
	var $this = $(this),
		checked = $this.is(':checked'),
		hasChild = typeof $this.data('parent') !== 'undefined',
		hasParent = typeof $this.data('child') !== 'undefined';

	if(hasChild){
		var child = $this.data('parent'),
			checkbox = $('input[data-child="'+child+'"]');

		if(checkbox.is(':checked')){
			$.each(checkbox, function(i, el){
				if($(el).is(':checked')){
					$('input[data-permissionid="'+$(el).val()+'"]').attr('disabled', true);
					$(el).removeAttr('checked'); // remove attributes from database generated
				}
			});
			return;
		}

		checkbox.attr('checked', false);
		checkbox.trigger('click'); // trigger click :D
		if(checked){
			checkbox.attr('checked', true);
		}
		
	}

	if(hasParent){
		var parent = $this.data('child'),
			isChecked = false,
			checkbox = $('input[data-child="'+parent+'"]'),
			input = $('input[data-permissionid="'+$this.val()+'"]');

		$.each(checkbox, function(i, el){
			if($(el).is(':checked')){
				isChecked = true;
			}
		});

		if(!isChecked) {
			$('input[data-parent="'+parent+'"]').attr('checked', false);
		}

		input.attr('disabled', true);
		if(checked) {
			input.attr('disabled', false);
			$('input[data-parent="'+parent+'"]').attr('checked', true);
		}
	}

});
</script>