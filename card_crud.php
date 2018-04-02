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

	if ($_POST['action'] == 'update_user')
	{
		if (isset($_POST['login']) && isset($_POST['password']) && isset($_POST['email']))
		{
			$is_password_set = false;
			$data = ['login' => $_POST['login'], 'email' => $_POST['email']];
			if (is_set($_POST['password']))
			{
				$data['password'] = $_POST['password'];
				$is_password_set = true;
				if (!check_data($data))
					redirect();
			}

			if (is_set($_POST['send_notif']) && $_POST['send_notif'] == 'on')
				$data['send_notif'] = '1';
			else
				$data['send_notif'] = '0';

			$data = sanitize_data($data);
			if (!$is_password_set)
				$data['password'] = $_SESSION['logged_on_user']['password'];

			$data['id'] = $_SESSION['logged_on_user']['id'];
			$data['is_confirm'] = $_SESSION['logged_on_user']['is_confirm'];
			$data['confirm_id'] = $_SESSION['logged_on_user']['confirm_id'];

			if (($user = update_user($data)))
				$_SESSION['logged_on_user'] = $user;
		}
		else
		{
			$_SESSION['error'] = 'Profile not updated';
		}
	}

redirect();

function redirect()
{
	$last_url = $_SERVER['HTTP_REFERER'];
	if ($last_url)
	header("Location: $last_url");
	else
	header("Location: index.php");
	exit();
}
