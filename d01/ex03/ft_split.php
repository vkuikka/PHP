#!/usr/bin/php
<?PHP
function	ft_split($str)
{
	$ar = explode(" ", $str);
	$ar = array_filter($ar);
	sort($ar);
	return ($ar);
}
?>