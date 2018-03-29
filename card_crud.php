<?php

	session_start();
	require_once('controlers/index.php');

	if (!$_SESSION["card"])
		$_SESSION['card'] = [];
	if ($_POST['action'] == 'validate'){
		validate_cart($_POST['product_id']);
		header("Location: thank_you.php");
		exit();
	}
	if ((is_set($_POST['product_id'])))
	{
		$id = $_POST['product_id'];
		if ($_POST['action'] == 'add')
			add_card($_POST['product_id']);
		else if ($_POST['action'] == 'upd')
			$_SESSION['quantity'][$id] = abs($_POST['quantity']);
		else if ($_POST['action'] == 'del')
			delete_card($id);
	}
	$last_url = $_SERVER['HTTP_REFERER'];
	if ($last_url)
		header("Location: $last_url");
	else
		header("Location: index.php");
	exit();

	function validate_cart(){
		$_SESSION['card'] = [];
		return (TRUE);
	}

	function add_card($id)
	{
		if (!is_numeric($id))
			return (FALSE);
		$id = intval($id);
		$product = get_product_by_id($id);
		if ($product)
		{
			$_SESSION['card'][] = $product;
			return (TRUE);
		}
		return (FALSE);
	}

	function delete_card($id)
	{

		if (!is_numeric($id))
			return (FALSE);
		$id = intval($id);
		$cards = $_SESSION['card'];
		$tmp = [];

		foreach ($cards as $key => $value)
		{
			if ($value[0]['id'] != $id)
				$tmp[] = $value;
		}
		$_SESSION['card'] = $tmp;
		return (TRUE);
	}
