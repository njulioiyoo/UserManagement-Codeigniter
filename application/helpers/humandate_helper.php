<?php defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('to_human')) {
	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	function to_human($time, $newtime = null, $returnarray = false)
	{
	    $tokens = array (
	            31536000 => 'year',
	            2592000 => 'month',
	            604800 => 'week',
	            86400 => 'day',
	            3600 => 'hour',
	            60 => 'minute',
	            1 => 'second'
	    );

	    $htarray = array();
	    
	    foreach ($tokens as $unit => $text) {
	            if ($time < $unit) continue;
	            $numberOfUnits = floor($time / $unit);
	            $htarray[$text] = $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
	            $time = $time - ( $unit * $numberOfUnits );
	    }
	    
	    if($returnarray) return $htarray;

	    return implode(' ', $htarray);
	    
	}
}