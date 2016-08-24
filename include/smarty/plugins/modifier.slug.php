<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 * @author Manuel Polacek / Hitflip
 */


/**
 * Smarty regex_replace modifier plugin
 *
 * Type:     modifier<br>
 * Name:     substring
 * Purpose:  substring like in php
 * @param string
 * @return string
 */
function smarty_modifier_slug($title)
{
$slugged = url_slug(
	"$title", 
	array(
		'delimiter' => '-',
		'lowercase' => true
	)
);
$string = str_replace('quot-','',$slugged);
$string = str_replace('-quot','',$string);
$string = str_replace('-amp','',$string);
$string = str_replace('amp-','',$string);
return $string;
}

?>