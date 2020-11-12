#!/usr/bin/php
<?PHP
function	ft_is_sort($array):bool
{
	$cpy = $array;
	sort($cpy);
	if (implode($array) == implode($cpy))
		return (TRUE);
	return (FALSE);
}
?>
