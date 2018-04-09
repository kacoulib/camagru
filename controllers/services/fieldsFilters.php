<?php
require_once(realpath('./models/FILTERmodel.php'));
require_once("save_SendMail.php");

  $usernameErr = $emailErr = $passwordErr = "";
  $username = $email = $password = "";
  $arrayUser = $arrayMail = $arrayPass = null;
  $filter = new FILTERmodel();
  $user = new USERmodel();

  if ($_SERVER['REQUEST_METHOD'] == "POST") {

      $arrayUser = $filter->usernameFilter($_POST['username']);
      $username = $arrayUser[0];
      $usernameErr = ($arrayUser[2] == "") ? "" : $arrayUser[2];

      $arrayMail = $filter->emailFilter($_POST['email'], 0);
      $email = $arrayMail[0];
      $emailErr = ($arrayMail[2] == "") ? "" : $arrayMail[2];

      $arrayPass = $filter->passFilter($_POST['password']);
      $password = $arrayPass[0];
      $passwordErr = ($arrayPass[2] == "") ? "" : $arrayPass[2];

      save_SendMail($arrayUser, $arrayMail, $arrayPass);
  }

