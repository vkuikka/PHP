#!/usr/bin/php
<?PHP
function	ft_is_sort($array)
{
	$cpy = $array;
	sort($cpy);
	if (implode($array) == implode($cpy))
		return (TRUE);
	return (FALSE);
}
?>
