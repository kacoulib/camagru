<?php
require_once("models/USERmodel.php");
require_once("controllers/services/inputFilters.php");

if (!isset($_GET['mail'], $_GET['tok'])) {
    header("Location: ./index.php");
    exit("Bad arguments");
}
    $pass = $password = "";
    $passwordErr = "";
    $email = $_GET['mail'];
    $tok = $_GET['tok'];
    $user = new USERmodel();

    if (isset($_POST['pass'], $_POST['password'])) {
        if (empty($_POST['pass']) || empty($_POST['password'])) {
            $passwordErr = "Password is required";
        } else {
            $pass = check_input($_POST['pass']);
            $password = check_input($_POST['password']);

            if (!preg_match("#^\S*(?=\S{6,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$#", $password)) {
                $passwordErr = "Must contains 6 characters, with at least one uppercase, one lowercase and one digit";
            } else {
                if ($pass === $password) {
                    $password = hash('whirlpool', $password);
                    $user->setNewPass(urldecode(check_input($_GET['mail'])), urldecode(check_input($_GET['tok'])), $password);
                } else {
                    $passwordErr = "Password doesn't match";
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <?php require_once('./views/html/header/meta-header-forms.html'); ?>
    <body>
        <?php require_once('./views/html/header/header-forms-account.html'); ?>
        <section class="main">
            <div class="container">
                <div id="main-column">
                    <p>Reset your password</p>
                    <form action="./royalpass.php?mail=<?php echo $email.'&tok='.$tok ;?>" method="post">
                        <input type="password" name="pass" placeholder="Password">
                        <span class="error">* <?php echo $passwordErr; ?></span><br><br>

                        <input type="password" name="password" placeholder="Type password again">
                        <span class="error">* <?php echo $passwordErr; ?></span><br><br>

                        <input type="submit" name="submit">
                    </form>
                </div>
            </div>
        </section>
        <?php require_once('./views/html/footer/footer.html'); ?>
    </body>
</html>