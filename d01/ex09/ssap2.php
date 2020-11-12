#!/usr/bin/php
<?PHP
function str_parser($str1, $str2):int
{
	$compare1 = 0;
	$compare2 = 0;
	$str1 = strtolower($str1);
	$str2 = strtolower($str2);
	if (!ctype_alnum($str1[$i]))
		$compare1 = -1;
	if (!ctype_alnum($str2[$i]))
		$compare2 = -1;
	if (ctype_alpha($str1[$i]))
		$compare1 = 1;
	if (ctype_alpha($str2[$i]))
		$compare2 = 1;

	if ($compare1 < $compare2)
		return -1;
	if ($compare1 > $compare2)
		return 1;
	$i;
	while ($i < strlen($str1) && $i < strlen($str2))
	{
		if ($str1[$i] < $str2[$i])
			return -1;
		if ($str1[$i] > $str2[$i])
			return 1;
		$i++;
	}
	if ($i < strlen($str1))
		return (1);
	if ($i < strlen($str2))
		return (-1);
	return(0);
}

if ($argc < 2)
	return (0);
$nums = [];
$chars = [];
$else = [];

for ($i = 1; $i < $argc; $i++)
{
	$array = explode(" ", $argv[$i]);
	$array = array_filter($array);
	for ($j = 0; $j < count($array); $j++)
	{
		if (is_numeric($array[$j][0]))
			array_push($nums, $array[$j]);
		else if (($array[$j][0] >= 'A' && $array[$j][0] <= 'Z') ||
				($array[$j][0] >= 'a' && $array[$j][0] <= 'z'))
			array_push($chars, $array[$j]);
		else
			array_push($else, $array[$j]);
	}
}
usort($chars, 'str_parser');
usort($nums, 'str_parser');
usort($else, 'str_parser');
$res = array_merge($chars, $nums, $else);
foreach ($res as $str) {
	echo "$str\n";
}
?>
