<?php

trait DbQuery
{
	private $rule_lists = ['max', 'min', 'numeric', 'required'];
	private $restricts_var_name = ['restricts_var_name', 'db', 'output', 'rule_lists'];



	function __construct()
	{
		try
		{
			$db = new Connect();
			$this->db = $db->get();
		}
		catch (Exception $e)
		{
			return (false);
		}

		return ($this);
	}

	public function all()
	{
		return ($this->output);
	}

	public function delete($id)
	{
		
		return ($this);
	}

	public function get()
	{
		return ($this->output);
	}

	public function	is_set($test)
	{
		return (strlen($test) != 0 && isset($test));
	}

	public function save()
	{
		if (!$this->validate())
			return (False);
		$vars = get_class_vars(__CLASS__);
		$restricts_vars = $this->restricts_var_name;
		$properties = [];
		foreach ($vars as $key => $value)
			if (!in_array($key, $restricts_vars))
				$properties[] = $key;
			$len = count($properties);
		if ($len < 1)
			return (true);
		$rows = implode(', ', $properties);
		$vals = ':'.implode(', :', $properties);
		$user_id		= $this->user_id;
		$nb_like		= $this->nb_like;
		$name			= htmlentities($this->name);
		$description	= htmlentities($this->description);
		$url			= htmlentities($this->url);
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
			
			header("HTTP/1.0 500 Internal Server Error");
			echo 'Exception reçue : ',  $e->getMessage(), "\n";
			exit;
		}

		return ($this);
	}

	public function take($nb = 10)
	{
		
		return ($this);
	}

	public function update()
	{
		$tmp = get_class_vars(__CLASS__);

		$r = [];
		foreach ($tmp as $key => $value)
			$r[] = $key;
		echo "update";
		$r = ':'.implode(', :', $r);
		var_dump($r);
		// return ($this);
	}

}