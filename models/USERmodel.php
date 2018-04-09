<?php

require_once("DBmodel.php");

class USERmodel extends DBmodel {
    private $login;
    private $email;
    private $password;
    private $token;

    /**
     * @param $login
     * @param $email
     * @param $password
     * Assigns to each variables the @params of the function
     */
    private function setUser($login, $email, $password) {
        $this->login = $login;
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * @param string username
     * @return array
     * Returns all informations about this user
     */
    public function getUser($username) {
        $pdo = parent::getValue();
        $sql = $pdo->prepare("SELECT * FROM camagru.t_users WHERE Username = ?");
        if ($sql->execute(array($username)) && $row = $sql->fetch()) {
            return $row;
        } else {
            $empty = array();
            return $empty;
        }
    }

    /**
     * @param string $mail
     * @return array
     * Returns all informations about this user
     */
    public function getUserByMail($mail) {
        $pdo = parent::getValue();
        $sql = $pdo->prepare("SELECT * FROM camagru.t_users WHERE Email = ?");
        if ($sql->execute(array($mail)) && $row = $sql->fetch()) {
            return $row;
        } else {
            $empty = array();
            return $empty;
        }
    }

    /**
     * @param $login
     * @param $email
     * @param $password
     * Save a new user in database
     */
    public function saveUser($login, $email, $password) {
        $this->setUser($login, $email, $password);
        $pdo = parent::getValue();
        $this->token = md5(microtime(TRUE) * 100000);

//        var_dump($login, $email, $password, $this->token);
        $sql = $pdo->prepare("INSERT INTO camagru.t_users (Username,Password,Email,Token) VALUES (?,?,?,?)");
        $sql->execute(array($login, $password, $email, $this->token));
    }

    public function getNotification($c_user) {
        $pdo = parent::getValue();
        $sql = $pdo->prepare("SELECT `Smail` FROM camagru.t_users WHERE `ID`= ?");
        $sql->execute(array($c_user));
        $row = $sql->fetch();

        if ($row['Smail']) {
            $false = $pdo->prepare("UPDATE camagru.t_users SET `Smail`= ? WHERE `ID`= ?");
            $false->execute(array(0, $c_user));
        } else {
            $true = $pdo->prepare("UPDATE camagru.t_users SET `Smail`= ? WHERE `ID`= ?");
            $true->execute(array(1, $c_user));
        }
    }

    /**
     * Sending an email to activate the user's account
     */
    public function sendMail() {
        $subject = "Active your account !";
        $header = "From: Noreply <kacoulib@gmail.fr>";
        $msg = 'Welcome on Camagru,

        To activate your account,
        click on the link below or copy/paste into your internet browser.

        http://localhost:8080/activation.php?log='.urlencode($this->login).'&tok='.urlencode($this->token).'

        This is an automatic-mail, please don\'t reply it.';

        if (mail($this->email, $subject, $msg, $header)) {
            echo "Mail of activation sent to : <i>".$this->email."</i>";
        }
    }

    /**
     * @param $login
     * @param $tok
     * Activate the account only when the user clicks on the activation email
     */
    public function setActivate($login, $tok) {
        $pdo = parent::getValue();
        $tokDB = $status = null;
        $sql = $pdo->prepare("SELECT `Token`,`Status` FROM camagru.t_users WHERE Username = ? ");
        if ($sql->execute(array($login)) && $row = $sql->fetch()) {
            $tokDB = $row['Token'];
            $status = $row['Status'];
        }
        if ($status === '1') {
            echo "Be smart !";
        }
        else {
            if ($tok === $tokDB) {
                echo "Your account has been activated !";
                $sql = $pdo->prepare("UPDATE camagru.t_users SET `Status` = 1 WHERE Username = ? ");
                $sql->execute(array($login));
            }
            else {
                echo "Error ! Your account may not be activated ...";
            }
        }
        echo  " <a href='/index.php'>Home</a>";
    }

    /**
     * @param $email
     * Sending an email to reset the password
     */
    public function resetPass($email) {
        $pdo = parent::getValue();
        $reset = 1;
        $this->token = md5(microtime(TRUE) * 100000);
        $sql = $pdo->prepare("UPDATE camagru.t_users SET Token = '$this->token', Reset = ? WHERE Email = ?");
        $sql->execute(array($reset, $email));

        $subject = "Reset your password !";
        $header = "From: kacoulib@gmail.fr";
        $msg = 'Welcome on Camagru,

		To reset your password,
		click on the link below or copy/paste into your internet browser.

		http://localhost:8080/royalpass.php?mail='.urlencode($email).'&tok='.urlencode($this->token).'

        If you never asked to reset your password, please ignore this mail.
		This is an automatic-mail,please don\'t reply it.';
        mail($email, $subject, $msg, $header);
        echo "Mail Sent !";
    }

    public function modifyMail($username, $mail) {
        $pdo = parent::getValue();
        $sql = $pdo->prepare("UPDATE camagru.t_users SET `Email` = ? WHERE Username = ?");
        $sql->execute(array($mail, $username));
    }

    public function modifyUsername($username, $usern) {
        $pdo = parent::getValue();
        $sql = $pdo->prepare("UPDATE camagru.t_users SET `Username` = ? WHERE Username = ?");
        $sql->execute(array($usern, $username));
        $_SESSION['username'] = $usern;
    }

    public function modifyPass($username, $password) {
        $pdo = parent::getValue();
        $sql = $pdo->prepare("UPDATE camagru.t_users SET `Password` = ? WHERE Username = ?");
        $sql->execute(array($password, $username));
    }

    /**
     * @param string $email
     * @param string $tok
     * @param string $password
     * Set a new password to user
     */
    public function setNewPass($email, $tok, $password) {
        $tokDB = $reset = null;
        $pdo = parent::getValue();
        $sql = $pdo->prepare("SELECT Token, Reset FROM camagru.t_users WHERE Email = ?");
        if ($sql->execute(array($email)) && $row = $sql->fetch()) {
            $tokDB = $row['Token'];
            $reset = $row['Reset'];
        }
        if ($reset == 1) {
            if ($tok == $tokDB) {
                $sql = $pdo->prepare("UPDATE camagru.t_users SET Password = ?, Reset = ? WHERE Email = ?");
                $sql->execute(array($password, 0, $email));
                echo "Password changed";
            } else {
                echo "Error ! Your account cannot be activated ...";
            }
        } else {
            echo "Error password already updated";
        }
    }

    public function auth($username, $password) {
        $pdo = parent::getValue();
        $usr = $pass = null;
        $sql = $pdo->prepare("SELECT Username, Password FROM camagru.t_users WHERE Username = ?");
        if ($sql->execute(array($username)) && $row = $sql->fetch(PDO::FETCH_ASSOC)) {
            $usr = $row['Username'];
            $pass = $row['Password'];
        }
        $hash = hash('whirlpool', $password);
        $access = (($usr == $username) && ($pass == $hash)) ? true : false;
        return $access;
    }

    public function logout() {
        //session_start();
        session_destroy();
        header("Location: index.php");
    }
}
