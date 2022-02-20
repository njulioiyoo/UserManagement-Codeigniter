<?php defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('_loadasset')){
	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	function _loadasset($file, $type = 'js')
	{
		switch ($type) {
			case 'css':
				$asset = "\t".'<link'.$file.' />';
				break;
			
			default:
				$asset = "\t".'<script'.$file.'></script>';
				break;
		}

		return $asset;
	}
}
