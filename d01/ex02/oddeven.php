#!/usr/bin/php
<?PHP
while (true)
{
	echo "Enter a number: ";
	$fd = fopen ("php://stdin", "r");
	$line = fgets($fd);

	if ($line == NULL)
	{
		echo "\n";
		return (0);
	}
	$line = trim($line);
	if (!is_numeric($line))
		echo "'".$line."'"." is not a number\n";
	else if ($line % 2 == 0)
		echo "The number ".$line." is even\n";
	else if ($line % 2)
		echo "The number ".$line." is odd\n";
}
?>