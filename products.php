<?php

if (!isset($_SESSION))
	session_start();


	if (!$_SESSION['logged_on_user'])
	{
		header("Location: index.php");
		exit();
	}

	$user = $_SESSION['logged_on_user'];

	require_once(dirname(__FILE__) . '/models/index.php');
	require_once(dirname(__FILE__) . '/controlers/index.php');

	if (isset($_POST['filter']) && isset($_POST['image']))
	{
		$data = ['user_id' => $user['id'], 'url' => 'toto'];
		if ($data['user_id'] && $data['url'])
			$product = create_product($_POST);
	}

	$title = 'Make up';
	$childView = 'views/_products.php';
	include('layout.php');
?>
