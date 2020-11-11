#!/usr/bin/php
<?PHP
$arr = explode(" ", $argv[1]);
$arr = array_filter($arr);
$arr = explode("\t", $argv[1]);
$arr = array_filter($arr);
foreach ($arr as $key => $value)
	$arr[$key] = trim($arr[$key]);
$i = 0;
foreach ($arr as $str)
{
	$i++;
	echo $str;
	if ($i != count($arr))
		echo " ";
}
echo "\n";
?>
