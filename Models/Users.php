<?php

	require_once('TraitValidator.php');
	require_once('TraitDbQuery.php');

	class User
	{

		public	$id;
		public	$login;
		public	$email;
		public	$password;
		public	$is_confirm = 0;
		public	$confirm_id;

		use Validator;
		use DbQuery;

		private function rules()
		{
			return ([
				'id'			=> 'numeric',
				'login'			=> 'required|max:255|min:4',
				'email'			=> 'required|email|max:4',
				'password'		=> 'required|max:4|hash',
				'is_confirm'	=> 'required|numeric',
				'confirm_id'	=> 'required|min:9'
			]);
		}

		public function register(array $post)
		{
			if (count($post) < 1)
				return ($this->error('unknow user'));
			if (!is_set($_POST['login']))
				return ($this->error("login must be set"));
			elseif (!is_set($_POST['password']))
				return ($this->error("password must be set"));
			elseif (!is_set($_POST['email']))
				return ($this->error("email must be set"));
			else
			{
				if ($this->find('login', '=', $_POST['login'])->get())
					return ($this->error("login already exit"));
				else if ($this->find('email', '=', $_POST['email'])->get())
					return ($this->error("email already exit"));
				
				$tmp = $this->add([
					'login' => $_POST['login'],
					'password' => $_POST['password'],
					'email' => $_POST['email'],
					'confirm_id' => $this->generate_ramdom(30)
				])->send_mail();
			}
			$user = $this->find('email', '=', $this->email)->get();
			$_SESSION['user'] = $user;
			return ($this);
		}

		public function login(array $post)
		{
			$this->login = htmlentities($_POST['login']);
			$this->password = $this->hash($_POST['password']);
			if (!isset($this->login) || !isset($this->password))
				return (False);

			$table_name = ucfirst(get_class().'s');
	
			try
			{
				$sql = $this->db->prepare("SELECT * from $table_name WHERE login = :login AND password = :password AND confirm_id = 1");
				$sql->bindParam(':login', $this->login);
				$sql->bindParam(':password', $this->password);
				$sql->execute();
				
				$this->output = $sql->fetch();
			}
			catch (Exception $e)
			{
				$this->error('unknown user');
			}

			$user = $this->get();
			$_SESSION['user'] = $user;
			$this->user = "test";
			return ($this);
		}


		public function confirm_register($post)
		{
			if (!is_set($post['confirm_id']))
				error('error') ;

			if (!($tmp = $user->find('confirm_id', '=', htmlentities($post['confirm_id']))->get()))
				error('error') ;
			if (!$tmp || !is_set($tmp['is_confirm']) || $tmp['is_confirm'] == 1)
				error('error') ;
			$tmp['is_confirm'] = 1;
			$user->update($tmp);
			echo 'confirmed';
			return ($this);
		}

		public function logout()
		{
			session_destroy();
			return ($this);
		}


		public function generate_ramdom($length = 10)
		{
			$str = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$str_len = strlen($str);
			$ret = '';
			for ($i = 0; $i < $length; $i++)
				$ret .= $str[rand(0, $str_len - 1)];
			return $ret;
		}

		public function send_mail()
		{
			$confirm_id = $this->confirm_id;
			if (!$this->is_set($confirm_id))
				return ($this->showError(""));
			$message = "
			<html>
				<head>
					<title>Camagru confirmation</title>
				</head>
				<body>
					<a href='http://localhost:8080/camagru/?action=confirm_inscription&confirm_id=".$this->confirm_id."'>Confirmer inscription!</a>
				</body>
			</html>";
			$headers[] = 'MIME-Version: 1.0';
			$headers[] = 'Content-type: text/html; charset=iso-8859-1';
			mail($_POST['email'], 'Camagru inscription', $message, implode("\r\n", $headers));
			echo 'email send ';
			return ($this);
		}
	}