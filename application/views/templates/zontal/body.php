<?php defined('BASEPATH') OR exit('No direct script access allowed');?>

<?php $this->load->view('templates/zontal/_navbar');?>

<div class="content-wrapper">
    <div class="container">

	<?php $this->load->view('templates/zontal/_breadcrumbs');?>
	
	<?php if($this->session->flashdata('msg')):?>
		<div class="row">
			<div class="col-sm-12">
				<?php echo $this->session->flashdata('msg');?>
			</div>
		</div>
	<?php endif;?>

	<?php echo isset($body) ? $body : "";?>

	</div>
</div>