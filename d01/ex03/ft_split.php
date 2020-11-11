#!/usr/bin/php
<?PHP
function	ft_split($str)
{
	$str = preg_replace("/\s+/", " ", $str);
	$ar = explode(" ", $str);
	$ar = array_filter($ar);
	sort($ar);
	return ($ar);
}
?>
