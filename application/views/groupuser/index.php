<?php defined('BASEPATH') OR exit('No direct script access allowed');?>

<div class="row">
    <div class="col-md-12">
        <h4 class="page-head-line">
        	<i class="fa fa-group"></i>
	        <?php echo $title;?>
        </h4>
    </div>
</div>

<div class="row">
	<div class="col-md-12" id="lists-cust">
		<div class="panel panel-default">
			<div class="panel-heading">
				<a href="<?php echo base_url("groupuser/input");?>" class="btn btn-sm btn-success">
					<i class="fa fa-plus"></i> 
					Add
				</a>
			</div>
			<div class="panel-body groupuserlist">
			<?php $this->load->view('groupuser/_table');?>
			</div>
		</div>
	</div>
</div>