<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- LOGO HEADER END-->
<section class="menu-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="navbar-collapse collapse ">

                    <ul id="menu-top" class="nav navbar-nav navbar-right">
                    
                        <li><a class="" href="<?php echo site_url();?>">Dashboard</a></li>
                        
                        <li class="dropdown">
                            <a href="#" aria-expanded="false" aria-haspopup="true" role="button" data-toggle="dropdown" class="dropdown-toggle">
                                SETUP
                                <i class="fa fa-gears"></i>
                            </a>

                            <ul class="dropdown-menu">
                                <li class="dropdown-header">Site Config</li>
                                <li>
                                    <a href="<?php echo base_url('groupuser');?>">
                                        <i class="fa fa-group"></i> Group User
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url('user');?>">
                                        <i class="fa fa-user"></i> User
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url('pic');?>">
                                        <i class="fa fa-user"></i> PIC Group
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url('ticketrules');?>">
                                        <i class="fa fa-ticket"></i> Ticket Rules
                                    </a>
                                </li>
                                <li class="divider" role="separator"></li>
                                <li class="dropdown-header">Personal Config</li>
                                <li>
                                    <a href="<?php echo base_url('notifications');?>">
                                        <i class="fa fa-bell"></i> Notifications
                                    </a>
                                </li>
                            </ul>

                        </li>

                        <!-- FOR DEVELOPMENT USE ONLY -->
                        <li class="dropdown">
                            <a href="#" aria-expanded="false" aria-haspopup="true" role="button" data-toggle="dropdown" class="dropdown-toggle">
                                CHANGE SESSION
                                <i class="fa fa-gears"></i>
                            </a>
                            <ul class="dropdown-menu">
                            <?php if(sizeof(_static_users())>0):?>
                                <?php foreach(_static_users() as $no => $field):?>
                                <li>
                                    <a href="<?php echo base_url('groupuser/ubahsesi/'.$no);?>">
                                        <i class="fa fa-user"></i>
                                        <?php echo $field['name'];?>
                                    </a>
                                </li>
                                <?php endforeach;?>
                            <?php endif;?>
                            </ul>
                        </li>
                        <!-- FOR DEVELOPMENT USE ONLY -->

                        <li>
                            <a href="#" onclick="logout()">
                                <i class="fa fa-lock"></i>
                                LOGOUT
                            </a>
                        </li>
                    </ul>
                    
                </div>
            </div>
        </div>
    </div>
</section>
<!-- MENU SECTION END-->