<?php
session_start();
if (!empty($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
require_once("./models/FILTERmodel.php");

    $email = "";
    $emailErr = "";
    $arrayEmail = null;
    $filters = new FILTERmodel();

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $arrayEmail = $filters->emailFilter($_POST['email'], 1);
        $email = $arrayEmail[0];
        $emailErr = $arrayEmail[2];
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
                <p>
                    We can help you reset your password using your Camagru email linked to your account
                </p>
                <form method="post" action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                    <input type="text" name="email" value="<?php echo $email; ?>" placeholder="Email">
                    <span class="error">* <?php echo $emailErr; ?></span><br><br>

                    <input type="submit" name="submit" value="Reset Password">
                </form>
            </article>
        </div>
    </section>
    <?php require_once('./views/html/footer/footer.html'); ?>
    </body>
</html>