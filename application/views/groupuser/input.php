<?php defined('BASEPATH') OR exit('No direct script access allowed');?>

<div class="row">
    <div class="col-md-12">
        <h4 class="page-head-line">
        <?php echo $title;?>
        </h4>
    </div>
</div>

<div class="row">
	<div class="col-md-12" id="lists-cust">
		<div class="panel panel-default">
			<div class="panel-body">
			<?php $this->load->view('groupuser/_form');?>
			</div>
		</div>
	</div>
</div>