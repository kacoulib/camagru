<?php

require_once('../config/database.php');

class Connect
{
	private $db;

	public function __construct()
	{
		try
		{
			$db = new PDO("mysql:host=localhost;dbname=camagru;", 'root', 'test');
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->db = $db;
		}
		catch (Exception $e)
		{
			
			header("HTTP/1.0 500 Internal Server Error");
			echo 'Exception reçue : ',  $e->getMessage(), "\n";
		    exit;
		}
	}

	public function get()
	{
		return ($this->db);
	}
}
