<?php

require_once('./index.php');

trait DbQuery
{
	private	$output = '';
	private $db;


	private $rule_lists = ['max', 'min', 'numeric', 'required', 'email', 'hash'];
	private $restricts_var_name = ['restricts_var_name', 'db', 'output', 'rule_lists'];



	function __construct()
	{
		try
		{
			// New db
			$db = new Connect();
			$this->db = $db->get();
		}
		catch (Exception $e)
		{
			exit;
		}

		return ($this);
	}

	public function add(array $data)
	{
		if (!$this->field_data($data))
			return (False);
		if (!$this->validate())
			return (False);
		$vars = get_class_vars(__CLASS__);
		$restricts_vars = $this->restricts_var_name;
		$properties = [];
		$user = [];
		foreach ($vars as $key => $value)
		{
			if (!in_array($key, $restricts_vars))
			{
				$properties[] = $key;
				$user[$key] = $this->$key;
			}
		}
		$len = count($properties);
		if ($len < 1)
			return (true);
		$rows = implode(', ', $properties);
		$vals = ':'.implode(', :', $properties);
		$table_name = ucfirst(get_class().'s');
		try
		{
			$sql = $this->db->prepare("INSERT INTO $table_name ($rows) VALUE ($vals)");
			for ($i=0; $i < $len; $i++)
				$sql->bindParam(':'.$properties[$i], $this->{$properties[$i]});

			$sql->execute();
		}
		catch (Exception $e)
		{
			$this->error($e->getMessage());
		}
		$this->output = $user;
		return ($this);
	}

	public function delete($post)
	{
		if ((!isset($post['id']) && !is_numeric($post['id'])) || ($id = int($post['id'])) < 1)
			return (error("delete unvalid user"));
		try
		{
			$sql = $this->db->prepare("DELETE FROM $table_name WHERE id = $id");
			for ($i=0; $i < $len; $i++)
				$sql->bindParam(':'.$properties[$i], $this->{$properties[$i]});

			$sql->execute();
		}
		catch (Exception $e)
		{
			$this->error($e->getMessage());
		}
		$this->output = false;
		return ($this);
	}
	
	public function find($colums, $operator, $name)
	{
		if (!$this->is_set($colums) || !$this->is_set($operator) || !$this->is_set($name))
			return ($this->error('error'));
		if (!in_array($operator, ['<', '>', '=', 'like']))
			return ($this->error('error'));
		$colums = trim(htmlentities($colums));
		$name = trim(htmlentities($name));
		$table_name = ucfirst(get_class().'s');
		try
		{
			$sql = $this->db->prepare("SELECT * from $table_name WHERE $colums $operator :name");
			$sql->execute([':name' => $name]);
			$this->output = $sql->fetch();
		}
		catch (Exception $e)
		{
			$this->error('unknown user');
		}
		return ($this);
	}

	public function get()
	{
		return ($this->output);
	}

	private function	is_set($test)
	{
		return (strlen($test) != 0 && isset($test));
	}

	public function update(array $data)
	{
		if (!$this->field_data($data))
			return (False);
		if (!$this->validate($data))
			return (False);

		$vars = get_class_vars(__CLASS__);
		$restricts_vars = $this->restricts_var_name;
		$properties = [];
		$query = '';
		foreach ($vars as $key => $value)
		{
			if (!in_array($key, $restricts_vars) && $key != 'id')
			{
				$properties[] = $key;
				$query .= $key.'= :'.$key.', ';
			}
		}
		$len = count($properties);
		if ($len < 1)
			return (true);
		$query = substr($query, 0, -2);
		$query .= ' WHERE id = '.$this->id;
		$table_name = ucfirst(get_class().'s');

		try
		{
			$sql = $this->db->prepare("UPDATE $table_name SET $query");
			for ($i=0; $i < $len; $i++)
				$sql->bindParam(':'.$properties[$i], $this->{$properties[$i]});

			$sql->execute();
		}
		catch (Exception $e)
		{
			$this->error($e->getMessage());
		}

		return ($this);
	}

	public function take($nb = 10)
	{
		
		return ($this);
	}

	private function field_data(array $data)
	{
		$vars = get_class_vars(__CLASS__);
		$restricts_vars = $this->restricts_var_name;
		$properties = [];
		$has_one_set = 0;
		foreach ($data as $key => $value)
		{
			if (!in_array($key, $restricts_vars))
			{
				$this->$key = $value;
				$has_one_set = 1;
			}
		}
		return ($has_one_set);
	}

	private function error($err)
	{
		echo $err;
		exit;
	}

}