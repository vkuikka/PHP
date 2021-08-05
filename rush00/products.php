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


	$product_storage = "data/products";
	$prods = unserialize(file_get_contents($product_storage));

	foreach($_GET as $name => $action)
		if ($action == 1)
			$open_category = $name;

	foreach($_POST as $name => $action)
	{
		if ($action == "Add to basket")
		{
			$name = preg_replace("/_/", " ", $name);
			if (!is_array($_SESSION[basket]))
				$_SESSION[basket] = array();
			$_SESSION[basket][count($_SESSION[basket])] = $prods[$name]['name'];
		}
	}

	if (is_dir("data"))
	{
		$item_storage = "data/products";
		if (file_exists($item_storage))
		{
			$items = unserialize(file_get_contents($item_storage));
			$items_html;
			foreach($items as $item)
			{
				if ($item[category] == $_GET[category])
				{
					$items_html = $items_html."
					<tr class='item'>
						<td id='img'>
							<div class='previewbox'>
									<img class='previewphoto' src='images/".$item[image]."'>
								".$item[name]."
							</div>
						</td>
						<td>
							<b>".$item[price]."€</b>
						</td>
						<td>
							<form method='POST'>
								<input type='submit' name='".$item[name]."' value='Add to basket' />
							</form>
						</td>
					</tr>";
				}
			}

		}
	}
	$basket_html = "";
	$total = 0;
	foreach($_SESSION[basket] as $item)
	{
		$price = $prods[$item][price];
		$basket_html = $basket_html."<a>".$item."<br/>".$price."€</a>";
		$total += (float)$price;
	}
	$basket_html = "<a><b>TOTAL<br/>".$total."€</b></a>".$basket_html;

	$categories_html = "";
	$category_storage = "data/categories";
	$categories = unserialize(file_get_contents($category_storage));
	foreach($categories as $key => $category)
	{
		$category_html = $category_html."
		<a href='?category=".$category[name]."' class='order' style='text-decoration:none;color:black;font-size:18px;border:none;'>".$category[name]."</a>
		<br/><br/>";
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
					<a href="index.php" style="text-decoration:none;color:black;"><img id="logo" src="images/logo.png" title="logo" alt="logo"></a>
				</td>
				<?php  echo $ORDERS?>
				<td class="logintd">
					<a href=<?php echo $LOGLINK?> id="login">
						<div style="animation: name 2s forwards;height:50px;padding-top:20px;"><?php echo $LOGTEXT?>
						</div>
					</a>
				</td>
				<td class="basket">
					<div class="dropdown">
						<button class="dd-button">
							<a href="basket.php"><img id="basketlogo" src="images/cart.png" title="basket" alt="basket"></a>
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
			<div class="text-block" style="position:absolute;color:white;top:300px;left:50%;">
    			<h1>Rocks.</br>&emsp;&emsp;For you.</h1>
  			</div>
		</div>
		<div class="categories">
			<div class="sidebar">
				<h2>Categories</h2>
					<?php echo $category_html?>
			</div>
			<div>
				<table class="products">
					<?php echo $items_html; ?>
				</table>
			</div>
		</div>
	</body>
</html>
