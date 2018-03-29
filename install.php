<!DOCTYPE html>
<html>
  <head>
      <title><?php echo $title; ?></title>
      <meta charset="utf-8"/>
      <link rel="stylesheet" href="stylesheet/app.css" type="text/css">
  </head>
  <body>
  <div class="init">
    <?php if(!isset($_POST['insert'])): ?>
      <form  method="post">
      <input type="hidden" name="txt" value="<?php if(isset($message)){ echo $message;}?>" >
      <input type="submit" name="insert" value="INITIALIZE WEBSITE">
      </form>
    <?php endif; ?>
    <?php
      if(isset($_POST['insert'])){
        include "connect.php";
        // connect to mysql database
        $connect = mysqli_connect($host, $user, $password);
        // check connexion
        if (!$connect)
          die('Error : '.mysqli_connect_error());

        // create mysql db
        $db = "CREATE DATABASE rocket";
        if (mysqli_query($connect, $db)) {
          echo "Database created successfully √".'<br/>';
        } else {
          echo "Error creating database: " . mysqli_error($connect).'<br/>';
        }
        mysqli_close($connect);

          $connect = mysqli_connect($host, $user, $password, $db_name);
          // create db objects
          $user = "CREATE TABLE User (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            firstname VARCHAR(30) NOT NULL,
            status VARCHAR(30) NOT NULL,
            password VARCHAR(6000) NOT NULL,
            reg_date TIMESTAMP
            )";

          $product = "CREATE TABLE Product (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            category_name VARCHAR(30) NOT NULL,
            category_id INT,
            image VARCHAR(40),
            price INT,
            description TEXT,
            reg_date TIMESTAMP
            )";

          $category = "CREATE TABLE Category (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(30) NOT NULL,
            description TEXT,
            reg_date TIMESTAMP
            )";

          $product_category = "CREATE TABLE ProductCategory (
            product_id INT(6) UNSIGNED NOT NULL,
            category_id INT(6) UNSIGNED NOT NULL,
            PRIMARY KEY (product_id, category_id),
            FOREIGN KEY (product_id) REFERENCES Product(id) ON UPDATE CASCADE,
            FOREIGN KEY (category_id) REFERENCES Category(id) ON UPDATE CASCADE
            )";

          // create tables
          if(mysqli_query($connect, $user)){
              echo "Table User created successfully √".'<br/>';
          } else{
              echo "ERROR: Could not able to execute $sql. " . mysqli_error($connect).'<br/>';
          }
          if(mysqli_query($connect, $category)){
              echo "Table Category created successfully √".'<br/>';
          } else{
              echo "ERROR: Could not able to execute $sql. " . mysqli_error($connect).'<br/>';
          }
          if(mysqli_query($connect, $product)){
              echo "Table Product created successfully √".'<br/>';
          } else{
              echo "ERROR: Could not able to execute $sql. " . mysqli_error($connect).'<br/>';
          }
          if(mysqli_query($connect, $product_category)){
              echo "Table ProductCategory created successfully √".'<br/>';
          } else{
              echo "ERROR: Could not able to execute ProductCategory $sql. " . mysqli_error($connect).'<br/>';
          }

          // create the base of products
          include "seeds.php";
          echo '<br/>'.'<a href="index.php" action="get">'.'<p class="btn2">'."VISIT ROCKETMARKET".'<p>'.'</a>';
      }
    ?>
  </div>
</body>
</html>
