<?php

	session_start();

	require_once("controlers/index.php");
	if ($_SESSION['logged_on_user']){
		$user = get_user_by_id(intval($_SESSION['logged_on_user'][0]['id']));
		$user = $user[0];
	}
	$products = get_all_products();
	$i = 0;
  $title = 'Home';
  $childView = 'views/_index.php';
  include('layout.php');

?>
