#!/usr/bin/php
<?PHP
if ($argc < 4)
{
	echo "Incorrect Parameters\n";
	return (0);
}
$argv[1] = trim($argv[1]);
$argv[2] = trim($argv[2]);
$argv[3] = trim($argv[3]);
if ($argv[2] == "+")
	echo ((int)$argv[1] + (int)$argv[3]);
if ($argv[2] == "-")
	echo ((int)$argv[1] - (int)$argv[3]);
if ($argv[2] == "*")
	echo ((int)$argv[1] * (int)$argv[3]);
if ($argv[2] == "/")
	echo ((int)$argv[1] / (int)$argv[3]);
if ($argv[2] == "%")
	echo ((int)$argv[1] % (int)$argv[3]);
echo "\n";
?>
