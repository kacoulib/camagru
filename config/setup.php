<?php
  require_once('database.php');
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
        login VARCHAR(30) NOT NULL,
        email VARCHAR(250) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        is_confirm tinyint(1) NOT NULL DEFAULT 0,
        confirm_id VARCHAR(255) NOT NULL,
        reg_date TIMESTAMP
      )";
      $db->query($sql);

      $sql = "CREATE TABLE IF NOT EXISTS Images (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        user_id INT(6) UNSIGNED NOT NULL,
        nb_like INT(6) NOT NULL DEFAULT 0,
        name varchar(255) NOT NULL,
        description TEXT,
        url VARCHAR(255) NOT NULL UNIQUE,
        reg_date TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES Users(id) ON UPDATE CASCADE
      )";
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
      )";
      $db->query($sql);
    }
    catch (Exception $e)
    {
        echo 'Exception reçue : ',  $e->getMessage(), "\n";
        exit;
    }

  header('Location: ../index.php');
exit;
