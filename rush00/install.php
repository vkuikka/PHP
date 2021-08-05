#!/usr/bin/php
<?php
	if (!is_dir("data"))
		mkdir("data");
	if (file_exists("data/categories") ||
		file_exists("data/orders") ||
		file_exists("data/products") ||
		file_exists("data/users"))
		return;

	$user_storage = "data/users";
	$order_storage = "data/orders";
	$product_storage = "data/products";
	$categories_storage = "data/categories";

	$login_hash = hash(whirlpool, "admin");
	$passwd_hash = hash(whirlpool, "123");
	$users[$login_hash][login] = $login_hash;
	$users[$login_hash][passwd] = $passwd_hash;
	file_put_contents($user_storage, serialize($users));

	touch($user_storage);

	$products["grey stone"][price] = 20;
	$products["grey stone"][name] = "grey stone";
	$products["grey stone"][image] = "graystone.png";
	$products["grey stone"][category] = "single";

	$products["white stone"][price] = 25;
	$products["white stone"][name] = "white stone";
	$products["white stone"][image] = "whitestone.png";
	$products["white stone"][category] = "single";

	$products["stepping stone"][price] = 15.99;
	$products["stepping stone"][name] = "stepping stone";
	$products["stepping stone"][image] = "steppingstone.png";
	$products["stepping stone"][category] = "single";

	$products["blue stone"][price] = 29.9;
	$products["blue stone"][name] = "blue stone";
	$products["blue stone"][image] = "bluestone.png";
	$products["blue stone"][category] = "single";

	$products["magic stone"][price] = 49.75;
	$products["magic stone"][name] = "magic stone";
	$products["magic stone"][image] = "magicstone.png";
	$products["magic stone"][category] = "fancy";

	$products["infinity stone"][price] = 53.25;
	$products["infinity stone"][name] = "infinity stone";
	$products["infinity stone"][image] = "infinitystone.png";
	$products["infinity stone"][category] = "fancy";

	$products["black packet"][price] = 70;
	$products["black packet"][name] = "black packet";
	$products["black packet"][image] = "blackpacket.png";
	$products["black packet"][category] = "packets";

	$products["white packet"][price] = 69;
	$products["white packet"][name] = "white packet";
	$products["white packet"][image] = "whitepacket.png";
	$products["white packet"][category] = "packets";

	file_put_contents($product_storage, serialize($products));

	$categories["packets"][name] = "packets";
	$categories["fancy"][name] = "fancy";
	$categories["single"][name] = "single";

	$categories["packets"][image] = "whitepacket.png";
	$categories["fancy"][image] = "magicstone.png";
	$categories["single"][image] = "graystone.png";

	file_put_contents($categories_storage, serialize($categories));
?>
