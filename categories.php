<?php
	session_start();
	require_once('controlers/index.php');
	if ($_SESSION['logged_on_user']){
		$user = get_user_by_id(intval($_SESSION['logged_on_user'][0]['id']));
		$user = $user[0];
	}
	$title = 'Categories';
	$childView = 'views/_categories.php';
	$categories = get_all_categories();
	include('layout.php');
?>
