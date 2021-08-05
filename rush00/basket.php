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
	{
		$ORDERS = "
		<td class='logintd'>
			<a href=orders.php id='login'>
				<div style='animation: name 2s forwards;height:50px;padding-top:20px;'>
					Check orders
				</div>
			</a>
		</td>";
		$LOGTEXT = "logout";
	}
	else
		$LOGTEXT = "login / register";

	if ($LOGTEXT == "logout")
		$LOGLINK = "?status=logged_out";
	else
		$LOGLINK = "login.php";

	if ($_GET[order] == "done")
	{
		if ($_SESSION[login] == '' || !$_SESSION[login])
			$TOPMESSAGE = "<h3 style='margin-left:40%;'>log in to make your order.<h4/></br></br></br>";
		else
		{
			$order_storage = "data/orders";
			if (!is_dir("data"))
				mkdir("data");
			if (file_exists($order_storage))
			{
				$orders = file_get_contents($order_storage);
				$orders = unserialize($orders);
			}
			$len = count($orders);
			$orders[$len][basket] = $_SESSION[basket];
			$orders[$len][login] = $_SESSION[login];
			$orders[$len][time] = time();
			unset($_SESSION[basket]);
			file_put_contents($order_storage, serialize($orders));
			$MESSAGE = "<b>Thank you for your order!</b>";
		}
	}
	else if ($_GET[order] == "empty")
		unset($_SESSION[basket]);


	$user_storage = "data/users";
	$users = unserialize(file_get_contents($user_storage));
	$basket = $users[$_SESSION[user]][basket];
	foreach ($basket as $prod)
		echo $prod;
	
	$product_storage = "data/products";
	$prods = unserialize(file_get_contents($product_storage));
	$items_html = "";
	$total = 0;
	$quantity = array();
	foreach($_SESSION[basket] as $item)
	{
		if (array_search($quantity, $item) === FALSE)
			$quantity[$item] = 1;
		else
			$quantity[$item]++;
	}
	foreach($quantity as $name => $amount)
	{
		$items_html = $items_html."
		<tr class='item'>
			<td id='img'>
				<div class='previewbox'>
						<img class='previewphoto' src='images/".$prods[$name][image]."'>
					".$name."
				</div>
			</td>
			<td>
				<b>quantity: ".$amount."</b>
		</td>
			<td>
				<b>".$prods[$name][price]."€/pc</b>
			</td>
		</tr>";
		$total += (float)$prods[$name][price] * $amount;
	}
	$items_html = "<table class='products'>".$items_html."</table>";
	$items_html = $items_html."<br/><b>TOTAL PRICE: ".$total."€</b>";

	$basket_html = "";
	$total = 0;
	foreach($_SESSION[basket] as $item)
	{
		$price = $prods[$item][price];
		$basket_html = $basket_html."<a>".$item."<br/>".$price."€</a>";
		$total += (float)$price;
	}
	$basket_html = "<a><b>TOTAL<br/>".$total."€</b></a>".$basket_html;
	if ($_SESSION[basket] && $_SESSION[basket][0] != "")
	{
		$button_html = "
		<a href='?order=done' class='order'>
			Make order
		</a>
		<br/><br/>
		<br/>
		<a href='?order=empty' class='order'>
			Empty basket
		</a>";
	}
?>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="style.css">
		<title>Basket</title>
	</head>
	<body>
		<div class="topbar">
			<table class="topbartable">
				<tr>
					<td class="shopname">
					<a href="index.php" style="text-decoration:none;color:black;"><img id="logo" src="images/logo.png" title="logo" alt="logo"></a>
					</td>
					<?php echo $ORDERS?>
					<td class="logintd">
						<a href=<?php echo $LOGLINK?> id="login">
							<div style="height:50px;padding-top:20px;"><?php echo $LOGTEXT?>
							</div>
						</a>
					</td>
					<td class="basket">
					<div class="dropdown">
						<button class="dd-button">
							<a href="#">
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
		<?php echo $TOPMESSAGE?>
		<div class="preview" style="left:50%; text-align:center;">
			<?php echo $items_html; ?>
			<br/><br/>
				<?php echo $button_html?>
			<br/><br/><br/>
				<?php echo $MESSAGE?>
			<br/><br/><br/>
		</div>
	</body>
</html>
