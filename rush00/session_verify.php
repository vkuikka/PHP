<?php
function verify_session($login, $passwd):bool
{
	if (!$login || $login == "" || !$passwd || $passwd == "")
		return FALSE;
	session_start();
	$user_storage = "data/users";
	$users = unserialize(file_get_contents($user_storage));
	if ($users[$login][passwd] != $passwd)
		return FALSE;
	return TRUE;
}
?>
