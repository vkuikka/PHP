#!/usr/bin/php
<?PHP
if ($argc < 2)
{
	echo "Incorrect Parameters\n";
	return (0);
}
$arr = array_values(array_filter(explode(" ", $argv[1])));
$op = 0;
$valid = 1;
if (count($arr) > 3)
	return (0);
if (count($arr) == 3)
	$op = $arr[1];
if (count($arr) == 2)
{
	if (!is_numeric(substr($arr[0], -1)))
	{
		$op = substr($arr[0], -1);
		$arr[0] = substr($arr[0], 0, -1);
	}
	else if (!is_numeric($arr[1][0]))
	{
		$op = $arr[1][0];
		$arr[1] = substr($arr[1], 1);
	}
	else
		$valid = 0;
}
if (count($arr) == 1)
{
	$i = $arr[0][0] == '-' ? 1 : 0;
	while (is_numeric($arr[0][$i]) || $arr[0][$i] == '.')
		$i++;
	if ($arr[0][$i + 1] == '-' && $arr[0][$i] == '-')
		$arr[0] = substr_replace($arr[0], "+", $i, 2);
	if ($arr[0][$i + 1] == '-' && $arr[0][$i] == '+')
		$arr[0] = substr_replace($arr[0], "-", $i, 2);
	if ($arr[0][$i + 1] == '+' && $arr[0][$i] == '+')
		$arr[0] = substr_replace($arr[0], "+", $i, 2);
	if ($arr[0][$i + 1] == '+' && $arr[0][$i] == '-')
		$arr[0] = substr_replace($arr[0], "-", $i, 2);
	$op = $arr[0][$i];
	if ($op)
		$arr = explode($op, $arr[0]);
}
if ($op != '*' && $op != '/' && $op != '%' && $op != '+' && $op != '-')
	$valid = 0;
foreach ($arr as $str)
{
	$i = $str[0] == '-' || $str[0] == '+' ? 1 : 0;
	$dec = 0;
	while ($i < strlen($str))
	{
		if ($str[$i] == '.')
		{
			if ($dec)
				$valid = 0;
			$dec = 1;
		}
		else if (!is_numeric($str[$i]))
			$valid = 0;
		$i++;
	}
}
if (count($arr) != 3)
	$arr[2] = $arr[1];
if (!$valid)
	$op = 0;
if (!$op)
	echo "Syntax Error\n";
else if ($op == '*')
	echo (floatval($arr[0]) * floatval($arr[2]))."\n";
else if ($op == '/')
	echo (floatval($arr[0]) / floatval($arr[2]))."\n";
else if ($op == '%')
	echo (floatval($arr[0]) % floatval($arr[2]))."\n";
else if ($op == '+')
	echo (floatval($arr[0]) + floatval($arr[2]))."\n";
else if ($op == '-')
	echo (floatval($arr[0]) - floatval($arr[2]))."\n";
return (0);
?>
