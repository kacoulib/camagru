<?php

if (!isset($_SESSION))
	session_start();


	if ($_SESSION['logged_on_user'])
	{
		header("Location: index.php");
		exit();
	}
  $title = 'Sign Up';
  $childView = 'views/_signup.php';
  include('layout.php');
?>
