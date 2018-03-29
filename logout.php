<?php
	session_start();
	
	$_SESSION['logged_on_user'] = '';
	$_SESSION['card'] = ''; // to remote
	header("Location: index.php");