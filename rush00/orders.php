<?php
	require 'session_verify.php';
	session_start();
	if ($_GET[status] == logged_out)
	{
		$_SESSION[login] = "";
		$_SESSION[passwd] = "";
		$_SESSION[basket] = "";
		session_destroy();
	}
	if (!(verify_session($_SESSION[login], $_SESSION[passwd])))
		$_SESSION[login] = "";
	if($_SESSION[login] && $_SESSION[login] != "")
		$LOGTEXT = "logout";
	else
		$LOGTEXT = "login / register";

	if ($LOGTEXT == "logout")
		$LOGLINK = "?status=logged_out";
	else
		$LOGLINK = "login.php";
	$order_html = "<h4>Log in to see your orders.<h4/>";
	if ($_SESSION[login] && !$_SESSION[login] == "")
	{
		$order_html = "";
		$order_storage = "data/orders";
		$orders = unserialize(file_get_contents($order_storage));
		$valid = $_SESSION[login] == hash(whirlpool, "admin");
		foreach ($orders as $key => $order)
			if ($order[login] == $_SESSION[login] || $valid)
				foreach ($order[basket] as $key => $item)
				{
					date_default_timezone_set('Europe/Riga');
					$order_html = $order_html.$item."<br/>".date("l jS \of F Y h:i:s A", $order[time]);
					if ($valid)
						$order_html = $order_html."<br/>"."user hash: ".$order[login];
					$order_html = $order_html."</br></br></br>";
				}
		$basket = $users[$_SESSION[user]][basket];
	}
	if ($_SESSION[login] == hash(whirlpool, "admin"))
	{
		$admin_link = "<a href='admin.php' style='text-decoration:noen; color:black;'>back to admin page</a>";
		$admin_link = $admin_link."<h3>All orders:</h3>";
	}
	else
	{
		$MAINLINK = "href='index.php'";
		$admin_link = $admin_link."<h3>Your orders:</h3>";
	}
?>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="style.css">
		<title>Orders</title>
	</head>
	<body>
		<div class="topbar">
			<table class="topbartable">
				<tr>
					<td class="shopname">
						<a <?php echo $MAINLINK?> style="text-decoration:none;color:black;">
							<img id="logo" src="images/logo.png" title="logo" alt="logo">
						</a>
					</td>
					<td class="logintd">
						<a href=<?php echo $LOGLINK?> id="login">
							<div style="height:50px;padding-top:20px;"><?php echo $LOGTEXT?>
							</div>
						</a>
					</td>
					<td class="basket">
					<div class="dropdown">
						<button class="dd-button">
							<a href="basket.php">
								<img id="basketlogo" src="images/cart.png" title="basket" alt="basket">
							</a>
						</button>
							<div class="dd-content">
								<?php echo $basket_html?>
							</div>
					</div>
					</td>
				</tr>
			</table>
		</div>
		<br/>
		<div class="preview" style="left:50%; text-align:center;">
			<?php echo $admin_link?>
			<br/>
			<?php echo $order_html;?>
		</div>
	</body>
</html>
