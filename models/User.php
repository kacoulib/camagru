<?php

	if (!isset($_SESSION))
		session_start();

	// create
	function create_user(array $data)
	{
		if (!check_data($data))
			return (FALSE);
		if (!($db = get_connection()))
		{
			$_SESSION['error'] = 'Db connection error';
			return (FALSE);
		}
		if (loginOrEmailExist($data))
		{
			$_SESSION['error'] = 'User already exist';
			return (FALSE);
		}
		$data = sanitize_data($data);
		$confirm_id = generate_string(25);

		try
		{
			$sql = $db->prepare("INSERT INTO Users (login, password, email, confirm_id) VALUES (:login, :password, :email, :confirm_id)");
			$sql->bindParam(':login', $data['login']);
			$sql->bindParam(':password', $data['password']);
			$sql->bindParam(':email', $data['email']);
			$sql->bindParam(':confirm_id', $confirm_id);
			$sql->execute();

			send_mail($data['email'], $confirm_id);
			$_SESSION['message'] = 'A confirmation mail has been send';
			return (true);
		}
		catch (Exception $e)
		{
			$_SESSION['error'] = $e;
			return (null);
		}
	}

	function loginOrEmailExist(array $data)
	{
		if (!isset($data['login']) || !isset($data['email']))
			return (false);
		if (!check_data($data))
			return (false);
		if (!($db = get_connection()))
		{
			$_SESSION['error'] = 'Db connection error';
			return (FALSE);
		}
		$data = sanitize_data($data);

		$sql = $db->prepare("SELECT COUNT(login) FROM Users WHERE login = :login OR email = :email");
		$sql->bindParam(':login', $data['login']);
		$sql->bindParam(':email', $data['email']);
		$sql->execute();
		return($sql->fetchColumn());
	}
	// read
	function get_user(array $data)
	{
		if (!check_data($data))
			return (FALSE);
		if (!is_set($data["login"]) || !is_set($data['password']))
			return (FALSE);
		if (!($db = get_connection()))
			return (FALSE);

		$data = sanitize_data($data);

		$sql = $db->prepare("SELECT id, login, password, email, confirm_id, is_confirm, send_notif FROM Users WHERE login = :login AND password = :password");
		$sql->bindParam(':login', $data['login']);
		$sql->bindParam(':password', $data['password']);
		$sql->execute();
		$user = $sql->fetchAll(PDO::FETCH_ASSOC);

		if (!$user[0])
		{
			$_SESSION['error'] = 'User not found';
			return false;
		}
		else if (!$user[0]['is_confirm'])
		{
			$_SESSION['error'] = 'User not confirmed';
			return false;
		}
		return $user[0];
	}

	// read
	function get_user_by_login(array $data)
	{
		if (!check_data($data))
			return (FALSE);
		if (!is_set($data["login"]))
			return (FALSE);
		if (!($db = get_connection()))
			return (FALSE);

		$data = sanitize_data($data);

		$sql = $db->prepare("SELECT id, login, password, email, confirm_id, is_confirm, send_notif FROM Users WHERE login = :login");
		$sql->bindParam(':login', $data['login']);
		$sql->execute();
		$user = $sql->fetchAll(PDO::FETCH_ASSOC);

		if (!$user[0])
		{
			$_SESSION['error'] = 'User not found';
			return false;
		}
		return $user[0];
	}

	function get_user_by_id($id)
	{
		if (!is_int($id))
			return (FALSE);
		$id = intval($id);
		if (!($db = get_connection()))
			return (FALSE);
		$sql = "SELECT * FROM User WHERE id = $id";
		$result = mysqli_query($db, $sql);

		if ($result->num_rows > 0)
		{
			$new = [];
			while($row = mysqli_fetch_assoc($result))
				$new[] = $row;
			return ($new);
		}
		return (FALSE);
	}

	function find_user_by_confirm_id(array $data)
	{
		if (!isset($data['confirm_id']) || $data['confirm_id'] == null)
			return (false);

		$data = sanitize_data($data);

		if (!($db = get_connection()))
			return (FALSE);

		$sql = $db->prepare("SELECT id, login, password, email, confirm_id, is_confirm, send_notif FROM Users WHERE confirm_id = :confirm_id AND is_confirm = 0");
		$sql->bindParam(':confirm_id', $data['confirm_id']);
		$sql->execute();

		$user = $sql->fetchAll(PDO::FETCH_ASSOC);
		if (!$user)
			return (false);

		return ($user[0]);
	}

	function confirm_user(array $data)
	{
		if (!is_set($data["login"]))
			return (FALSE);
		$data['confirm_id'] = null;
		$data['is_confirm'] = 1;

		$tmp = $data['password'];
		$data = sanitize_data($data);
		$data['password'] = $tmp;

		return update_user($data);
	}

	// read all
	function get_all_users()
	{
		if (!($db = get_connection()))
			return (FALSE);
		$sql = "SELECT * FROM User";
		$result = mysqli_query($db, $sql);

		if ($result->num_rows > 0)
		{
			$new = [];
			while($row = mysqli_fetch_assoc($result))
				$new[] = $row;
			return ($new);
		}
		return (FALSE);
	}

	// update
	function update_user(array $data)
	{
		if (!check_data($data))
			return (FALSE);
		if (!is_set($data["login"]) || !is_set($data["password"]))
			return (FALSE);

		if (!($db = get_connection()))
			return (FALSE);

		$data['send_notif'] = $data['send_notif'] == '1' ? '1' : '0';
		$data['confirm_id'] = $data['confirm_id'] ? $data['confirm_id'] : null;


		$sql = $db->prepare("UPDATE Users SET login = :login, email = :email, password = :password, is_confirm = :is_confirm, confirm_id = :confirm_id, send_notif = :send_notif WHERE id = :id");
		$sql->bindParam(':login', $data['login']);
		$sql->bindParam(':email', $data['email']);
		$sql->bindParam(':password', $data['password']);
		$sql->bindParam(':is_confirm', $data['is_confirm']);
		$sql->bindParam(':confirm_id', $data['confirm_id']);
		$sql->bindParam(':send_notif', $data['send_notif']);
		$sql->bindParam(':id', $data['id']);
		$sql->execute();

		var_dump($data);
		if ($sql->rowCount())
		{
			return (get_user_by_login(['login' => $data['login']]));
		}
		return (null);
	}

	// delete
	function delete_user($id)
	{
		if (!is_int($id))
			return (FALSE);
		if (!($db = get_connection()))
			return (FALSE);
		$sql = "DELETE FROM User WHERE id = $id";

		if (mysqli_query($db, $sql))
			return (TRUE);
		return (FALSE);
	}

	function check_data(array $data)
	{
		// check if all params arr ok
		$i = 0;
		foreach ($data as $key => $value)
		{
			if ($key == "login" || $key == "password")
			{
				if (strlen($value) < 4)
				{
					$_SESSION['error'] = ucfirst($key).' too short';
					$i++;
					break;
				}

				if ($key == 'password' && !preg_match('/[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/', $value))
				{
					$_SESSION['error'] = 'Pasword not strong';
					$i++;
					break;
				}
			}
			else if ($key == 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL))
			{
				$_SESSION['error'] = 'Not a valid email';
				$i++;
				break;
			}
			else if ($key == 'id')
			{
				$value = intval($value);

				if ($value < 1)
				{
					$_SESSION['error'] = 'Not a valid user';
					$i++;
					break;
				}
			}
		}
		return ($i == 0);
	}

	function sanitize_data(array $data)
	{
		foreach ($data as $key => $value)
		{
			if ($key == 'login' || $key == 'email' || $key == 'confirm_id')
				$data[$key] = htmlentities($value);
			else if ($key == 'password')
				$data[$key] = hash("whirlpool", "-,+*)('&%$#\"".$data[$key]."0987654321asTuVwXyZ");
		}
		return $data;
	}

	function generate_string($random_time = 10)
	{
		$str = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$str_len = strlen($str);
		$txt = '';

		for ($i = 0; $i < $random_time; $i++)
			$txt .= $str[rand(0, $str_len - 1)];

		return ($txt);
	}


	function send_mail($email, $confirm_id)
	{
		$message = "
		<html>
			<head>
				<title>Camagru confirmation</title>
			</head>
			<body>
				<a href='http://localhost:8080/camagru/?action=confirm_inscription&confirm_id=".$confirm_id."'>Confirmer inscription!</a>
			</body>
		</html>";
		$headers[] = 'MIME-Version: 1.0';
		$headers[] = 'Content-type: text/html; charset=iso-8859-1';
		mail($email, 'Camagru inscription', $message, implode("\r\n", $headers));
		return;
	}
