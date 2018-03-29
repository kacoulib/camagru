<?php

	session_start();

	// create
	function create_user(array $data)
	{
		if (!check_data($data))
			return (FALSE);
		if (!($db = get_connection()))
			return (FALSE);
		$firstname	= htmlentities($data['firstname']);
		$password	= hash("whirlpool", "-,+*)('&%$#\"".$data['password']."0987654321asTuVwXyZ");
		$status = htmlentities($data['status']);
		$sql = "INSERT INTO user (firstname, password, status) VALUES ('$firstname', '$password', '$status')";
		if (mysqli_query($db, $sql))
			return (['firstname' => $firstname, 'status' => $status]);
		else
			return (FALSE);
	}

	// read
	function get_user(array $data)
	{
		if (!is_set($data["firstname"]) || !is_set($data['password']))
			return (FALSE);
		if (!($db = get_connection()))
			return (FALSE);
		$firstname	= htmlentities($data['firstname']);
		$password	= hash("whirlpool", "-,+*)('&%$#\"".$data['password']."0987654321asTuVwXyZ");
		$sql = "SELECT * FROM User WHERE firstname = '$firstname' AND password = '$password'";
		$result = mysqli_query($db, $sql);

		if ($result)
		{
			$new = [];
			while($row = mysqli_fetch_assoc($result))
				$new[] = $row;
			return ($new);
		}
		return (FALSE);
	}

	// read
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
		if (!is_int($data['id']))
			return (FALSE);
		if (!($db = get_connection()))
			return (FALSE);
		$id = $data['id'];
		$user = get_user_by_id($id);
		$firstname	= ($data['firstname']) ? htmlentities($data['firstname']) : $user['firstname'];
		$lastname	= ($data['lastname']) ? htmlentities($data['lastname']) : $user['lastname'];
		$email	= ($data['email']) ? htmlentities($data['email']) : $user['email'];
		$age	= ($data['age']) ? intval(htmlentities($data['age'])) : $user['age'];
		$age = intval($age);
		$password	= (['password']) ? hash("whirlpool", "-,+*)('&%$#\"".$data['password']."0987654321asTuVwXyZ") : $user['password'];
		$address	= ($data['address']) ? htmlentities($data['address']) : $user['address'];
		$status = ($data['status']) ? htmlentities($data['status']) : $user['status'];

		$sql = "UPDATE User SET firstname = '$firstname', lastname = '$lastname', status = '$status', email = '$email', age = '$age', password = '$password', address = '$address' WHERE id = $id";

		if (mysqli_query($db, $sql))
			return (TRUE);
		return (FALSE);
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
			if ($key == "firstname" || $key == "password")
				if (strlen($value) < 2)
					$i++;
		}
		if ($i != 0)
			return (FALSE);
		return (TRUE);
	}
