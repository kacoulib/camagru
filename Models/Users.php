<?php

	require_once('./index.php');
	require_once('TraitValidator.php');
	require_once('TraitDbQuery.php');
	class User
	{

		public	$id;
		public	$login;
		public	$email;
		public	$password;
		public	$is_confirm;
		public	$confirm_id;


		private	$output = false;

		private $db;

		use Validator;
		use DbQuery;

		public function rules()
		{
			return ([
				'id'			=> 'numeric',
				'name'			=> 'required|max:255|min:3',
				'user_id'		=> 'required|numeric|max:3',
				'url'			=> 'required',
				'is_confirm'	=> 'required|numeric'
			]);
		}

		// public function save()
		// {
		// 	if (!$this->is_valid())
		// 		return (False);
		// 	if (!isset($this->email) || !isset($this->login) || !isset($this->password))
		// 		return (False);
		// 	if (!filter_var($this->email, FILTER_VALIDATE_EMAIL))
		// 		return (False);

		// 	$email = htmlentities($this->email);
		// 	$login = htmlentities($this->login);
		// 	$password = hash("whirlpool", "-,+*)('&%$#\"".$this->password."0987654321asTuVwXyZ");
		// 	$confirm_id = htmlentities($this->confirm_id);

		// 	$sql = $this->db->prepare('INSERT INTO Users (email, login, password, confirm_id) VALUE (:email, :login, :password, :confirm_id)');
		// 	$sql->bindParam(':email', $email, PDO::PARAM_STR);
		// 	$sql->bindParam(':login', $login, PDO::PARAM_STR);
		// 	$sql->bindParam(':password', $password, PDO::PARAM_STR);
		// 	$sql->bindParam(':confirm_id', $confirm_id, PDO::PARAM_STR);
		// 	$sql->execute();
		// 	return (true);
		// }

		public function login()
		{

			$this->user = "test";
		}

		public function logout()
		{
			
		}

		public function set_user(array $data)
		{
			$this->user = $data;
		}

		public function get_user()
		{
			if (isset($this->user))
				return ($this->user);
			return (False);
		}

	}