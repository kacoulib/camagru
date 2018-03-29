<?php

	session_start();

	require_once("controlers/index.php");

	// 								create | update | delet
	if (in_array($_POST['action'], ['cre', 'upd', 'del']))
	{
		if (is_set($_POST["category_name"]) && is_set($_POST["category_id"]))
		{
			if ((is_set($_POST["price"]) && is_numeric($_POST['price'])))
			{
				$description = ($_POST['description']) ? $_POST['description'] : "";
				$new = ['category_name' => $_POST['category_name'], 'price' => intval($_POST['price']), 'category_id' => $_POST['category_id'], 'description' => $description];
				if ($_POST['action'] == 'cre')
				{
					$new['image'] = "img/default.png";
					$test = create_product($new);
				}
				else if (($_POST['action'] == 'upd' || $_POST['action'] == 'del') && is_numeric($_POST['product_id']))
				{
					$new['image'] = $_POST['image'];
					$new['id'] = intval($_POST['product_id']);
					if ($_POST['action'] == 'upd')
						update_product($new);
					else
						delete_product($new['id']);
				}
			}

		}
	}
	header("Location: admin_products.php");
