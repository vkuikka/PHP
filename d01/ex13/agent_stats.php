#!/usr/bin/php
<?PHP
$content = file_get_contents("php://stdin");
if ($argc != 2 || !$content)
	return (0);
$content = array_values(array_filter(explode("\n", $content)));
foreach ($content as $i => $line)
	if ($i != 0)
		$data[$i - 1] = explode(";", $line);
$peer_score = 0;
$peer_eval_amount = 0;
foreach($data as $entry)
	if (is_numeric($entry[1]))
	{
		if ($entry[2] != "moulinette")
		{
			$peer_score += $entry[1];
			$peer_eval_amount++;
			$students[$entry[0]]["given_score"] += $entry[1];
			$students[$entry[0]]["given_amount"] += 1;
		}
		else
			$students[$entry[0]]["moulinette_score"] = $entry[1];
	}
ksort($students);
if ($argv[1] == "average")
	echo($peer_score / $peer_eval_amount."\n");
else
	foreach($students as $name => $student)
		if ($student["given_score"])
		{
			if ($argv[1] == "average_user")
				echo $name.":".($student["given_score"] / $student["given_amount"])."\n";
			else if ($argv[1] == "moulinette_variance")
				echo $name.":".($student["given_score"] / $student["given_amount"] - $student["moulinette_score"])."\n";
		}
?>