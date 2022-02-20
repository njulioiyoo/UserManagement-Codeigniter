<?php defined('BASEPATH') OR exit('No direct script access allowed');?>

<?php $this->load->view('templates/bootstrap/_navbar');?>

<div class="container-fluid">
	<div class="row-fluid">

		<!-- start: Main Menu -->
		<div class="span2 main-menu-span">
			<div class="nav-collapse sidebar-nav">
				<ul class="nav nav-tabs nav-stacked main-menu">
					<li class="nav-header hidden-tablet">Main Navigation</li>

					<?php $this->load->model('Modulmodel');?>
					<?php $moduls = (new Modulmodel)->find()->result();?>
					<?php if(sizeof($moduls)>0):?>
						<?php foreach($moduls as $model):?>
							<?php $url = explode('/', $model->url);?>
							<?php if($this->auth->menu($model->url)):?>
							<li <?php echo strtolower($url[0]) == strtolower($this->uri->segment(1)) ? 'class="active"':'';?>>
								<a href="<?php echo ($model->url == '#') ? '#':base_url(strtolower($model->url));?>">
								<?php echo (empty($model->icon)) ? "":'<i class="'.$model->icon.'"></i>';?>

									<?php if($this->auth->can('viewPermissionCount')):?>
									<span class="badge badge-info" title="Permission Count" style="float: right;"><?php echo $this->auth->countpermission($model->url);?></span>
									<?php endif;?>

									<span class="hidden-tablet"> 
									<?php echo $model->name;?>
									</span>
								</a>
							</li>
							<?php endif;?>
						<?php endforeach;?>
					<?php endif;?>
					
				</ul>
			</div><!--/.well -->
		</div><!--/span-->
		<!-- end: Main Menu -->
		
		<noscript>
			<div class="alert alert-block span10">
				<h4 class="alert-heading">Warning!</h4>
				<p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>
			</div>
		</noscript>

		<div id="content" class="span10">


			<?php $this->load->view('templates/bootstrap/_breadcrumbs');?>

			<?php $errors = $this->session->flashdata('flash-delete');?>

			<?php if(is_array($errors) && sizeof($errors)>0): ?>
				<?php foreach($errors as $key=>$message):?>
					<div class="alert alert-<?php echo $key;?>">
						<button type="button" class="close" data-dismiss="alert">×</button>
						<strong><?php echo strtoupper($key);?> !</strong> <?php echo $message;?>.
					</div>
				<?php endforeach;?>
			<?php endif;?>

			<div class="row-fluid">
			<?php echo isset($body) ? $body : "";?>
			</div>
		</div>
	</div>
