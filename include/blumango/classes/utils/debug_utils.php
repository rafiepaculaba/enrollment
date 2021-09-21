<?php
/**
 * filename: debug_utils.php
 * 
 * descriptioin: This is for debugging purposes.
 * date created: 12/20/2007
 * created by: BluMango Dev Team
 */

/**
 * p() is a function that will display an array with <pre> html tag
 *
 * @param unknown_type $arr
 */
function p($arr)
{
	echo '<pre>';
	print_r($arr);
	echo '</pre>';
}




?>