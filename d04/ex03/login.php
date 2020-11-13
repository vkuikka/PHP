<?PHP
	include "auth.php";

	if (!$_GET[passwd] || !$_GET[login])
	{
		echo "ERROR\n";
		return;
	}
	if (!file_exists("private/passwd"))
	{
		echo "ERROR\n";
		return;
	}
	if (!auth($_GET[login], $_GET[passwd]))
	{
		echo "ERROR\n";
		return;
	}
	session_start();
	$_SESSION["loggued_on_user"] = $_GET[login];
	echo "OK\n";
?>
