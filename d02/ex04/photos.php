#!/usr/bin/php
<?PHP
$url = $argv[1];
$html = file_get_contents($argv[1]);
if (!$html)
{
	echo "not valid url\n";
	return;
}

preg_match_all("/<img(?:[^>]*)src=\"([^\"]*)/", $html, $matches);
var_dump($matches);

if (!$matches[1])
{
	echo "no images found\n";
	return;
}

$pattern = "/http:\/\//";
$dirname = preg_replace($pattern, "", $url);
if (!is_dir($dirname))
	mkdir($dirname);

$i = 0;
foreach ($matches[1] as $link)
{
	$img;
	if ($link[0] == '/')
		$img = file_get_contents($url.$link);
	else
		$img = file_get_contents($link);
	if ($img)
		file_put_contents("./$dirname/$i.jpg", $img);
	$i++;
}
// print_r($matches);
?>

