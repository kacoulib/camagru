<?php
  require_once(dirname(__FILE__) . '/database.php');
  try
    {
      $db = new PDO("mysql:host=$DB_DSN", $DB_USER, $DB_PASSWORD);
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $sql = "CREATE DATABASE IF NOT EXISTS camagru";
      $db->query($sql);
      $db->query("use camagru");

      // create db objects
      $sql = "CREATE TABLE IF NOT EXISTS Users (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        login VARCHAR(30) NOT NULL UNIQUE,
        email VARCHAR(250) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        is_confirm tinyint(1) NOT NULL DEFAULT 0,
        confirm_id VARCHAR(255) NOT NULL,
        send_notif tinyint(1) NOT NULL DEFAULT 1,
        reg_date TIMESTAMP
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;";
      $db->query($sql);

      $sql = "CREATE TABLE IF NOT EXISTS Images (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        user_id INT(6) UNSIGNED NOT NULL,
        nb_like INT(6) NOT NULL DEFAULT 0,
        url VARCHAR(255) NOT NULL UNIQUE,
        reg_date TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES Users(id) ON UPDATE CASCADE
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;";
      $db->query($sql);

      $sql = "CREATE TABLE IF NOT EXISTS Comments (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        user_id INT(6) UNSIGNED NOT NULL,
        image_id INT(6) UNSIGNED NOT NULL,
        title varchar(255),
        description TEXT,
        reg_date TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES Users(id) ON UPDATE CASCADE,
        FOREIGN KEY (image_id) REFERENCES Images(id) ON UPDATE CASCADE
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;";
      $db->query($sql);
    }
    catch (Exception $e)
    {
        echo 'Exception reçue : ',  $e->getMessage(), "\n";
        exit;
    }

  header('Location: ../index.php');
exit;
