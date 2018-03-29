<header>
  <a href="index.php" action='get'><div class="logo"><img src="img/logo2.png" alt"logo" title="logo site"> <p>rocket<span>market</span></p></div></a>
  <div>
    <ul>
      <a href="products.php" action='get'><li>PRODUCTS</li></a>
      <?php if (!$_SESSION['logged_on_user']): ?>
        <a href="login.php" action='get'><li>SIGN IN</li></a>
        <a href="signup.php" action='get'><li>SIGN UP</li></a>
      <? endif; ?>
      <?php if ($_SESSION['logged_on_user']): ?>
        <a href="logout.php"><li>LOGOUT</li></a>
      <? endif; ?>
      <a href="cart.php"><li><img src="img/cart.png" alt"panier" title="panier"><div class="cart-count"><?php echo(count($_SESSION['card'])); ?><div></li></a>
    </ul>
  </div>
</header>
