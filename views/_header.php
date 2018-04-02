<header>
  <a href="index.php"><div class="logo"><img src="img/logo2.png" alt"logo" title="logo site"> <p><span>Camagru</span></p></div></a>
  <div>
    <ul>

      <?php if ($_SESSION['logged_on_user']): ?>
        <a href='products.php'><li>Make up</li></a>
        <a href='logout.php'><li>LOGOUT</li></a>
        <a href="cart.php">
          <li>
            <img src="Public/img/settings.png" alt"panier" title="panier">
            <div class="cart-count"><?php echo(count($_SESSION['card'])); ?><div>
            </li>
          </a>
      <?php else: ?>
        <a href='login.php'><li>SIGN IN</li></a>
        <a href='signup.php'><li>SIGN UP</li></a>
      <?php endif;?>
    </ul>
  </div>
</header>
<?php
var_dump($_SESSION);
  if (isset($_SESSION['error']))
  {
    echo '<div class="msg error">'.$_SESSION['error'].'</div>';
    unset($_SESSION['error']);
  }else if (isset($_SESSION['message']))
  {
      echo '<div class="msg">'.$_SESSION['message'].'</div>';
      unset($_SESSION['message']);
  }

?>
