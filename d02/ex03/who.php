#!/usr/bin/php
<?PHP
function str_parser($str1, $str2):int
{
	$compare1 = 0;
	$compare2 = 0;
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
function sort_data($arr1, $arr2):int
{
	return(str_parser($arr1[device], $arr2[device]));
}

$path = "/var/run/utmpx";
$file = fopen($path, "r");
$i = 0;
while ($utmpx = fread($file, 628))
{
	$unpack = unpack("a256user/a4initID/a32device/ipid/sut_type/sut_ver/i1entry_time", $utmpx);
	$array[$i] = $unpack;
	$i++;
}
usort($array, 'sort_data');
date_default_timezone_set ("europe/Helsinki");
foreach ($array as $data)
	if ($data[ut_type] == 7)
	{
		$date = date('M j H:i', $data['entry_time']);
		echo $data[user]."  ".$data[device]."  ".$date."\n";
	}
?>
