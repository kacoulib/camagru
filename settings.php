<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: ./index.php');
    exit();
}
require_once ("./models/USERmodel.php");
$user = new USERmodel();

$row = $user->getUser(htmlspecialchars($_SESSION['username']));
$notif = ($row['Smail'] == 1) ? 'TRUE':'FALSE';
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
            <p>Change your:</p>
            <ul>
                <li><a class="linker-none" href="u_mail.php" style="text-decoration: none"><i class="fa fa-envelope"></i> Mail</a></li>
                <li><a class="linker-none" href="u_user.php" style="text-decoration: none"><i class="fa fa-user-circle-o"></i> Username</a></li>
                <li><a class="linker-none" href="u_pass.php" style="text-decoration: none"><i class="fa fa-key"></i> Password</a></li>
            </ul>
            <br><br>
            <?php
                if ($notif === 'TRUE') {
                    echo '<strong>Notification </strong><a id="notif" href="./notification.php"><i class="fa fa-toggle-on" aria-hidden="true"></i></a>';
                } else {
                    echo '<strong>Notification </strong><a id="notif" href="./notification.php"><i class="fa fa-toggle-off" aria-hidden="true"></i></a>';
                }
            ?>
<!--            --><?php //echo $notif ?>
<!--            Receive mail when an user comments your picture : <a href="./notification.php">--><?php //echo $notif ?><!--</a>-->
        </article>
    </div>
</section>
<?php require_once('./views/html/footer/footer.html'); ?>
</body>
</html>
