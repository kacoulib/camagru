<div class="banner">
  </br></br></br></br>
  <h1>Your Rocket Market</h1>
  <h2>Select your favorite rockets</h2>
</div>
<div class="sort">
	<ul>
		<a href="?sort_by=price"><li>price</li></a>
		<a href="?sort_by=name"><li>name</li></a>
    <a href="?sort_by=category_id"><li>category</li></a>
	</ul>
</div>
<div class="product-cntnr">
  <?php foreach($products as $p): ?>
    <div class='product'>
      <div class="img-cntnr">
        <img src=<?php echo $p['image']; ?> />
      </div>
      <div class="txt-cntnr">
        <h3><?php echo strtoupper($p['name']); ?></h3>
        <p><?php echo $p['description']; ?></p>
        <form action="card_crud.php" method="POST">
          <div class="btn-cntnr">
          <input type="hidden" name='product_id' value="<?php echo $p['id'];?>">
          <input type="hidden" name='action' value="add">
            <button class="add-to-cart">ADD TO CART</button>
          </div>
        </form>
      </div>
    </div>
  <?php endforeach; ?>
</div>
