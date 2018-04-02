<div class="cart-cntnr">
	<?php if ($_SESSION['card']): ?>
		<img src="img/shop2.png"/>
	<?php endif; ?>
	<?php if (!$_SESSION['card']): ?>
		<img src="img/crying.png"/>
	<?php endif; ?>
	<h1>Your cart <?php if (!$_SESSION['card']): ?>is empty...<?php endif; ?></h1>
	<?php
		$cards = $_SESSION['card'];
		if ($cards)
		{
			$txt = '';
			$i = 0;
			foreach ($cards as $key => $value)
			{

				foreach ($value as $key2 => $product)
				{
					$txt .= '<form action="card_crud.php" method="POST">';
					$txt .= '<span><p class="p-name-img"><img src="'.$product['image'].'"/></p></span>';
					$txt .= '<span><p class="p-name">'.$product['category_name'].'</p></span>';
					$txt .= '<span><p class="p-name">'.$product['price'].'$</p></span>';
					$txt .= '<span><input type="number" name="quantity" class="quantity" min="1" value="'.$_SESSION['quantity'][$product['id']].'"</p></span>';
					$txt .= '<span><input type="hidden" name="category_name" value="'.$product['category_name'].'"></span>';
					$txt .= '<span><input type="hidden" name="price" value="'.$product['price'].'"></span>';
					$txt .= '<span><input type="hidden" name="product_id" value="'.$product['id'].'"></span>';
					$txt .= '<span><input type="hidden" name="category_id" value="'.$product['id'].'"></span>';
					$txt .= '<span><input type="hidden" id="action_'.$i.'" name="action" value="upd"></span>';
					$txt .= '<button id="upd" class="product_btn" data-action="action_'.$i.'"><img src="img/update.png"/></button>';
					$txt .= '<button id="del" class="product_btn" data-action="action_'.$i.'"><img src="img/delete.png"/></button>';
					$txt .= '</form>';
					$i++;
				}
			}
			echo $txt;
		}
	?>
	<div class="validate-cart">

		<?php if ($_SESSION['logged_on_user']): ?>
				<form action="card_crud.php" method="POST">
					<label for="login">Login</label>
					<input type="text" name="login" id="login" value=<?php echo $user['login']?> autofocus/>
					<br>

					<label for="password">Password</label>
					<input type="password" name="password" id="password" />
					<br>

					<label for="email">Email</label>
					<input type="email" name="email" id="email" value=<?php echo $user['email']?> />
					<br>

					<label for="send_notif">Notification</label>
					<input type="checkbox" name="send_notif" id="send_notif" <?php echo $user['send_notif'] == '1' ? 'checked' : ''?> />
					<br>
					<input type=hidden name="action" value='update_user' />
					<button class="btn" data-action="action_0">VALIDATE CART</button>
				</form>
		<?php endif; ?>
	</div>
</div>
<script>
	(function ()
	{
		var btn = document.getElementsByClassName('product_btn'), tmp;

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
