<?PHP
header('WWW-Authenticate: Basic realm="Member area"');
header('HTTP/1.0 401 Unauthorized');
header("X-Frame-Options: none");
if ($_SERVER[PHP_AUTH_USER] == "zaz" &&
	$_SERVER[PHP_AUTH_PW] == "Ilovemylittlepony")
{
	$image = file_get_contents("../img/42.png");
	$image = base64_encode($image);
	echo "<img src='data:image/png;base64,$image'></img>";
}
else
	echo "<html><body>That area is accessible for members only</body></html>     ";
?>

