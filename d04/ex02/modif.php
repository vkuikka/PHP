<?php
	session_start();
	if ($_POST[submit] != "OK" || !$_POST[newpw] || !$_POST[login])
	{
		echo "ERROR\n";
		return;
	}
	$filename = "private/passwd";
	if (file_exists("private/passwd"))
		$data = unserialize(file_get_contents($filename));
	else
	{
		echo "ERROR\n";
		return;
	}
	if ($data[$_POST[login]][passwd] == hash(whirlpool, $_POST[oldpw]))
		$data[$_POST[login]][passwd] = hash(whirlpool, $_POST[newpw]);
	else
	{
		echo "ERROR\n";
		return;
	}
	file_put_contents($filename, serialize($data));
	echo "OK\n";
?>
