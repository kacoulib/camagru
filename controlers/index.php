<?php

	function	is_set($test)
	{
		return (strlen($test) != 0 && isset($test));
	}

	require_once("models/index.php");
