<?php
	session_start();

	require_once('../Models/index.php');
	require_once('../Models/Users.php');
	require_once('../Models/Images.php');

	$_SESSION = [];
	if (isset($_POST) && is_set($_POST['action']) && is_string($_POST['action']))
	{
		if ($_POST['action'] == 'screenshot' && is_set($_POST['img']))
		{
			if (is_set($_POST['filter']))	
			{
				$src = '../Public/img/filters/'.$_POST['filter'].'.png';
				if (file_exists($src))
				{
					$dest = str_replace('data:image/png;base64,', '', $_POST['img']);
					$dest = str_replace(' ', '+', $dest);
					$dest = base64_decode($dest);
					file_put_contents('test.png', $dest);
					return ;
					if (!($dest = @imagecreatefromstring($dest)) || !($src = @imagecreatefrompng($src)))
						exit;
					imageAlphaBlending($src, true);
					imageSaveAlpha($src, true);

					imagecopymerge($dest, $src, 100, 100, 0, 0, 256, 256, 100);
					
					imagepng($dest, '../Public/img/gun0.png');
					imagedestroy($dest);
					imagedestroy($src);
				}
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

if (isset($data))
{
	$json = json_encode($data);
	echo $json;
}
exit;


function	is_set($test)
{
	return (strlen($test) != 0 && isset($test));
}

function error($error)
{
	http_response_code(500);
	echo ($error);
	exit ();
}
