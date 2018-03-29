<?php
	session_start();
	// create
	function create_category(array $data)
    {
        if (!check_category_data($data))
            return (FALSE);
        if (!($db = get_connection()))
            return (FALSE);
        $name    = htmlentities($data['name']);
        $description    = htmlentities($data['description']);
        $sql = "INSERT INTO Category (name, description) VALUES ('$name', '$description')";
        if (mysqli_query($db, $sql))
            return (TRUE);
        return (FALSE);
    }

	// read
	function get_all_categories_order_by($order)
	{
		if (!($db = get_connection()))
			return (FALSE);
		$order	= htmlentities($order);
		$sql = "SELECT * FROM Category ORDER BY $order DESC";
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
	function get_category_by_id($id)
	{
		if (!is_int($id))
			return (FALSE);
		$id = intval($id);
		if (!($db = get_connection()))
			return (FALSE);
		$sql = "SELECT * FROM Category WHERE id = $id";
		$result = mysqli_query($db, $sql);
		if ($result->num_rows > 0)
		{
			$new = [];
			while($row = mysqli_fetch_assoc($result))
				$new[] = $row;
			return ($new);
		}
		else
			return (FALSE);
		return (TRUE);
	}

	// read all
	function get_all_categories()
	{
		if (!($db = get_connection()))
			return (FALSE);
		$sql = "SELECT * FROM Category";
		$result = mysqli_query($db, $sql);
		if ($result->num_rows > 0)
		{
			$new = [];
			while($row = mysqli_fetch_assoc($result))
				$new[] = $row;
			return ($new);
		}
		else
			return (FALSE);
		return (TRUE);
	}

	// update
	function update_category(array $data)
	{
		if (!check_category_data($data))
			return (FALSE);
		if (!is_int($data['id']))
			return (FALSE);
		if (!($db = get_connection()))
			return (FALSE);
		$id = $data['id'];
		$category = get_category_by_id($id);
		if ($category)
		{
			$name	= htmlentities($data['name']);
			$sql = "UPDATE Category SET name = '$name', description = '$description' WHERE id = '$id'";

			if (mysqli_query($db, $sql))
				return (TRUE);
		}
		return (FALSE);
	}

	// delete
	function delete_category($id)
	{
		if (!is_int($id))
			return (FALSE);
		if (!($db = get_connection()))
			return (FALSE);
		$sql = "DELETE FROM Category WHERE id = $id";
		mysqli_query($db, "SET FOREIGN_KEY_CHECKS=0;");
		if (mysqli_query($db, $sql)){
			mysqli_query($db, "SET FOREIGN_KEY_CHECKS=1;");
			return (TRUE);
		}
		mysqli_query($db, "SET FOREIGN_KEY_CHECKS=1;");
		return (FALSE);
	}

	function check_category_data(array $data)
	{
		// check if all params arr ok
		$i = 0;
		foreach ($data as $key => $value)
		{
			if ($key == "name")
			{
				if (!is_set($value))
					return (FALSE);
				$i++;
			}
		}
		if ($i != 1)
			return (FALSE);
		return (TRUE);
	}
