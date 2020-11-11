<?PHP
if (!isset($_SESSION["PHP_AUTH_USER"]))
{
	header('WWW-Authenticate: Basic realm="My Realm"');
	header('HTTP/1.0 401 Unauthorized');
}
if ($_SESSION["PHP_AUTH_USER"] == "zaz" &&
	$_SESSIOn["PHP_AUTH_PW"] == "asd")
	echo "correct";
else
{
	unset($_SESSION['PHP_AUTH_USER']);
	unset($_SESSION['PHP_AUTH_PW']);
	echo "incorrect";
}
return;
$pw = "Ilovemylittleponey";
?>

