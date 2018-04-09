<?php
session_start();
require_once('./models/PICmodel.php');
//Cette requête sera utilisée plus tard
//$sql = "SELECT id, title, content, DATE_FORMAT(pub_date,'%d/%m/%Y à %Hh%imin%ss') as date FROM articles ORDER BY id DESC $limit";
?>

<!DOCTYPE html>
<html lang="en">
    <?php require_once('./views/html/header/meta-header.html'); ?>
    <body>
    <?php
        if (isset($_SESSION['username'])) {
            require_once('./views/html/header/header-gallery.html');
            echo '<a class="linker-none" href="./logout.php" style="text-decoration: none"><i class="fa fa-power-off"></i> Logout </a>';
        } else
            require_once('./views/html/header/header-forms-account.html');
    ?>
        <section class="main">
            <div class="container">
                <article id="main-column">
                    <h1 class="page-title">
                        All pictures
                    </h1>
                    <?php
                    require_once('./models/PICmodel.php');
                    $pictures = new PICmodel();

                        if (isset($_GET['page'])) {
                            $pictures->getPages($_GET['page'], false);
                        } else {
                            $pictures->getPages(1, false);
                        }
                        $src = $pictures->getPictures(false);

                        if (!empty($src)) {
                            foreach ($src as $rows => $data) {
                                echo "<div class=\"responsive\">";
                                    echo "<div class=\"gallery\">";
                                        echo '<a href="./p.php?id='. $data['ArticleID'] .'"><img id="test" src="'. $data['SrcPath'] .'" alt="Masterpiece" width="480" height="320"></a> ';
                                        echo "<div class=\"desc\">";
                                        echo "From user ".$data['UserID'];
                                        echo "</div>";
                                    echo "</div>";
                                echo "</div>";
                            }
                        } else {
                            echo '<p>No photo</p>';
                        }
                    ?>
                </article>
            </div>
            <?php echo '<div class="pagination">'.$pictures->pagination.'</div>'; ?>
        </section>
        <?php require_once('./views/html/footer/footer.html'); ?>
    </body>
</html>