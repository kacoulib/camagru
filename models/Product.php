<?php

	if (!isset($_SESSION))
		session_start();

	// create
	function create_product(array $data)
	{
		if (!check_product_data($data))
			return (FALSE);
		if (!($db = get_connection()))
			return (FALSE);


		$sql = $db->prepare("INSERT INTO Images (user_id, nb_like, url) VALUES (:user_id, :nb_like, :url)");
		$sql->bindParam(':user_id', $data['user_id']);
		$sql->bindParam(':nb_like', 0);
		$sql->bindParam(':url', $data['url']);
		$sql->execute();

		$_SESSION['message'] = 'Image created';
		return (true);
	}

	function store_base_64($img, $path = 'Public/img/img00.png')
	{
		$t = imagecreatefrompng($img);
		imagealphablending($t, true);
		imagesavealpha($t, true);

		// $path = 'images/image.png';
		imagepng($t, $path);
		imagedestroy($t);
	}
	// read
	function get_all_products_order_by($order)
	{
		if (!($db = get_connection()))
			return (FALSE);
		$order	= htmlentities($order);
		$sql = "SELECT * FROM Product ORDER BY $order DESC";
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
	function get_product_by_id($id)
	{
		if (!is_int($id))
			return (FALSE);
		$id = intval($id);
		if (!($db = get_connection()))
			return (FALSE);
		$sql = "SELECT * FROM Product WHERE id = $id";
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

    function get_all_products()
    {
        if (!($db = get_connection()))
			return (FALSE);
		$sql = "SELECT * FROM Product";
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
	function update_product(array $data)
	{
		if (!check_product_data($data))
			return (FALSE);
		if (!is_int($data['id']))
			return (FALSE);
		if (!($db = get_connection()))
			return (FALSE);
		$id = $data['id'];
		$product = get_product_by_id($id);
		if ($product)
		{
			$name	= htmlentities($data['category_name']);
			$category_id	= $data['category_id'];
			$image	= htmlentities($data['image']);
			$description	= htmlentities($data['description']);
			$price	= $data['price'];
			$sql = "UPDATE Product SET category_name = '$name', category_id = '$category_id', image = '$image', description = '$description', price = '$price' WHERE id = '$id'";

			if (mysqli_query($db, $sql))
				return (TRUE);
		}
		return (FALSE);
	}

	// delete
	function delete_product($id)
	{
		if (!is_int($id))
			return (FALSE);
		if (!($db = get_connection()))
			return (FALSE);
		$sql = "DELETE FROM Product WHERE id = $id";
		mysqli_query($db, "SET FOREIGN_KEY_CHECKS=0;");
		if (mysqli_query($db, $sql)){
			mysqli_query($db, "SET FOREIGN_KEY_CHECKS=1;");
			return (TRUE);
		}
		mysqli_query($db, "SET FOREIGN_KEY_CHECKS=1;");
		return (FALSE);
	}

	function check_product_data(array $data)
	{
		// check if all params arr ok
		$i = 0;
		foreach ($data as $key => $value)
		{
			if ($key == "category_name")
			{
				if (!is_set($value))
					return (FALSE);
				$i++;
			}
			if ($key == "price")
				if (!is_int($value))
					return (FALSE);
		}
		if ($i != 1)
			return (FALSE);
		return (TRUE);
	}
