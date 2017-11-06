<?php

	trait Validator
	{
		private function is_validate($key, $rules)
		{
			$err = '';

			if (!$rules)
				return (true);

			if (($rules = explode('|', $rules)))
			{
				$len = count($rules);
				$value = $this->$key;

				if (in_array('required', $rules) && !$this->is_set($value))
					$err =  $key." is required <br>";
				if (!$err)
				{
					for ($i=0; $i < $len; $i++)
					{
						$this->sanitize($key, $value);
						$rule = explode(':', $rules[$i]);
						if (!$rule[0])
							continue;
						if (!in_array($rule[0], $this->rule_lists))
						{
							var_dump($rule[0]);
							var_dump($this->rule_lists);
							if (in_array('required', $rules))
								$err =  "error unknow rule ".$rule[0]."<br>";
						}
						if (!$err && in_array($rule[0], ['max', 'min']) && !$this->is_set($rule[1]))
							if (in_array('required', $rules))
								$err =  "error unknow rule value<br>";

						if (!$err && ($rule[0] == 'numeric' && !is_numeric($value)) || (in_array($rule[0], ['max', 'min']) && !is_numeric($rule[1])))
							if (in_array('required', $rules))
								$err =  $key." is not numeric <br>";
						elseif (!$err && ($rule[0] == 'max' && strlen($value) > $rule[1])
							|| ($rule[0] == 'min' && strlen($value) < $rule[1]))
							if (in_array('required', $rules))
								$err =  $key." is not in the good size <br>";
							if (!$err && $rule[0] == 'hash')
								$this->$key = $this->hash($value);
							if (!$err && $rule[0] == 'email')
								if (!filter_var($value, FILTER_VALIDATE_EMAIL))
								$err =  $value." is not an email <br>";
								;

						if ($err)
							break;						
					}
				}
				if ($err)
					echo $err;
			}
			return (strlen($err) > 0 ? false : true);
		}
		

		private function validate()
		{
			$my_vars = get_class_vars(__CLASS__);
			$rules = $this->rules();

			foreach ($my_vars as $key => $value)
				if (!in_array($key, $this->restricts_var_name))
					if ($rules && $rules[$key])
						if (!$this->is_validate($key, $rules[$key]))
							exit;
			return  (true);
		}

		private function sanitize($key, $data)
		{
			if (!isset($data))
				return (true);
			if (is_numeric($data))
				$this->$key = intval($data);
			else if (is_string($data))
				$this->$key = trim(htmlentities($data));
			return (true);
		}

		public function hash($key)
		{
			return (hash("whirlpool", "-,+*)('&%$#\"".$data."0987654321asTuVwXyZ"));
		}
	}