<?php

require_once(realpath(dirname(__FILE__) . '/../config/database.php'));

Class DBmodel {

    private $dbname;
    private $pdo;

    public function __construct() {
        $this->pdo = new PDO('mysql:host=127.0.0.1', $GLOBALS['USERNAME'], $GLOBALS['PASSWORD']);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * @return PDO
     */
    public function getValue() {
        return $this->pdo;
    }

    /**
     * @param string $db
     * Creates database and its tables
     */
    public function create($db) {
        $this->dbname = $db;
        $sql_db = "CREATE DATABASE IF NOT EXISTS $this->dbname";

        $sql_users = "CREATE TABLE IF NOT EXISTS $this->dbname.t_users (
		                `ID` INT PRIMARY KEY NOT NULL UNIQUE AUTO_INCREMENT,
		                `Username` VARCHAR(100) UNIQUE NOT NULL,
		                `Password` VARCHAR(255) NOT NULL,
		                `Email` VARCHAR(255) NOT NULL,
		                `Token` VARCHAR(32) NOT NULL,
                	    `Status` INT DEFAULT 0,
                	    `Reset` INT DEFAULT 0,
                	    `Smail` INT DEFAULT 1
                      )
                      ENGINE=INNODB DEFAULT CHARSET=utf8;";

        $sql_img = "CREATE TABLE IF NOT EXISTS $this->dbname.t_img (
                      `ArticleID` INT PRIMARY KEY NOT NULL UNIQUE AUTO_INCREMENT,
                      `UserID` INT NOT NULL,
                      `SrcPath` VARCHAR(255) UNIQUE NOT NULL,
                      `Date` TIMESTAMP NOT NULL  
                    )
                    ENGINE=INNODB DEFAULT CHARSET=utf8;";

        $sql_like = "CREATE TABLE IF NOT EXISTS $this->dbname.t_like (
                      `LikeID` INT PRIMARY KEY NOT NULL UNIQUE AUTO_INCREMENT,
                      `ArticleID` INT NOT NULL,
                      `UserID` INT NOT NULL,
                      `Value` INT DEFAULT 0  
                    )
                    ENGINE=INNODB DEFAULT CHARSET=utf8;";

        $sql_com = "CREATE TABLE IF NOT EXISTS $this->dbname.t_com (
                      `ComID` INT PRIMARY KEY NOT NULL UNIQUE AUTO_INCREMENT,
                      `ArticleID` INT NOT NULL,
                      `UserID` INT NOT NULL,
                      `Com` VARCHAR(255) NOT NULL,
                      `Date` TIMESTAMP NOT NULL  
                    )
                    ENGINE=INNODB DEFAULT CHARSET=utf8;";

        $this->pdo->prepare($sql_db)->execute();
        $this->pdo->prepare($sql_users)->execute();
        $this->pdo->prepare($sql_img)->execute();
        $this->pdo->prepare($sql_like)->execute();
        $this->pdo->prepare($sql_com)->execute();
    }
}