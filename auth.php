<?php

if (!isset($_SESSION))
	session_start();

	require_once(dirname(__FILE__) . '/models/index.php');
	require_once(dirname(__FILE__) . '/controlers/index.php');
  $last_url = $_SERVER['HTTP_REFERER'];


	if (isset($_POST['login']) && isset($_POST['password']))
	{
		if (!strpos($last_url, 'signup.php'))
		{
			if (($user = get_user(['login' => $_POST['login'], "password" => $_POST['password']])))
			{
				$_SESSION['logged_on_user'] = $user;
				header("Location: index.php");
				exit();
			}
		}
		else if (strpos($last_url, 'signup.php'))
		{
			$user = create_user(['login' => $_POST['login'], "password" => $_POST['password'], 'email' => $_POST['email']]);
			if ($user)
			{
				header("Location: index.php");
				exit();
			}
		}
	}
	else if ($_GET['action'] == 'confirm_inscription' && is_set($_GET['confirm_id']))
	{
		if (($user = find_user_by_confirm_id(['confirm_id' => $_GET['confirm_id']])))
		{
			$user = confirm_user($user);
			$_SESSION['logged_on_user'] = $user;
		}
		else
			$_SESSION['error'] = 'Error while user confirmation';
	}

	if (strpos($last_url, 'login.php'))
		header("Location: /login.php");
	else if (strpos($last_url, 'signup.php'))
		header("Location: /signup.php");
	else
		header("Location: /index.php");
	exit();
?>
