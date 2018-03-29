<?php

	session_start();

	if ($_SESSION['logged_on_user'])
	{
		if ($_SESSION['logged_on_user'][0]['status'] == 'admin')
		{
			require_once('controlers/index.php');
			$title = 'Users';
			$childView = 'views/_users.php';
			$users = get_all_users();

			include('layout.php');
			exit();
		}
	}
	header("Location: index.php");
?>
