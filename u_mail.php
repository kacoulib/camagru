<?php
session_start();
if (empty($_SESSION['username'])) {
    header("Location: ./index.php");
    exit();
}

require_once("models/USERmodel.php");
require_once("controllers/services/inputFilters.php");

$mail = $newmail = "";
$mailErr = "";
$user = new USERmodel();

if (isset($_POST['email'], $_POST['newmail'])) {
    if (empty($_POST['email']) || empty($_POST['newmail'])) {
        $mailErr = "Email is required";
    } else {
        $mail = check_input($_POST['email']);
        $newmail = check_input($_POST['newmail']);

        if (!filter_var($newmail, FILTER_VALIDATE_EMAIL)) {
            $mailErr = "Invalid format email";
        } else {
            $c_user = $user->getUser(htmlspecialchars($_SESSION['username']));
            $n_user = $user->getUserByMail($newmail);

            if ($mail === $c_user['Email']) {
                if (isset($n_user['Email']) && !empty($n_user['Email'])) {
                    $mailErr = "Email already exists !";
                } else {
                    $user->modifyMail($c_user['Username'], $newmail);
                    $mailErr = "Email has been changed";
                }
            } else {
                $mailErr = "Bad current mail";
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
            <h1 class="page-title">Change your email</h1>
            <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
                <input type="email" name="email" placeholder="Your email"><br><br>
                <input type="email" name="newmail" placeholder="Type your new mail"><br><br>
                <input type="submit" name="submit">
            </form>
            <br><span class="error"><?php echo $mailErr; ?></span><br>
        </article>
    </div>
</section>
<?php require_once('./views/html/footer/footer.html'); ?>
</body>
</html>