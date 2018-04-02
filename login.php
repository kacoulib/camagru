<?php
	
if (!isset($_SESSION))
	session_start();

	if ($_SESSION['logged_on_user'])
	{
		header("Location: index.php");
		exit();
	}
	$title = 'Login';
	$childView = 'views/_login.php';
	include('layout.php');
?>
