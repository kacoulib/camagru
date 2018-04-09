<?php
require_once("DBmodel.php");
require_once("USERmodel.php");
require_once(realpath("./controllers/services/inputFilters.php"));

class FILTERmodel extends DBmodel {

    /**
     * @param string $usr
     * @param string $email
     * @return bool
     * Check if @params exists in database, returns false if it didn't find any else true
     */
    public function dataExist($usr, $email) {
        $pdo = parent::getValue();
        $sql = $pdo->prepare("SELECT Username FROM camagru.t_users WHERE Username = ? OR Email = ?");
        $sql->execute(array($usr, $email));
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        return (empty($result)) ? false : true;
    }

    /**
     * @param $postUser
     * @return array
     * Parse the username sent and returns 1 if there's not errors detected else 0
     */
    public function usernameFilter($postUser) {
        $arrayUser = array();
        $usernameErr = "";
        $username = "";
        if (empty($postUser)) {
            $usernameErr = "Name is required";
        } else {
            $username = check_input($postUser);
//            if (!preg_match("#^(?=.{3,})(?=.*[a-z])(?=.*[A-Z])(?=.*\W).+$#", $username)) {
            if (!preg_match("#^[A-Za-z0-9]{3,15}$#", $username)) {
                $usernameErr = "Must contains at least 3 characters and maximum 15 characters, only alphanumerics are allowed";
            }
            if ($this->dataExist($username, "")) {
                $usernameErr = "Username already exists";
            }
        }
        $flagUser = ($usernameErr == "") ? 1 : 0;
        array_push($arrayUser, $username, $flagUser, $usernameErr);
        return $arrayUser;
    }

    /**
     * @param string $postEmail
     * @param int $flag : 0 Regular mode
     *           $flag : 1 Ask to reset pass
     * @return array
     * Parse the email sent and returns 1 if there's not errors detected else 0
     */
    public function emailFilter($postEmail, $flag) {
        $arrayMail = array();
        $user = new USERmodel();
        $emailErr = "";
        $email = "";
        if (empty($postEmail)) {
            $emailErr = "Email is required";
        } else {
            $email = check_input($postEmail);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Invalid format email";
            }
            if (!$flag) {
                if ($this->dataExist("", $email)) {
                    $emailErr = "This email already exists";
                }
            } else {
                if (!$this->dataExist("", $email)) {
                    $emailErr = "This email doesn't match any accounts";
                } else {
                    $user->resetPass($email);
                }
            }

        }
        $flagMail = ($emailErr == "") ? 1 : 0;
        array_push($arrayMail, $email, $flagMail, $emailErr);
        return $arrayMail;
    }

    /**
     * @param string $postPass
     * @return array
     * Parse the password sent and returns 1 if there's not errors detected else 0
     */
    public function passFilter($postPass) {
        $arrayPass = array();
        $passwordErr = "";
        $password = "";
        if (empty($postPass)) {
            $passwordErr = "Password is required";
        } else {
            $password = check_input($postPass);
            if (!preg_match("#^\S*(?=\S{6,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$#", $password)) {
                $passwordErr = "Must contains at least 6 characters, 1 uppercase, 1 lowercase and 1 digit";
            }
        }
        $flagPass = ($passwordErr == "") ? 1 : 0;
        array_push($arrayPass, $password, $flagPass, $passwordErr);
        return $arrayPass;
    }
}