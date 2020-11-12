#!/usr/bin/php
<?PHP
function replace_accents($str) {
	$str = htmlentities($str, ENT_NOQUOTES, "UTF-8");
	$str = preg_replace('/&([a-zA-Z])(uml|acute|grave|circ|tilde);/','$1',$str);
	return html_entity_decode($str);
}
$input = replace_accents($argv[1]);
$word = explode(" ", $input);
if (count($word) != 5)
{
	echo "Wrong Format\n";
	return;
}

for ($i = -1; ++$i < strlen($word[0]);)
	if ($i != 0 && ord($word[0][$i]) < ord('a') && $word[0][$i])
	{
		echo "Wrong Format\n";
		return;
	}
for ($i = -1; ++$i < strlen($word[2]);)
	if ($i != 0 && ord($word[2][$i]) < ord('a') && $word[2][$i])
	{
		echo "Wrong Format\n";
		return;
	}

foreach($word as $i => $w)
	$word[$i] = strtolower($w);
$input = strtolower($input);

date_default_timezone_set ("europe/paris");
$months = array('janvier'=>'jan',
	'fevrier'=>'feb',
	'mars'=>'march',
	'avril'=>'apr',
	'mai'=>'may',
	'juin'=>'jun',
	'juillet'=>'jul',
	'aout'=>'aug',
	'septembre'=>'sep',
	'octobre'=>'oct',
	'novembre'=>'nov',
	'decembre'=>'dec');
$days = array('lundi'=>'monday',
	'mardi'=>'tuesday',
	'mercredi'=>'wednesday',
	'jeudi'=>'thursday',
	'vendredi'=>'friday',
	'samedi'=>'saturday',
	'dimanche'=>'sunday');
$input = strtr($input, $months);
$compare = $input;
$input = strtr($input, $days);
if ($input == $compare)
{
	echo "Wrong Format\n";
	return;
}

$no_weekday = explode(" ", $input);

$month = date('m', strtotime($no_weekday[2]));
if (!checkdate($month, $no_weekday[1], $no_weekday[3]))
{
	echo "Wrong format\n";
	return (0);
}
array_shift($no_weekday);
$no_weekday = array_values($no_weekday);
$input = implode(" ", $no_weekday);
$time = strtotime($input);
if ($time === FALSE)
{
	echo "Wrong Format\n";
	return;
}
$valid = 1;
if (strlen($word[4]) != 8 || strlen($word[3]) != 4)
{
	$valid = 0;
}
else
	for ($i = 0; $i < (strlen($word[4])); $i++)
	{
		if ($i == 2 || $i == 5)
		{
			if ($word[4][$i] != ':')
				$valid = 0;
		}
		else if (!is_numeric($word[4][$i]))
			$valid = 0;
	}
if (!$valid)
	echo "Wrong Format";
else
	echo $time;
echo "\n";
?>
