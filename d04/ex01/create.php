<?php
	session_start();
	if ($_POST[submit] != "OK" || !$_POST[passwd])
	{
		echo "ERROR\n";
		return;
	}
	mkdir("private");
	$filename = "private/passwd";
	$file = fopen($filename);
	$data[0][login] = $_POST[login];
	$data[0][passwd] = hash(whirlpool, $_POST[passwd]);
	file_put_contents($filename, serialize($data));
	$data = file_get_contents($filename);
	echo "OK\n";
?>
