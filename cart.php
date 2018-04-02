<?php

	if (!isset($_SESSION))
		session_start();

	if (!$_SESSION['logged_on_user'])
	{
		header("Location: index.php");
		exit();
	}
	$user = $_SESSION['logged_on_user'];

  $title = 'Cart';
  $childView = 'views/_cart.php';
  include('layout.php');
?>
