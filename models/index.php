<?php

	include(dirname(__FILE__) . '/../config/database.php');
	require_once(dirname(__FILE__) . '/Product.php');
	require_once(dirname(__FILE__) . '/User.php');
	require_once(dirname(__FILE__) . '/Category.php');

	function get_connection()
	{
		global $DB_DSN;
		global $DB_USER;
		global $DB_PASSWORD;
		global $DB_NAME;
		global $DB_PORT;

		try {
			
			$db = new PDO("mysql:host=$DB_DSN;dbname=$DB_NAME;port=$DB_PORT;", $DB_USER, $DB_PASSWORD);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return ($db);
		}
		catch (Exception $e)
		{
			$_SESSION['error'] = 'Database connection error';

			header("Location: /camagru/index.php");
			exit();
		}
	}
