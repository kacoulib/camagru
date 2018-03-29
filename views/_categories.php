<div id="admin_curd" class="admin-curd">
	<h1>Manage Categories</h1>
	<h2>Create</h2>
	<div class="admin-ttl"><div>Name</div><div>Description</div></div>
	<form action="category_crud.php" method="POST">
		<div><input type="text" name="name" class="admin-field"></div>
    <div><textarea name="description"></textarea></div>
		<div><input type="hidden" name="action"></div>
		<div><input type="hidden" name="action" value="cre"></div>
		<button>submit</button>
	</form>

	<?php
  if ($categories)
  {
    $txt = '<h2>Update</h2>';
    $txt .= '<div class="admin-ttl"><div>Name</div><div>Description</div></div>';

    foreach ($categories as $key => $category)
    {
      $txt .= '<form action="category_crud.php" method="POST">';
        $txt .= '<div><input type="text" name="name" value="'.$category['name'].'" class="admin-field"></div>';
        $txt .= '<div><textarea name="description" value="'.$category['description'].'"></textarea></div>';
        $txt .= '<div><input type="hidden" name="category_id" value="'.$category['id'].'"></div>';
        $txt .= '<div><input type="hidden" id="action_'.$key.'" name="action" value="update"></div>';
        $txt .= '<button id="upd" class="category_btn" data-action="action_'.$key.'">update</button>';
        $txt .= '<button id="del" class="category_btn" data-action="action_'.$key.'">delete</button>';
      $txt .= '</form>';
    }
    echo $txt;
  }
?>
</div>
<script>
(function ()
{
  var btn = document.getElementsByClassName('category_btn'), tmp;

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
