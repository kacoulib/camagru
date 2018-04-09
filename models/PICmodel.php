<?php

require_once("DBmodel.php");

class PICmodel extends DBmodel {

    public $currentPage;
    public $pagination = '';

    private $artByPage = 5;
    private $numPageLR = 3;

    /**
     * @param $username
     * @return array
     * Get User's ID according to @param
     */
    public function getUserIdByName($username) {
        $pdo = parent::getValue();
        $sql = $pdo->prepare("SELECT `ID` FROM camagru.t_users WHERE `Username`= ?");
        $sql->execute(array($username));
        $id = $sql->fetch();
        return $id;
    }

    public function getUserID($username) {
        $pdo = parent::getValue();
        $sql = $pdo->prepare("SELECT `ID` FROM camagru.t_users WHERE `Username`= ?");
        $sql->execute(array($username));
        $id = $sql->fetch();
        return $id;
    }
//    NOM A CHANGER
    /**
     * @param $id
     * @return mixed
     * Get User's name according to @param
     */
    public function getUserById($id) {
        $pdo = parent::getValue();
        if (is_numeric($id)) {
            $sql = $pdo->prepare("SELECT `Username` FROM camagru.t_users INNER JOIN camagru.t_com ON t_users.ID = t_com.UserID WHERE `UserID`= ?");
            $sql->execute(array($id));
            $user = $sql->fetch();
//        $user = $sql->fetchAll(PDO::FETCH_ASSOC);
            return $user;
        }
    }
//   NOM A CHANGER

    /**
     * @param $userID
     * @param $src
     * @param $timestamp
     * Save photo's path in database
     * Change $timestamp @param to NOW() SQL Keyword
     */
    public function saveMerging($userID, $src, $timestamp) {
        $pdo = parent::getValue();
        $sql = $pdo->prepare("INSERT INTO camagru.t_img (UserId,Srcpath,Date) VALUES (?,?,?)");
        $sql->execute(array($userID, $src, $timestamp));
    }

    /**
     * @param $userID
     * @return array
     * Get N public/private (Depends of @param) photos according to min and max values
     */
    public function getPictures($userID) {
        $pdo = parent::getValue();
        $offset = ($this->currentPage - 1) * $this->artByPage;
        if ($userID == false) {
            $sql = $pdo->prepare("SELECT `ArticleID`,`UserID`,`SrcPath`, `Date` FROM camagru.t_img ORDER BY `Date` DESC LIMIT :min,:max");
        } else {
            $sql = $pdo->prepare("SELECT `ArticleID`,`UserID`,`SrcPath`, `Date` FROM camagru.t_img WHERE `UserID`= :id ORDER BY `Date` DESC LIMIT :min,:max");
            $sql->bindParam(':id', $userID, PDO::PARAM_INT);
        }
        $sql->bindParam(':min', $offset, PDO::PARAM_INT);
        $sql->bindParam(':max', $this->artByPage, PDO::PARAM_INT);
        try {
            $sql->execute();
            $rows = $sql->fetchAll( PDO::FETCH_ASSOC);
            return $rows;
        } catch (PDOException $e) {
            return array();
        }
    }

    public function getPicByArtId($artID) {
        $pdo = parent::getValue();
        $sql = $pdo->prepare("SELECT `SrcPath`,`UserID` FROM camagru.t_img WHERE `ArticleID`= ?");
        $sql->execute(array($artID));
        $row = $sql->fetch();
        return $row;
    }

    /**
     * @param $page
     * @param $userID
     * Create N public/private previous/current/next page(s) according to second @param
     */
    public function getPages($page, $userID) {
        $pdo = parent::getValue();
        if ($userID == false) {
            $sql = $pdo->prepare("SELECT `UserID` FROM camagru.t_img");
            $sql->execute();
        } else {
            $sql = $pdo->prepare("SELECT `UserID` FROM camagru.t_img WHERE `UserID`= ?");
            $sql->execute(array($userID));
        }

        $totalArt = $sql->rowCount();
        $lastPage = ceil($totalArt / $this->artByPage);

        // Parser and Setter
        if (isset($_GET['page']) && is_numeric($_GET['page'])) {
            $this->currentPage = $page;
        } else {
            $this->currentPage = 1;
        }

        if ($this->currentPage < 1) {
            $this->currentPage = 1;
        } else if ($this->currentPage > $lastPage) {
            $this->currentPage = $lastPage;
        }

        // PREVIOUS
        if ($lastPage != 1) {
            if ($this->currentPage > 1) {
                $previous = $this->currentPage - 1;
                if ($userID == false) {
                    $this->pagination .= '<a href="./gallery.php?page=' . $previous . '">Previous</a> &nbsp;';
                } else {
                    $this->pagination .= '<a href="./mypage.php?page=' . $previous . '">Previous</a> &nbsp;';
                }
            }

            for ($i = $this->currentPage - $this->numPageLR; $i < $this->currentPage; $i++) {
                if ($i > 0) {
                    if ($userID == false) {
                        $this->pagination .= '<a href="./gallery.php?page=' . $i . '">' . $i . '</a> &nbsp;';
                    } else {
                        $this->pagination .= '<a href="./mypage.php?page=' . $i . '">' . $i . '</a> &nbsp;';
                    }
                }
            }
        }

        // CURRENT
        $this->pagination .= '<span class="active">'.$this->currentPage.'</span> &nbsp;';

        // NEXT
        for ($i = $this->currentPage + 1; $i <= $lastPage; $i++) {
            if ($userID == false) {
                $this->pagination .= '<a href="./gallery.php?page=' . $i . '">' . $i . '</a> ';
            } else {
                $this->pagination .= '<a href="./mypage.php?page=' . $i . '">' . $i . '</a> ';
            }

            if ($i >= $this->currentPage + $this->numPageLR) {
                break;
            }
        }
        if ($this->currentPage != $lastPage) {
            $next = $this->currentPage + 1;
            if ($userID == false) {
                $this->pagination .= '<a href="./gallery.php?page='.$next.'">Next</a> ';
            } else {
                $this->pagination .= '<a href="./mypage.php?page='.$next.'">Next</a> ';
            }
        }
    }

    public function getCom($artID) {
        $pdo = parent::getValue();
        $sql = $pdo->prepare("SELECT * FROM camagru.t_com WHERE `ArticleID`= ? ORDER BY `Date` DESC ");
        $sql->execute(array($artID));
        $coms = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $coms;
    }

    public function getLikeUser($artID, $userID) {
        $pdo = parent::getValue();
        $sql = $pdo->prepare("SELECT `Value` FROM camagru.t_like WHERE `ArticleID`= ? AND `UserID`= ?");
        $sql->execute(array($artID, $userID));
        $userLike = $sql->fetch();
        return $userLike;
    }

    public function getSumLike($artID, $value) {
        $pdo = parent::getValue();
        $sql = $pdo->prepare("SELECT `Value` FROM camagru.t_like WHERE `ArticleID`= ? AND `Value`= ?");
        $sql->execute(array($artID, $value));
        $sumlike = $sql->rowCount();
        return $sumlike;
    }

    public function upsert($artID, $userID) {
        $pdo = parent::getValue();
//
        $select = $pdo->prepare("SELECT `ArticleID`,`UserID`,`Value` FROM camagru.t_like WHERE `ArticleID`=? AND `UserID`=?");
        $select->execute(array($artID, $userID));
        $row = $select->fetch();

        if ($select->rowCount() == 1) {
            if (!$row['Value']) {
                $sql = $pdo->prepare("UPDATE camagru.t_like SET `Value`= ? WHERE `ArticleID`= ? AND `UserID`= ?");
                $sql->execute(array(1, $artID, $userID));
            } else if ($row['Value'] == 1) {
                $sql = $pdo->prepare("UPDATE camagru.t_like SET `Value`= ? WHERE `ArticleID`= ? AND `UserID`= ?");
                $sql->execute(array(0, $artID, $userID));
            }
        } else {
            $sql = $pdo->prepare("INSERT INTO camagru.t_like (ArticleID, UserID, Value) VALUES (?, ?, ?)");
            $sql->execute(array($artID, $userID, 1));
        }
    }

    public function addCom($artID, $userID, $com) {
        $pdo = parent::getValue();
        $com = utf8_encode($com);
        $sendmail = $pdo->prepare("SELECT `Username`,`Email`,`Smail` FROM camagru.t_users INNER JOIN camagru.t_img ON camagru.t_users.ID = camagru.t_img.UserID WHERE camagru.t_img.ArticleID = ?");
        if ($sendmail->execute(array($artID)) && $row = $sendmail->fetch()) {
            if ($row['Smail']) {
                $subject = "Camagru : ". $row['Username']  . " commented on your publication !";
                $header = "From: noreply@camagru.com";
                $msg = $row['Username'].' wrote to your picture : '. $com;
                mail($row['Email'], $subject, $msg, $header);
            }
            $sql = $pdo->prepare("INSERT INTO camagru.t_com (ArticleID, UserID, Com, Date) VALUES (:artID, :userID, :com , NOW())");
            $sql->execute(array(':artID'=>$artID, ':userID'=>$userID, ':com'=>$com));
        }
    }

    public function delCom($cuserID, $userID, $comID) {
        $pdo = parent::getValue();

        if ($cuserID == $userID) {
            $sql = $pdo->prepare("DELETE FROM camagru.t_com WHERE `ComID`= ?");
            $sql->execute(array($comID));
            header ("Location: $_SERVER[HTTP_REFERER]");
        } else {
            header("Location: ./index.php");
        }
        exit();
    }

    public function delPic($cuserID, $userID, $artID, $src) {
        $pdo = parent::getValue();

        if ($cuserID == $userID) {
//            $deleteAll = $pdo->prepare("DELETE t1,t2,t3 FROM `t_img` as t1 JOIN `t_like` as t2 ON t2.ArticleID = t1.ArticleID JOIN `t_com` as t3 ON t3.ArticleID = t1.ArticleID WHERE t1.ArticleID = ? AND t2.ArticleID = ? AND t3.ArticleID = ?");
//            $deleteAll->execute(array($artID, $artID, $artID));

            $sql_img = $pdo->prepare("DELETE FROM camagru.t_img WHERE `ArticleID`= ?");
            $sql_like = $pdo->prepare("DELETE FROM camagru.t_like WHERE `ArticleID`= ?");
            $sql_com = $pdo->prepare("DELETE FROM camagru.t_com WHERE `ArticleID`= ?");

            unlink($src);
            $sql_img->execute(array($artID));
            $sql_like->execute(array($artID));
            $sql_com->execute(array($artID));
            header("Location: mypage.php");
        } else {
            header("Location: ./gallery.php");
        }
        exit();
    }
}