<?php

	session_start();

	require_once('controlers/index.php');
    $last_url = $_SERVER['HTTP_REFERER'];

	if (is_set($_POST['firstname']) || is_set($_POST['password']))
	{
		$user = get_user(['firstname' => $_POST['firstname'], "password" => $_POST['password']]);

		if ($user && !strpos($last_url, 'signup.php'))
		{
			$_SESSION['logged_on_user'] = $user;
			header("Location: index.php");
			exit();
		}
		else if (!$user && strpos($last_url, 'signup.php'))
		{
			$status = ($_POST['status']) ? $_POST['status'] : 'visitor';
			$user = create_user(['firstname' => $_POST['firstname'], "password" => $_POST['password'], 'status' => $status]);
			if ($user)
			{
				$_SESSION['logged_on_user'] = $user;
				header("Location: index.php");
				exit();
			}
		}
	}
	if (strpos($last_url, 'login.php'))
		header("Location: login.php");
	else if (strpos($last_url, 'signup.php'))
		header("Location: signup.php");
	else
		header("Location: index.php");
	exit();
?>
