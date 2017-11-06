<?php
	session_start();

	require_once('../Models/index.php');
	require_once('../Models/Users.php');
	require_once('../Models/Images.php');

	$_SESSION = [];
	if (isset($_POST) && is_set($_POST['action']) && is_string($_POST['action']))
	{
		if ($_POST['action'] == 'screenshot' && is_set($_POST['img']) && is_set($_SESSION['user']))
		{
			if (is_set($_POST['filter']))
			{
				$img = new Image();

				$src = '../Public/img/filters/'.$_POST['filter'].'.png';
				$new_img_name = $img->merge_jpeg_and_png($src, $_POST['img']);
				$img->user_id = $_SESSION['user']['id'];
				$img->save();
			}
		}
		else
		{
			$user = new User();
			if (in_array($_POST['action'], ['register', 'confirm_register', 'login', 'logout']))
			{
				$method = $_POST['action'];
				if (($method == 'register' || $method == 'confirm_register') && isset($_SESSION['user']))
					return (true);
		var_dump($_POST);
				$user->$method($_POST);
			}
		}
	}
	// var_dump($_SESSION);


function	is_set($test)
{
	if (is_array($test))
		return (count($test) > 0);
	return (strlen($test) != 0 && isset($test));
}

function error($error)
{
	http_response_code(500);
	echo ($error);
	exit ();
}
