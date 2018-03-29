<?php if ($user['status'] === "admin"): ?>
  <div class="admin">
  <div id="admin_curd" class="admin_curd">
    <h1>Manage products</h1>
  	<h2>Create</h2>
  	<div class="admin-ttl"><div>Name</div> <div>Price</div> <div>Category</div> <div>Description</div></div>
  	<form action="product_crud.php" method="POST">
  		<div><input type="text" name="category_name"></div>
  		<div><input type="number" name="price"></div>
      <div><select name="category_id"><option value="1" selected="selected">Ariane</option><option value="2">Long March</option><option value="3">Kosmos</option><option value="4">Big big Rocket</option></select></div>
  		<div><textarea name="description"></textarea></div>
  		<button>submit</button>
      <div><input type="hidden" name="action" value="cre"></div>
  	</form>
  	<?php
  		if ($products)
  		{
  			$txt = '<h2>Update</h2>';
  			$txt .= '<div class="admin-ttl"><div>Name</div> <div>Price</div> <div>Description</div></div>';
  			foreach ($products as $key => $product)
  			{
  				$txt .= '<form action="product_crud.php" method="POST">';
  					$txt .= '<div><input type="text" name="category_name" value="'.$product['category_name'].'"></div>';
  					$txt .= '<div><input type="number" name="price" value="'.$product['price'].'"></div>';
  					$txt .= '<div><select name="category_id"><option value="1" selected="selected">Ariane</option><option value="2">Long March</option><option value="3">Kosmos</option><option value="4">Big big Rocket</option></select></div>';
  					$txt .= '<div><textarea name="description">'.$product['description'].'</textarea></div>';
  					$txt .= '<button id="upd" class="product_btn" data-action="action_'.$key.'">update</button>';
  					$txt .= '<button id="del" class="product_btn" data-action="action_'.$key.'">delete</button>';
            $txt .= '<div><input type="hidden" name="image" value="'.$product['image'].'"></div>';
            $txt .= '<div><input type="hidden" name="product_id" value="'.$product['id'].'"></div>';
            $txt .= '<div><input type="hidden" id="action_'.$key.'" name="action" value="update"></div>';
  				$txt .= '</form>';
  			}
  			echo $txt;
  		}
  	?>
  </div>
  </div>
<? endif; ?>
<script>
	(function ()
	{
		var btn = document.getElementsByClassName('product_btn'), tmp;

		for (var i = 0; i < btn.length; i++)
		{
			// elem = btn[i];
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
