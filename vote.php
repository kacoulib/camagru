<?php
session_start();
if (empty($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
require_once("./models/PICmodel.php");

if (isset($_GET['id'])) {
    if (is_numeric($_GET['id'])) {
        $picture = new PICmodel();
        $artID = $_GET['id'];
        $p = $picture->getPicByArtId($artID);

        if ($p) {
            $userID = $picture->getUserIdByName(htmlspecialchars($_SESSION['username']));
            $like = $picture->getLikeUser($artID, $userID['ID']);

            $picture->upsert($artID, $userID['ID']);
        }
        header("Location: $_SERVER[HTTP_REFERER]");
        exit();
    }
}