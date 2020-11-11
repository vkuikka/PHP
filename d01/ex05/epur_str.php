#!/usr/bin/php
<?PHP
if ($argc < 2)
	return (0);
$argv = explode(" ", $argv[1]);
$argv = array_filter($argv);
$index = 0;
foreach ($argv as $str)
{
	$index++;
	echo $str;
	if ($index != count($argv))
		echo " ";
}
echo "\n";
?>