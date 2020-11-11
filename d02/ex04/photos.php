#!/usr/bin/php
<?PHP
$url = $argv[1];
$html = file_get_contents($argv[1]);
if (!$html)
{
	echo "not valid url\n";
	return;
}
// echo $html;
// return;
preg_match_all("/([^\"]*[^\"]\.png)/", $html, $matches);
// print_r($matches);
$pattern = "/http:\/\//";
$dirname = preg_replace($pattern, "", $url);
$dirname = "asd";
mkdir($dirname);
foreach ($matches[1] as $key => $img)
{
	// if (!preg_match("/$dirname/", $img))
		$img = file_get_contents($url.$img);
	// else
		// $img = file_get_contents($img);
	file_put_contents("./$dirname/$key.png", $img);
}
?>

