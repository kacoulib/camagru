<?php
    session_start();

    if (empty($_SESSION['username'])) {
        require_once('./connection.php');
    } else {
        require_once('./webcam.php');
    }
