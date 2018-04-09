<?php
session_start();
if (isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
    <?php require_once("./views/html/header/meta-header-forms.html"); ?>
    <body>
        <?php require_once("./views/html/header/header-forms-account.html"); ?>
        <?php require_once("./controllers/services/fieldsFilters.php"); ?>
        <section class="main">
            <div class="container" style="align-content: center">
                <article id="main-column">
                    <h1 class="page-title">
                        Sign-up to see pictures of your friends.
                    </h1>
                    <form method="POST" action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                        <input type="text" name="username" value="<?php echo $username; ?>" placeholder="Username">
                        <span class="error">* <?php echo $usernameErr; ?></span><br><br>

                        <input type="email" name="email" value="<?php echo $email; ?>" placeholder="Email">
                        <span class="error">* <?php echo $emailErr; ?></span><br><br>

                        <input type="password" name="password" value="<?php echo $password; ?>" placeholder="Password">
                        <span class="error">* <?php echo $passwordErr; ?></span><br><br>

                        <input type="submit" name="submit" value="Create Account">
                    </form>
                </article>
                <aside id="main-column">
                    <div>
                        <h3>Have an account ? <a href="./connection.php" style="text-decoration: none">Log in</a></h3>
                    </div>
                </aside>
            </div>
        </section>
        <?php require_once('./views/html/footer/footer.html'); ?>
    </body>
</html>
