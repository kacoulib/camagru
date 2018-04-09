<?php
session_start();
require_once('models/PICmodel.php');

if (!empty($_SESSION['username'])) {
    if (isset($_GET['id'], $_GET['userID'], $_GET['src'])) {
        if (!empty($_GET['id']) && !empty($_GET['userID']) && !empty($_GET['src'])) {
            if (is_numeric($_GET['id']) && is_numeric($_GET['userID'])) {
                $picture = new PICmodel();
                $currentUserId = $picture->getUserIdByName(htmlspecialchars($_SESSION['username']));

                $cuser = $currentUserId['ID'];
                $userID = $_GET['userID'];
                $comID = $_GET['id'];
                $src = htmlspecialchars($_GET['src']);

                $picture->delPic($cuser, $userID, $comID, $src);
            }
        }
    }
} else {
    header("Location: index.php");
    exit();
}
//AJAX BETTER