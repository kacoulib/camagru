<?php
session_start();
if (empty($_SESSION['username'])) {
    header("Location: ./index.php");
    exit();
}

require_once("models/USERmodel.php");
require_once("controllers/services/inputFilters.php");

$user_n = $newuser_n = "";
$userErr = "";
$user = new USERmodel();

if (isset($_POST['user_n'], $_POST['newuser_n'])) {
    if (empty($_POST['user_n']) || empty($_POST['newuser_n'])) {
        $userErr = "Username is required";
    } else {
        $post_user = check_input($_POST['user_n']);
        $post_newuser = check_input($_POST['newuser_n']);

//        if (!preg_match("#^(?=.{3,})(?=.*[a-z])(?=.*[A-Z])(?=.*\W).+$#", $post_newusern)) {
        if (!preg_match("#^[A-Za-z0-9]{3,15}$#", $post_newuser)) {
            $userErr = "Must contains at least 3 characters and maximum 15 characters, only alphanumerics are allowed";
        } else {
            $c_user = $user->getUser(htmlspecialchars($_SESSION['username']));
            $p_user = $user->getUser($post_user);
            $n_user = $user->getUser($post_newuser);

            if ($p_user['Username'] === $c_user['Username']) {
                if (isset($n_user['Username']) && !empty($n_user['Username'])) {
                    $userErr = "Username already exists !";
                } else {
                    $user->modifyUsername($c_user['Username'], $post_newuser);
                    $userErr = "Username has been changed";
                }
            } else {
                $userErr = "Bad current username";
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
            <h1 class="page-title">Change your username</h1>
            <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
                <input type="text" name="user_n" placeholder="Your username"><br><br>
                <input type="text" name="newuser_n" placeholder="Type your new username"><br><br>
                <input type="submit" name="submit">
            </form>
            <br><span class="error"><?php echo $userErr; ?></span><br>
        </article>
    </div>
</section>
<?php require_once('./views/html/footer/footer.html'); ?>
</body>
</html>