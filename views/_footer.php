<footer>
  <a href="index.php" action='get'><div class="logo"><img src="img/logo2.png" alt"logo" title="logo site"> <p>rocket<span>market</span></p></div></a>
  <div>
    <h2>ABOUT</h2>
    <p>About us</p>
    <p>Terms</p>
    <p>Legal</p>
  </div>
  <div>
    <h2>ACCOUNT</h2>
    <a href="login.php" action='get'><p>Sign in</p></a>
    <a href="signup.php" action='get'><p>Sign up</p></a>
    <?php if ($_SESSION['logged_on_user']): ?><a href="logout.php"><p>Logout</p></a><?php endif; ?>
  </div>
  <?php if ($user['status'] === "admin"): ?>
    <div>
      <h2>ADMIN</h2>
      <a href="users.php" action='get'><p>Manage Users</p></a>
      <a href="categories.php" action='get'><p>Manage Categories</p></a>
      <a href="admin_products.php" action='get'><p>Manage Products</p></a>
    </div>
  <? endif; ?>
</footer>
