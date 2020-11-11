<?PHP
if ($_GET["action"] == "set")
	setcookie($_GET["name"], $_GET["value"], time()+3600);
if ($_GET["action"] == "del")
	setcookie($_GET["name"], "", time() - 1);
if ($_GET["action"] == "get")
{
	$val = $_COOKIE[$_GET["name"]];
	if ($val)
		echo $val."\n";
}
?>
