<?php
session_start();
if (empty($_SESSION['username'])) {
    header("Location: ./index.php");
    exit();
}

require_once("models/USERmodel.php");
require_once("controllers/services/inputFilters.php");

$password = $newpass = "";
$passwordErr = "";
$user = new USERmodel();

if (isset($_POST['pass'], $_POST['password'])) {
    if (empty($_POST['pass']) || empty($_POST['password'])) {
        $passwordErr = "Password is required";
    } else {
        $password = check_input($_POST['pass']);
        $newpass = check_input($_POST['password']);

        if (!preg_match("#^\S*(?=\S{6,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$#", $newpass)) {
            $passwordErr = "Must contains 6 characters, with at least one uppercase, one lowercase and one digit";
        } else {
            $hash_p = hash('whirlpool', $password);
            $c_user = $user->getUser(htmlspecialchars($_SESSION['username']));
            if ($hash_p === $c_user['Password']) {
                $user->modifyPass($c_user['Username'], hash('whirlpool', $newpass));
                $passwordErr = "Password has been changed";
            } else {
                $passwordErr = "Bad current password";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<?php require_once('./views/html/header/meta-header.html'); ?>
<body>
<?php require_once('./views/html/header/header-mypage.html'); ?>
<section class="main">
    <a class="linker-none" href="./logout.php" style="text-decoration: none"><i class="fa fa-power-off"></i> Logout</a>
    <div class="container">
        <article id="main-col">
            <h1 class="page-title">Change your password</h1>
            <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
                <input type="password" name="pass" placeholder="Your password"><br><br>
                <input type="password" name="password" placeholder="Type your new password"><br><br>
                <input type="submit" name="submit">
            </form>
            <br><span class="error"><?php echo $passwordErr; ?></span><br>
        </article>
    </div>
</section>
<?php require_once('./views/html/footer/footer.html'); ?>
</body>
</html>