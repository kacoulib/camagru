<?php
    if (empty($_SESSION['username'])) {
        header("Location: index.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
    <?php require_once('./views/html/header/meta-header.html'); ?>
    <body>
        <?php require_once('./views/html/header/header-index.html'); ?>
        <section class="main">
            <?php
            if (!isset($_SESSION['username'])) {
                echo "<p id=\"err_session\">You have to be signed to take any photos</p>";
            } else {
                echo '<a class="linker-none" href="./logout.php" style="text-decoration: none"><i class="fa fa-power-off"></i> Logout </a>';
            }
            ?>
            <div class="container">
                <article id="main-col">
                    <h1 class="page-title"> Let's take a selfie</h1>
                    <div class="camflow">
                        <video id="video"></video>
                    </div>
                    <div id="formup">
                        <form id="uploadForm" enctype="multipart/form-data" action="uploadtool.php" target="uploadFrame" method="post">
                            <input id="uploadFile" name="uploadFile" type="file" onchange="upload_on()"/>
                            <input id="upfilter" name="upfilter" type="number" value="0" hidden>
                            <input id="uploadSubmit" name="upsubmit" type="submit" value="Upload !" disabled="disabled"/>
                        </form>
                    </div>
                    <div id="uploadInfos">
                        <p id="uploadStatus"></p>
                        <iframe id="uploadFrame" name="uploadFrame" frameborder="0" hidden></iframe>
                    </div>
                    <script type="text/javascript" src="views/javascript/upload.js"></script>
                    <script>
                        function uploadEnd(error, path) {
                            document.getElementById('uploadStatus').innerHTML = (error === 'OK') ? '<img id="uploaded" src="' + path + '" alt="file upload" onload="upload_merge()"/>' : error;
                        }

                        document.getElementById('uploadForm').addEventListener('submit', function() {
                            document.getElementById('uploadStatus').innerHTML = 'Loading...';
                        });
                    </script>
                    <p>Select a starter for your snap</p>
                    <select title="Select your starter" id="filters" onchange="selectedOption()"">
                        <option value="0">Select a starter</option>
                        <option value="1">Bulbizard</option>
                        <option value="2">Salameche</option>
                        <option value="3">Carapuce</option>
                        <option value="4">Pikachu</option>
                    </select>
                    <?php
                        if (!isset($_SESSION['username'])) {
                            echo "<p id=\"err_session\">You have to be signed to take any photos</p>";
                        } else {
                            echo "<button id=\"snapshot\" disabled=\"disabled\">Click</button>";
                        }
                    ?>
                    <p id="demo"></p>
                    <script type="text/javascript">
                        function selectedOption() {
                            var video = document.querySelector('#video');
                            var upfile = document.querySelector('#uploadFile');
                            var x = document.getElementById("filters").value;
                            var upfilter = document.getElementById("upfilter");
                            var up_sub = document.getElementById("uploadSubmit");
                            var click = document.getElementById("snapshot");

                            if (video.paused && upfile.value) {
                                up_sub.disabled = !(x > 0);
                                upfilter.value = x;
                            }
                            else if (video.currentTime && click !== null) {
                                click.disabled = !(x > 0);
//                                upfilter.value = x;
                            }
                        }
                    </script>
                </article>
                <aside id="sidebar">
                        <h3><i class="fa fa-clock-o"></i> Your recently taken photos</h3>
                        <canvas id="canvas" hidden></canvas>
                        <div id="photo" style="height: 420px; width: auto; overflow-y: scroll;"></div>
                        <script type="text/javascript" src="./views/javascript/webcam.js"></script>
                </aside>
            </div>
        </section>
    <?php require_once('./views/html/footer/footer.html'); ?>
    </body>
</html>
