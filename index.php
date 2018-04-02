<?php

	if (!isset($_SESSION))
		session_start();

	require_once(dirname(__FILE__) . "/models/index.php");
	require_once(dirname(__FILE__) . "/controlers/index.php");

	if ($_SESSION['logged_on_user'])
		$user = $_SESSION['logged_on_user'];

	$title = 'Home';
	$childView = 'views/_index.php';
	include('layout.php');
