<?php
	session_start();
	require_once('controlers/index.php');
	if ($_SESSION['logged_on_user'])
	{
		$user = get_user_by_id(intval($_SESSION['logged_on_user'][0]['id']));
		$user = $user[0];
	}
	$title = 'Admin Products';
	$childView = 'views/_admin_products.php';
	if ($_GET && in_array($_GET['sort_by'], ['login', 'price']))
		$products = get_all_products_order_by($_GET['sort_by']);
	else
		$products = get_all_products();
	include('layout.php');
?>
