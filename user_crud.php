<?php

	session_start();

	require_once("controlers/index.php");

	// 								create | update | delet
	if (in_array($_POST['action'], ['cre', 'upd', 'del']))
	{
		if (is_set($_POST["firstname"]) && is_set($_POST["status"]))
		{
				$new = ['firstname' => $_POST['firstname'], 'status' => $_POST['status'], 'password' => $_POST['password']];

				if ($_POST['action'] == 'cre')
					$test = create_user($new);
				else if (($_POST['action'] == 'upd' || $_POST['action'] == 'del') && is_numeric($_POST['user_id']))
				{
					$new['id'] = intval($_POST['user_id']);
					if ($_POST['action'] == 'upd')
						update_user($new);
					else
						delete_user($new['id']);
				}

		}
	}
	header("Location: users.php");
