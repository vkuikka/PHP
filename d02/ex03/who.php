#!/usr/bin/php
<?PHP
$path = "/var/run/utmpx";
$file = fopen($path, "r");
$i = 0;
while ($utmpx = fread($file, 628)){
	$unpack = unpack("a256user/a4initID/a32device/ipid/sut_type/sut_ver/i1entry_time", $utmpx);
	$array[$i] = $unpack;
	$i++;
}
foreach ($array as $data)
	if ($data[ut_type] == 7)
	{
		$date = date('M j g:i', $data['entry_time']);
		echo $data[user]."  ".$data[device]."  ".$date."\n";
	}
?>
