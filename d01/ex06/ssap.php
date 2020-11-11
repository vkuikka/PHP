#!/usr/bin/php
<?PHP
if ($argc < 2)
	return (0);
for ($i = 0; $i < $argc; $i++) {
	$arg = explode(" ", $argv[$i]);
	$arg = array_filter($arg);
	$index = 0;
	foreach ($arg as $str)
		echo "$str\n";
}

?>
