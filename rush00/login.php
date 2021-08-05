<?PHP
	session_start();
	$user_storage = "data/users";
	function auth($login, $passwd):bool
	{
		$user_storage = "data/users";
		if (!$passwd || !file_exists($user_storage))
			return false;
		$users = unserialize(file_get_contents($user_storage));
		if (!$users[$login][login])
			return false;
		if ($users[$login][passwd] != hash(whirlpool, $passwd))
			return false;
		return true;
	}
	$MESSAGE = " ";
	if (!$_POST[login_field] || !$_POST[password_field])
		$MESSAGE = "Enter username and password.";
	else if ($_POST[submit_type] == "register")
	{
		if (!is_dir("data"))
			mkdir("data");
		if (file_exists($user_storage))
			$users = unserialize(file_get_contents($user_storage));
		$login_hash = hash(whirlpool, $_POST[login_field]);
		if ($users[$login_hash][login] == $login_hash)
			$MESSAGE = "Username taken.";
		else
		{
			$users[$login_hash][login] = $login_hash;
			$users[$login_hash][passwd] = hash(whirlpool, $_POST[password_field]);
			file_put_contents($user_storage, serialize($users));
			$_SESSION[login] = $login_hash;
			$_SESSION[passwd] = hash(whirlpool, $_POST[password_field]);

			header("Location: index.php");
		}
	}
	else if ($_POST[submit_type] == "login")
	{
		$login_hash = hash(whirlpool, $_POST[login_field]);
		if (auth($login_hash, $_POST[password_field]))
		{
			$MESSAGE = "Logged in.";
			$_SESSION[login] = hash(whirlpool, $_POST[login_field]);;
			$_SESSION[passwd] = hash(whirlpool, $_POST[password_field]);
			if ($_POST[login_field] == "admin")
				header("Location: admin.php");
			else
				header("Location: index.php");
		}
		else
		{
			$MESSAGE = "Incorrect password or username.";
			$_SESSION[login] = "";
			$_SESSION[passwd] = "";
		}
	}
	else if ($_POST[submit_type] == "delete user")
	{
		$login_hash = hash(whirlpool, $_POST[login_field]);
		if (auth($login_hash, $_POST[password_field]))
		{
			$MESSAGE = "User deleted.";
			$users = unserialize(file_get_contents($user_storage));
			unset($users[$login_hash]);
			file_put_contents($user_storage, serialize($users));
			$_SESSION[login] = "";
			$_SESSION[passwd] = "";
		}
		else
			$MESSAGE = "Incorrect password or username.";
	}
?>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="style.css">
		<title>login</title>
	</head>
	<body>
		<div id="login-top">
			<div style="padding-top:15px;">
				<a href="index.php" style="text-decoration:none;color:black;"><img id="logo" src="images/logo.png" title="logo" alt="logo"></a>
			</div>
		</div>
		<br/>
		<div style="left:50%; text-align:center;">
			<form method="POST">
				Username:&emsp;<input name="login_field" value=""/>
				<br/>
				Password: &emsp;<input type="password" name="password_field" value=""/>
				<br/><br/>
				<input type="submit" name="submit_type" value="login"/>
				<input type="submit" name="submit_type" value="register"/>
				<br/><br/>
				<input type="submit" name="submit_type" value="delete user"/>
			</form>
			<br/>
			<?php echo $MESSAGE?>
		</div>
	</body>
</html>
