<?php
require_once (realpath("./models/USERmodel.php"));

    function save_SendMail(array $arrayUser, array $arrayMail, array $arrayPass)
    {
        $user = new USERmodel();

        if ($arrayUser[1] && $arrayMail[1] && $arrayPass[1]) {
            $user->saveUser($arrayUser[0], $arrayMail[0], hash('whirlpool', $arrayPass[0]));
            $user->sendMail();
        }
    }

