#!/usr/bin/php
<?PHP
if ($argc < 3)
	return ;
for ($i = 0; $i < $argc; $i++)
{
	$arr = explode(":", $argv[$i]);
	if ($arr[0] == $argv[1])
		$value = $arr[1];
}
echo $value."\n";
?>