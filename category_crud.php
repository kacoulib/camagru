<?php
	session_start();
	require_once("controlers/index.php");

	// 								create | update | delet
	if (in_array($_POST['action'], ['cre', 'upd', 'del']))
	{
		if (is_set($_POST["name"]))
		{
				$description = ($_POST['description']) ? $_POST['description'] : "";
				$new = ['name' => $_POST['name'], 'description' => $description];
				if ($_POST['action'] == 'cre')
					$test = create_category($new);
				else if ($_POST['action'] == 'upd' || $_POST['action'] == 'del')
				{
          $new['id'] = intval($_POST['category_id']);
					if ($_POST['action'] == 'upd')
						update_category($new);
					else
						delete_category($new['id']);
				}
		}
	}
	header("Location: categories.php");
