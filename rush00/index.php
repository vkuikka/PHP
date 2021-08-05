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

	$user_storage = "data/users";
	$users = unserialize(file_get_contents($user_storage));

	$product_storage = "data/products";
	$prods = unserialize(file_get_contents($product_storage));

	$basket_html = "";
	$total = 0;
	foreach($_SESSION[basket] as $item)
	{
		$price = $prods[$item][price];
		$basket_html = $basket_html."<a>".$item."<br/>".$price."€</a>";
		$total += (float)$price;
	}
	$basket_html = "<a><b>TOTAL<br/>".$total."€</b></a>".$basket_html;

	if (is_dir("data"))
	{
		$category_storage = "data/categories";
		if (file_exists($category_storage))
		{
			$categories = unserialize(file_get_contents($category_storage));
			$categoties_html;
			$i = 0;
			foreach($categories as $category)
			{
				if ($i++ == 3)
				{
					$i = 1;
					$categories_html = $categories_html."</tr><tr>";
				}
				$categories_html = $categories_html."
				<td >
					<a href='products.php?category=".$category[name]."' style='text-decoration:none;color:black;'>
						<div class='previewbox'>
							<img class='previewphoto' src='images/".$category[image]."'>
						</div>".$category[name]."
					</a>
				</td>";
			}
			if (($count = count($categories)) < 3)
			{
				$td = ($count == 2) ? "<td></td>": "<td></td><td></td>";
				$categories_html = $categories_html.$td;
			}	
			$categories_html = $categories_html."<tr>";
		}
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>The stone shop </title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	<body>
		<div class="topbar">
			<table class="topbartable">
				<tr>
					<td class="shopname">
						<a href="index.php" style="text-decoration:none;color:black;">
							<img id="logo" src="images/logo.png" title="logo" alt="logo">
						</a>
					</td>
					<?php echo $ORDERS?>
					<td class="logintd">
						<a href=<?php echo $LOGLINK?> id="login">
							<div style="animation: name 2s forwards;height:50px;padding-top:20px;"><?php echo $LOGTEXT?>
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
		<div id="frontphoto">
			<img id="famphoto" src="images/frontphoto.png" title="front" alt="front">
			<div style="animation: name 2s forwards;position:absolute;color:white;top:300px;left:50%;">
    			<h1 class="unselectable">Rocks.</br>&emsp;&emsp;For you.</h1>
  			</div>
		</div>
		<div class="preview">
			<table style='text-align:center;'>
					<?php echo $categories_html?>
			</table>
		</div>
	</body>
</html>