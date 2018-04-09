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
    <a class="linker-none" href="./logout.php" style="text-decoration: none"><i class="fa fa-power-off"></i> Logout </a><br>
    <a class="linker-none" href="./settings.php" style="text-decoration: none"><i class="fa fa-cog"></i> Settings</a>
    <div class="container">
        <article id="main-column">
            <h1 class="page-title">
                Your pictures
            </h1>
            <?php
            require_once('./models/PICmodel.php');
            $pictures = new PICmodel();

                if (isset($_SESSION['username'])) {
                    $userID = $pictures->getUserIdByName($_SESSION['username']);

                    if (isset($_GET['page'])) {
                        $pictures->getPages($_GET['page'], $userID[0]);
                    } else {
                        $pictures->getPages(1, $userID[0]);
                    }

                    $src = $pictures->getPictures($userID[0]);
                    if (!empty($src)) {
                        foreach ($src as $rows => $data) {

                            echo "<div class=\"responsive\">";
                                echo "<div class=\"gallery\">";
                                    echo '<a href="./p.php?id='. $data['ArticleID'] .'"><img id="test" src="'. $data['SrcPath'] .'" alt="Masterpiece" width="480" height="320"></a> ';
                                    echo "<div class=\"desc\">";
                                    echo $data['Date'];
                                    echo "</div>";
                                echo "</div>";
                            echo "</div>";

//                            echo '<a href="./p.php?id='. $data['ArticleID'] .'"><img src="'. $data['SrcPath'] .'" alt="Personal masterpiece"></a> ';
                        }
                    } else {
                        echo '<p>No photo</p>';
                    }
                }
            ?>
        </article>
    </div>
    <?php echo '<div class="pagination">'.$pictures->pagination.'</div>'; ?>
</section>
<?php require_once('./views/html/footer/footer.html'); ?>
</body>
</html>