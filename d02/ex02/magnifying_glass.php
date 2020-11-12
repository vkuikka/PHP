#!/usr/bin/php
<?PHP
if ($argc < 1 || !is_file($argv[1]))
	return;
$file = file($argv[1]);
$str = implode($file);
preg_match_all("/(?i)<a[^>]+>([\s\S]*?)</", $str, $texts);
preg_match_all("/(?i)<a[^>]+>/", $str, $links);
foreach ($texts[1] as $key => $value)
{
	$replacement = $links[0][$key].strtoupper($value);
	$pattern = $links[0][$key].$value;
	$pattern = preg_replace("/\//", "\/", $pattern);
	$pattern = "/".$pattern."/";
	$file = preg_replace($pattern, $replacement, $file);
}
$str = implode($file);
preg_match_all("/(?i)title=\"([\s\S]*?)\"/", $str, $texts);
$file = array(implode($file));
foreach ($texts[1] as $key => $value)
{
	$replacement = "title=\"".strtoupper($value)."\"";
	$pattern = "title=\"".$value."\"";
	$pattern = "/".$pattern."/";
	$file = preg_replace($pattern, $replacement, $file);
}
$str = implode($file);
echo ($str);
?>
