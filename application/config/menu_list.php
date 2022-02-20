<?php defined('BASEPATH') OR exit('No direct script access allowed');

// dashboard
$_menu_dashboard = ['_id'=>'#menu-dashboard', 'url'=>'/', 'name'=>'Dashboard', 'is_new'=>TRUE, 'icon'=>'fa fa-dashboard', 'can_view'=>[1]];

// master menu
$_menu_user = ['_id'=>'#menu-user', 'url'=>'/user', 'name'=>'User', 'is_new'=>FALSE, 'icon'=>'fa fa-user', 'can_view'=>[1,2]];
$_menu_group_user = ['_id'=>'#menu-group-user', 'url'=>'/groupuser', 'name'=>'Group User', 'is_new'=>TRUE, 'icon'=>'fa fa-group', 'can_view'=>[1,2]];
$_menu_master = ['_id'=>'#menu-master', 'url'=>'#', 'name'=>'Master', 'is_new'=>FALSE, 'icon'=>'fa fa-cubes', 'can_view'=>[1,2,3], 'child'=>[$_menu_group_user, $_menu_user]];

$config['menu_list'] = [$_menu_dashboard, $_menu_master]; // only parent