#!/usr/bin/php
<?PHP
if ($argc < 2)
	return (0);
$array = explode(" ", $argv[1]);
$array = array_filter($array);
$array[count($array)] = $array[0];
unset($array[0]);
$array = array_values($array);
foreach ($array as $key => $word)
{
	echo $word;
	if ($key != count($array) - 1)
		echo " ";
}
echo "\n";
?>
