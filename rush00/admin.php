<?PHP
	require 'session_verify.php';

	session_start();
	if (!(verify_session($_SESSION[login], $_SESSION[passwd])) ||
		$_SESSION[login] != hash(whirlpool, "admin"))
	{
		echo "Not authorized";
		return;
	}

	$user_storage = "data/users";
	$product_storage = "data/products";
	$category_storage = "data/categories";
	$image_dir = "images/";

	if (!is_dir("data"))
		mkdir("data");
	if ($_POST[submit_type] == "upload")
	{
		$file = $image_dir.basename($_FILES[submit_type][name]);
		$filetype = strtolower(pathinfo($file, PATHINFO_EXTENSION));
		$filename = $_FILES[submit_type][name];
		$image_success = FALSE;
		if (!$filename)
			$MESSAGE = "Drop a file or choose from the menu.";
		else if (false === getimagesize($_FILES[submit_type][tmp_name]))
			$MESSAGE = "Chosen file is not an image.";
		else if (file_exists($file))
		{
			$MESSAGE = "File ".$filename." already exists. Rename if you don't want to use the old one.";
			$image_success = TRUE;
		}
		else
		{
			if (move_uploaded_file($_FILES[submit_type][tmp_name], $file))
			{
				$MESSAGE = "File ".$filename." has been uploaded.";
				$image_success = TRUE;
			}
			else
				$MESSAGE = "There was an error while uploading your file.";
		}
	}
	if ($_POST[submit_type] == "Add product")
	{
		if (file_exists($product_storage))
			$products = unserialize(file_get_contents($product_storage));
		else
			$products = array();
		if ($_POST[prod_name] != "" && $_POST[prod_name] &&
			$_POST[prod_price] != "" && $_POST[prod_price] &&
			$_POST[image] != "" && $_POST[image] &&
			$_POST[category] != "" && $_POST[category])
		{
			$key = $_POST[prod_name];
			while ($products[$key][name])
				$key = $key.$key;
			$products[$key][name] = $_POST[prod_name];
			$products[$key][price] = $_POST[prod_price];
			$products[$key][image] = $_POST[image];
			$products[$key][category] = $_POST[category];
			file_put_contents($product_storage, serialize($products));
		}
	}
	else if ($_POST[submit_type] == "Delete product")
	{
		if (file_exists($product_storage))
			$products = unserialize(file_get_contents($product_storage));
		else
			$products = array();
		$key = $_POST[product];
		while (!$products[$key][name])
			$key = $key.$key;
		unset($products[$key][name]);
		unset($products[$key][price]);
		unset($products[$key][image]);
		unset($products[$key][category]);
		unset($products[$key]);
		file_put_contents($product_storage, serialize($products));
	}
	else if ($_POST[submit_type] == "Add category")
	{
		if (file_exists($category_storage))
			$categories = unserialize(file_get_contents($category_storage));
		else
			$categories = array();
		$cat_names = array();
		foreach($categories as $category)
			array_push($cat_names, $category[name]);
		if (in_array($_POST[category_name], $cat_names))
			$ADDMESSAGE = "Category already exists";
		else
		{
			$ADDMESSAGE = "Category added";
			$cat[name] = $_POST[category_name];
			$cat[image] = $_POST[image];
			$categories[count($categories)] = $cat;
			$key = array_search($_POST["category_name"], $categories);
			file_put_contents($category_storage, serialize($categories));
		}
	}
	else if ($_POST[submit_type] == "Delete category")
	{
		$categories = unserialize(file_get_contents($category_storage));
		$key;
		foreach($categories as $i => $cat)
			if ($cat[name] == $_POST[category])
				$key = $i;
		unset($categories[$key][name]);
		unset($categories[$key][image]);
		unset($categories[$key]);
		$categories = array_values($categories);
		file_put_contents($category_storage, serialize($categories));
	}



	if (is_dir("data"))
	{
		if (file_exists($category_storage))
		{
			$categories = unserialize(file_get_contents($category_storage));
			$categoties_html;
			foreach($categories as $category)
				$categories_html = $categories_html."<option value='".$category[name]."'>".$category[name]."</option>";
		}
		if (file_exists($product_storage))
		{
			$products = unserialize(file_get_contents($product_storage));
			$products_html;
			foreach($products as $prod)
				$products_html = $products_html."<option value='".$prod[name]."'>".$prod[name]."</option>";

		}
	}
	if (is_dir("images"))
	{
		$images = glob($image_dir."/*");
		foreach ($images as $key => $img)
			$images[$key] = substr($img, strlen($image_dir) + 1);
		foreach ($images as $img)
			$image_names = $image_names."<option value='".$img."'>".$img."</option>";
	}
?>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="style.css">
		<link rel="stylesheet" type="text/css" href="admin.css">
		<title>admin</title>
	</head>
	<body>
		<div id="login-top">
			<div style="padding-top:15px;">
			<a style="text-decoration:none;color:black;"><img id="logo" src="images/logo.png" title="logo" alt="logo"></a>
			</div>
		</div>
		<br/><br/>
		<div id="title"><h1>Admin page</h1></div>
		<div style="left:50%; text-align:center;">
		<br/>
		<a id="button" href="orders.php" class="button">Show all orders</a>
		<br/><br/>
		<div class="form-box">
				<div id="title"><h3>Products</h3></div>
				<br/>
				<form method="POST">
					Product image: &emsp;<select name="image">
					<?php echo $image_names?>
					</select>
					<br/><br/>
					Product name:&emsp;<input name="prod_name" value=""/>
					<br/><br/>
					Product price: &emsp;<input name="prod_price" value=""/>
					<br/><br/>
					Product category: &emsp;<select name="category" id="category">
					<?php echo $categories_html?>
					</select>
					<br/><br/>
					<input type="submit" name="submit_type" value="Add product"/>
				</form>
				<br/>
				<form method="POST">
					Delete product: &emsp;<select name="product" id="category">
					<?php echo $products_html?>
					</select>
					<br/><br/>
					<input type="submit" name="submit_type" value="Delete product"/>
				</form>
	
			</div>
				<br/><br/><br/>
			<div class="form-box">
				<div id="title"><h3>Categories</h3></div>
				<br/>
				<form method="POST">
					Category image: &emsp;<select name="image">
					<?php echo $image_names?>
					</select>
					<br/><br/>
					Category name:&emsp;<input name="category_name" value=""/>
					<br/><br/>
					<input type="submit" name="submit_type" value="Add category"/>
					<br/>
					<?php echo $ADDMESSAGE?>
					<br/>
				</form>
				<form method="POST">
					Delete category: &emsp;<select name="category" id="category">
					<?php echo $categories_html?>
					</select>
					<br/><br/>
					<input type="submit" name="submit_type" value="Delete category"/>
				</form>
			</div>
			<br/><br/><br/>
			<div class="form-box">
				<div id="title"><h3>Upload image</h3></div>
				<br/>
				<div style="text-align:center;">
					<form method="POST" enctype="multipart/form-data">
						<input type="file" name="submit_type" value="asd"/>
							<br/><br/>
						<input type="submit" name="submit_type" value="upload"/>
					</form>
					<?php echo $MESSAGE?>
				</div>
				<br/><br/>
			</div>
		</div>
		<br/><br/><br/><br/><br/>
	</body>
</html>
