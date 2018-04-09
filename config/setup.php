<?php

require_once("../models/DBmodel.php");

try {
    $db = new DBmodel();
    $db->create('camagru');
} catch (PDOException $e) {
    echo "Connection failed: ". $e->getMessage();
}