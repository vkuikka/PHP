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
foreach($matches[1] as $i => $match)
	$matches[1][$i] = preg_replace("/amp;/", "", $match);
if (!$matches[1])
{
	echo "no images found\n";
	return;
}

$pattern = "/http:\/\//";
$dirname = preg_replace($pattern, "", $url);
$pattern = "/https:\/\//";
$dirname = preg_replace($pattern, "", $dirname);
$dirname = "asd";
if (!is_dir($dirname))
{
	echo "making dir ".$dirname;
	mkdir($dirname);
}
$i = 0;
preg_match_all("/<img(?:[^>]*)src[^\/]*[\/]*([^\"?]*)/", $html, $names);
foreach ($names[1] as $i => $name)
	$names[1][$i] = preg_replace("/(.*\/)/", "", $name);
foreach ($matches[1] as $i => $link)
{
	$img;
	if ($link[0] == '/')
		$img = file_get_contents($url.$link);
	else
		$img = file_get_contents($link);
	if ($img)
		file_put_contents("./$dirname/".$names[1][$i], $img);
	if (!$names[1][$i])
		echo "error more images than image names found.\n";
	$i++;
}
?>
