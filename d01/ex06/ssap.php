#!/usr/bin/php
<?PHP
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
sort($chars);
sort($nums);
sort($else);
$res = array_merge($chars, $nums, $else);
foreach ($res as $str) {
	echo "$str\n";
}
?>
