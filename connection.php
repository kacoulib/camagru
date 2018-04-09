<?php
if (strstr($_SERVER['REQUEST_URI'], 'connection.php')) {
    session_start();
}

require_once("./models/USERmodel.php");
require_once("./controllers/services/inputFilters.php");

if (!empty($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
    $username = $password = null;
    $authErr = null;
    $user = new USERmodel();

    if (isset($_POST['username'], $_POST['password'])) {
        $username = check_input($_POST['username']);
        $password = check_input($_POST['password']);
        if ($user->auth($username, $password) && $rows = $user->getUser($username)) {
            $status = $rows['Status'];
            if ($status) {
                $_SESSION['username'] = $username;
                header("Location: index.php");
                exit();
            } else {
                $authErr = "Please check your email to activate your account";
            }
        } else {
            $authErr = "Invalid username or password";
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
    <?php require_once("./views/html/header/meta-header-forms.html"); ?>
    <body>
        <?php require_once("./views/html/header/header-forms-account.html"); ?>
        <section class="main">
            <div class="container">
                <article id="main-column">
                    <br>
                    <form method="post" action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                        <input type="text" name="username" value="<?php echo $username ?>" placeholder="Username">
                        <br><br>

                        <input type="password" name="password" value="<?php echo $password ?>" placeholder="Password">
                        <br><br>

                        <input type="submit" name="submit" value="Log in">
                        <span class="error"><?php echo $authErr; ?></span><br><br>
                    </form>
                    <p><a href="./resetpass.php" style="text-decoration: none">Forgot password ?</a></p>
                </article>
                <aside id="main-column">
                    <div>
                        <h3>Don't have account ? <a href="./registration.php" style="text-decoration: none">Sign up</a></h3>
                    </div>
                </aside>
            </div>
        </section>
        <?php require_once('./views/html/footer/footer.html'); ?>
    </body>
</html>



