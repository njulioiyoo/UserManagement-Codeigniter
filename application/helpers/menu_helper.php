<?php defined('BASEPATH') OR exit('No direct script access allowed');
if(!function_exists('__menulist')){
	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	function __menulist()
	{
		$ci =& get_instance();
		$ci->load->model('MenuListModel');

		$model = new MenuListModel;
		$model->settable('tbl_menu_list c');
		$model = $model->with(
							array('tbl_menu_list p', 'p.id_menu = c.parent_id', 'left')
						)
					   ->find('p.id_menu parent_id,p.name parent, c.id_menu, c.name child, c.url')
					   ->result();

		$menulist = array();
		if(sizeof($model)>0){
			foreach ($model as $key => $value) {
				if(!empty($value->parent_id)) $menulist[$value->parent][] = $value;
			}
		}

		return $menulist;
	}
}


if(!function_exists('_genmenu')){
	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	function _genmenu()
	{
		$ci =& get_instance();
		$ci->load->model('MenuListModel');

		$model = new MenuListModel;
		$model->settable('tbl_menu_list c');
		$model = $model->with(
							array('tbl_menu_list p', 'p.id_menu = c.parent_id', 'left')
						)
					   ->find('p.name parent, c.id_menu, c.name child, c.url')
					   ->result();

		$menu_list = $ci->config->item('menu_list');

		echo __loadmenu($menu_list, 1);
	}
}

if(!function_exists('__loadmenu')){
	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	function __loadmenu($menu_list, $userid)
	{
		$__menu = '';

		if(sizeof($menu_list)>0){
			foreach ($menu_list as $menu) {

			    if(isset($menu['child']) && is_array($menu['child'])){
		    		if(in_array($userid, $menu['can_view'])){ // static rules
				    	$__menu .= '<li class="nav-item nav-dropdown">
	                			<a class="nav-link nav-dropdown-toggle" href="javascript:void(0);">
	                				<i class="'.$menu['icon'].'"></i> 
	                				'.$menu['name'].'
	                			</a>
	                			<ul class="nav-dropdown-items">';
				    	$__menu .= __loadmenu($menu['child'], $userid);
				    	$__menu .= '</ul></li>';
				    }
			    }else{	    	
		    		if(in_array($userid, $menu['can_view'])){ // static rules
						$__menu .= '<li class="nav-item">
					                <a class="nav-link" href="'.$menu['url'].'">
					                	<i class="'.$menu['icon'].'"></i> 
					                	'.$menu['name'].' 
					                	'.__isnew_menu($menu['is_new']).'
					                </a>
					            </li>';
		    		}
			    }

			}
		}

		return $__menu;
	}
}

if(!function_exists('__isnew_menu')){
	/**
	 * undocumented function
	 * @param $menu Boolean
	 * @return void
	 * @author 
	 **/
	function __isnew_menu($menu)
	{

		switch ($menu) {
			case true:
				$_ = '<span class="badge badge-info">NEW</span>';
				break;
			
			default:
				$_ = '';
				break;
		}

		return $_;
	}
}