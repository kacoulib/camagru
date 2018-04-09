<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: ./index.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<?php require_once('./views/html/header/meta-header.html'); ?>
<body>
<?php require_once('./views/html/header/header-mypage.html'); ?>
<section class="main">
    <a class="linker-none" href="./logout.php" style="text-decoration: none"><i class="fa fa-power-off"></i> Logout </a>
    <div class="container">
        <article id="main-col">
            <h1 class="page-title">
                Your pictures
            </h1>
            <?php
            require_once("./models/PICmodel.php");
            $currentUserId = null;

                if (isset($_GET['id']) && !empty($_GET['id']) && ($_GET['id'] != 0)) {
                    if (is_numeric($_GET['id'])) {
                        $picture = new PICmodel();

                        $currentUserId = $picture->getUserIdByName(htmlspecialchars($_SESSION['username']));
                        $p = $picture->getPicByArtId($_GET['id']);
                        if ($p) {
                            $artID = $_GET['id'];
                            echo '<img src="' . $p['SrcPath'] . '" alt="photo"><br>';
                            echo '<a class="linker-love" href="./vote.php?id='.$_GET['id'].'" style="text-decoration: none"> Like ('.$picture->getSumLike($artID,1).') </a>';
                            if ($p['UserID'] == $currentUserId['ID']) {
                                echo " ";
                                echo '<a class="linker-del" href="./delete_p.php?id=' . $artID . '&userID=' . $p['UserID'] . '&src='. $p['SrcPath'].'" style="text-decoration: none"><i class="fa fa-trash"></i> Delete photo</a>';
                            }
                        } else {
                            header('Location: gallery.php');
                            exit();
                        }
                    }
                } else {
                    header('Location: gallery.php');
                    exit();
                }
            ?>

            <form method="post">
                <textarea name="comment" placeholder="Write a comment .."></textarea><br />
                <input type="submit" name="submit" value="Send" />
            </form>
            <?php

                if ($_SESSION['username']) {
                    if (isset($_POST['submit'])) {
                        if (isset($_POST['comment']) && !empty($_POST['comment'])) {
                            $artID = is_numeric($_GET['id']) ? $_GET['id'] : 0;
                            $comment = htmlspecialchars($_POST['comment']);
                            $by = $currentUserId;

                            if (strlen($comment) > 140) {
                                echo $error = "Max 140 characters !<br>";
                            } else {
                              if (isset($comment) && !empty($comment))
                              {
                                $picture->addCom($artID, $by['ID'], $comment);
                              }
                            }
                        }
                    }
                } else {
                    echo '<p>Please sign-in to add a comment</p>';
                }

                $coms = $picture->getCom($artID);
                foreach ($coms as $row => $com) {
                    $from = $picture->getUserById($com['UserID']);  //TROP DE REQUETE remplacer par FETCHALL
                    echo '<p class="camflow"><b>'. $from['Username'] .'</b> at '. $com['Date'] .'</p><p style="font-style: italic">&emsp;&emsp;'. utf8_decode($com['Com']) .'</p>';
                    if ($com['UserID'] == $currentUserId['ID']) {
                        echo '<a class="linker-del" href="./delete_c.php?id='. $com['ComID'] .'&userID='. $com['UserID'] .'" style="text-decoration: none"><i class="fa fa-trash-o"></i> Delete</a><br>';
                    }
                }
            ?>
        </article>
    </div>
</section>
<?php require_once('./views/html/footer/footer.html'); ?>
</body>
</html>
