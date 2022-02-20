<?php defined('BASEPATH') OR exit('No direct script access allowed');?>

<div class="box span12">
	<div class="box-header">
		<h2>
			<i class="icon-list"></i>
			<span class="break"></span>
			List Permission
		</h2>
	</div>
	<div class="box-content">
		<ul class="nav tab-menu nav-tabs">
			<?php $this->load->view('templates/bootstrap/_tabs');?>
		</ul>
		 
		<?php $this->load->view('permission/_table');?>
	</div>
</div>