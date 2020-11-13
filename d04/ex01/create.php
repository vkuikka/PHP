<?php
	session_start();
	if ($_POST[submit] != "OK" || !$_POST[passwd])
	{
		echo "ERROR\n";
		return;
	}
	$filename = "private/passwd";
	if (file_exists("private/passwd"))
		$data = unserialize(file_get_contents($filename));
	else
		mkdir("private");
	$data[$_POST[login]][login] = $_POST[login];
	$data[$_POST[login]][passwd] = hash(whirlpool, $_POST[passwd]);
	file_put_contents($filename, serialize($data));
	echo "OK\n";
?>
