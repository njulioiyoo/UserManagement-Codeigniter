<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- start: Header -->
<div class="navbar">
    <div class="navbar-inner">
        <div class="container-fluid">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".top-nav.nav-collapse,.sidebar-nav.nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a class="brand" href="<?php echo base_url('dashboard');?>"> <img alt="Optimus Dashboard" src="<?php echo base_url('assets/optimus/img/logo-kompasgramedia.png');?>" /></a>
                            
            <!-- start: Header Menu -->
            <div class="btn-group pull-right" >
                <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="icon-user"></i><span class="hidden-phone hidden-tablet"><?php echo $this->session->userdata('userlogin_name');?></span>
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo base_url('dashboard/logout');?>">Logout</a></li>
                </ul>
                <!-- end: User Dropdown -->
            </div>
            <!-- end: Header Menu -->
            
        </div>
    </div>
</div>
<div id="under-header"></div>
<!-- start: Header -->