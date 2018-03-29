<?php

	require_once("models/Product.php");
	require_once("models/User.php");
	require_once("models/Category.php");

	function get_connection()
	{
		$host = "localhost";
		$user = "root";
		$password = "password";
		$db_name = "rocket";

		if (($connect = mysqli_connect($host, $user, $password, $db_name)));
		    	return ($connect);
		return (FALSE);
	}
