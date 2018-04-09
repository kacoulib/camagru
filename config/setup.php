<?php

require_once("../models/DBmodel.php");

try {
    $db = new DBmodel();
    $db->create('camagru');

    header('Location: /index.php');
} catch (PDOException $e) {
    echo "Connection failed: ". $e->getMessage();
}