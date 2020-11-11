#!/usr/bin/php
<?PHP
function replace_accents($str) {
	$str = htmlentities($str, ENT_NOQUOTES, "UTF-8");
	$str = preg_replace('/&([a-zA-Z])(uml|acute|grave|circ|tilde);/','$1',$str);
	return html_entity_decode($str);
}
$input = replace_accents($argv[1]);
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
$input = strtr($input, $days);
$test_nums = explode(" ", $input);
$time = strtotime($input);
$valid = 1;
if ((strlen($test_nums[4]) != 8) || (strlen($test_nums[3]) != 4))
	$valid = 0;
else if ($valid)
	for ($i = 0; $i < (strlen($test_nums[4])); $i++)
	{
		if ($i == 2 || $i == 5)
		{
			if ($test_nums[4][$i] != ':')
				$valid = 0;
		}
		else if (!is_numeric($test_nums[4][$i]))
				$valid = 0;
	}
if (!$time || !$valid)
	echo "Wrong Format";
else
	echo $time;
echo "\n";
?>
