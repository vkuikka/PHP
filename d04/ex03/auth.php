<?PHP
	function auth($login, $passwd)
	{
		if (!$passwd || !file_exists("private/passwd"))
			return false;
		$filename = "private/passwd";
		$data = unserialize(file_get_contents($filename));
		if (!$data[$login])
			return false;
		if ($data[$login][passwd] == hash(whirlpool, $passwd))
			return true;
		return false;
	}
?>
