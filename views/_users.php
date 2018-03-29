<div id="admin_curd" class="admin-curd">
	<h1>Manage Users</h1>
	<h2>Create</h2>
	<div class="admin-ttl"><div>Login</div><div>Admin</div><div>visitor</div><div>Password</div></div>
	<form action="user_crud.php" method="POST">
		<div><input type="text" name="firstname" class="admin-field"></div>
		<div><input type="radio" name="status" value="admin"></div>
		<div><input type="radio" name="status" value="visitor"></div>
		<div><input type="password" name="password" class="admin-field"></div>
		<div><input type="hidden" name="action"></div>
		<div><input type="hidden" name="action" value="cre"></div>
		<button>submit</button>
	</form>

	<?php
		if ($users)
		{
			$txt = '<h2>Update</h2>';
			$txt .= '<div class="admin-ttl"><div>Login</div><div>Admin</div><div>visitor</div><div>Password</div></div>';

			foreach ($users as $key => $user)
			{

				$txt .= '<form action="user_crud.php" method="POST">';
					$txt .= '<div><input type="text" name="firstname" value="'.$user['firstname'].'" class="admin-field"></div>';
					$txt .= '<div><input type="radio" name="status" value="admin"></div>';
					$txt .= '<div><input type="radio" name="status" value="visitor"></div>';
					$txt .= '<div><input type="password" name="password" class="admin-field"></div>';
					$txt .= '<div><input type="hidden" name="user_id" value="'.$user['id'].'"></div>';
					$txt .= '<div><input type="hidden" id="action_'.$key.'" name="action" value="update"></div>';
					$txt .= '<button id="upd" class="user_btn" data-action="action_'.$key.'">update</button>';
					$txt .= '<button id="del" class="user_btn" data-action="action_'.$key.'">delete</button>';
				$txt .= '</form>';
			}
			echo $txt;
		}
	?>
</div>
<script>
	(function ()
	{
		var btn = document.getElementsByClassName('user_btn'), tmp;

		for (var i = 0; i < btn.length; i++)
		{
			(function (elem)
			{

				elem.addEventListener('click', function (e)
				{
					e.preventDefault();

					tmp = elem.dataset.action;
					if (elem.id == "upd" || elem.id == "del")
					{
						if (elem.id == "upd")
							document.getElementById(tmp).value = "upd";
						else if (elem.id == "del")
							document.getElementById(tmp).value = "del";
						elem.parentElement.submit();
					}
				})
			})(btn[i])
		}

	})()
</script>
