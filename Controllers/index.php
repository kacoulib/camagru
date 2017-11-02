<?php
	session_start();

	require_once('../Models/index.php');
	require_once('../Models/Users.php');
	require_once('../Models/Images.php');




	$user = New User();
	$user->login = "kacoulib";
	$user->email = "tes@test.0test";
	$user->password = "test";
	$user->confirm_id = "1tdsfdshfdsjfdsfdest1";
	$user->is_confirm = "0";
	var_dump($user->save());

	// $img = New Image();

	// $img->user_id = 1;
	// $img->nb_like = 0;
	// $img->name = "testds35sd4dsdsds2sdffsf";
	// $img->url = "test+6";
	// // $img->merge_jpeg_and_png("../Public/img/carapuce.gif", "../Public/img/filters/hat.png");
	// // $img->validate([...])->save();
	// var_dump($img->save());
	// echo "ok";
	return ;



	if (isset($_POST) && is_set($_POST['action']))
	{
		if ($_POST['action'] == 'screenshot' && is_set($_POST['img']))
		{
			$db = new Connect();
			$_SESSION['user'] = ['login' => 'test', 'email' => 'dsfsdf'];

			if (is_set($_POST['filter']))	
			{
				$src = '../Public/img/filters/'.$_POST['filter'].'.png';
				if (file_exists($src))
				{
					$dest = str_replace('data:image/png;base64,', '', $_POST['img']);
					$dest = str_replace(' ', '+', $dest);
					$dest = base64_decode($dest);
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
		else if ($_POST['action'] == 'register')
		{
			if (!is_set($_POST['login']) || !is_set($_POST['password']) || !is_set($_POST['email']))
				return ;
			if (!($db = new Connect()))
				return ;
			if (!($user = new User($db)))
				return ;
			$tmp = $user->add([
				'login' => $_POST['login'],
				'password' => $_POST['password'],
				'email' => $_POST['email']]);
			if (!$tmp)
			{
				header("HTTP/1.0 500 Internal Server Error");
				echo 'Exception reçue : ',  $e->getMessage(), "\n";
				exit();
			}
			$message = "<html>
						<head>
						  <title>Birthday Reminders for August</title>
						</head>
						<body>
							<a href='http://localhost:8080/index.php?action=confirm_inscription&confirm_id=231231231321'>Confirmer inscription!</a>
						</body></html>";

// To send HTML mail, the Content-type header must be set
$headers[] = 'MIME-Version: 1.0';
$headers[] = 'Content-type: text/html; charset=iso-8859-1';


			mail($_POST['email'], 'Camagru inscription', $message, implode("\r\n", $headers));
		}
	}




function	is_set($test)
{
	return (strlen($test) != 0 && isset($test));
}

function my_random($length = 10) {
    $str = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $str_len = strlen($str);
    $ret = '';
    for ($i = 0; $i < $length; $i++)
        $ret .= $str[rand(0, $str_len - 1)];
    return $ret;
}