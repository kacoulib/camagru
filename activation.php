<?php
require_once("models/USERmodel.php");

    $user = new USERmodel();
    if (!empty($_GET['log']) && !empty($_GET['tok'])) {
	    $login = $_GET['log'];
	    $tok = $_GET['tok'];

	    $user->setActivate($login, $tok);
    } else {
//        header('Location : index.php');
//        exit();
        echo "Error ...";
    }
