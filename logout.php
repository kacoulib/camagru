<?php

if (!isset($_SESSION))
	session_start();

	$_SESSION = [];
	session_destroy();

	header("Location: index.php");
