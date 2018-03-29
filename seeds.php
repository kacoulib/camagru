<?php
  include "connect.php";

  function insert_data($data = array()){
    $connect = mysqli_connect("localhost", "root", "password", "rocket");
    $keys = array();
    $values = array();
    foreach ($data['data'] as $key => $value) {
        $keys[$key] = $key;
        $values[$key] = "'".$value."'";
    }
    $keys = implode(', ', $keys);
    $values = implode(', ', $values);
    if (mysqli_query($connect, "INSERT INTO ".$data['table']." (".$keys.") VALUES (".$values.")") === TRUE)
      echo $data['table']." successfully added √".'</br>';
    else
      echo "Error while creating product : ". mysqli_error($connect).'</br>';
  }

  $data = array();
  // Creating all Ariane rockets
  $data[] = array(
    'table' => 'product',
    'data' => array('category_name' => 'Ariane 1', 'price' => '12', 'category_id' => '1', 'description' => 'Under development', 'image' => 'img/product1.png')
  );
  $data[] = array(
    'table' => 'product',
    'data' => array('category_name' => 'Ariane 2', 'price' => '2', 'category_id' => '1', 'description' => 'Under development', 'image' => 'img/product2.png')
  );
  $data[] = array(
    'table' => 'product',
    'data' => array('category_name' => 'Ariane 3', 'price' => '7', 'category_id' => '1', 'description' => 'Under development', 'image' => 'img/product3.png')
  );
  $data[] = array(
    'table' => 'product',
    'data' => array('category_name' => 'Ariane 4', 'price' => '1204', 'category_id' => '1', 'description' => 'Under development', 'image' => 'img/product4.png')
  );
  $data[] = array(
    'table' => 'product',
    'data' => array('category_name' => 'Ariane 5', 'price' => '72', 'category_id' => '1', 'description' => 'Under development', 'image' => 'img/product5.png')
  );
  $data[] = array(
    'table' => 'product',
    'data' => array('category_name' => 'Ariane 6', 'price' => '47', 'category_id' => '1', 'description' => 'Under development', 'image' => 'img/product6.png')
  );
  // Creating all Long March rockets
  $data[] = array(
    'table' => 'product',
    'data' => array('category_name' => 'Long March 2A', 'price' => '12', 'category_id' => '2', 'description' => 'Under development', 'image' => 'img/product7.png')
  );
  $data[] = array(
    'table' => 'product',
    'data' => array('category_name' => 'Long March 2C', 'price' => '2', 'category_id' => '2', 'description' => 'Under development', 'image' => 'img/product8.png')
  );
  $data[] = array(
    'table' => 'product',
    'data' => array('category_name' => 'Long March 2D', 'price' => '7', 'category_id' => '2', 'description' => 'Under development', 'image' => 'img/product9.png')
  );
  $data[] = array(
    'table' => 'product',
    'data' => array('category_name' => 'Long March 2E', 'price' => '1204', 'category_id' => '2', 'description' => 'Under development', 'image' => 'img/product10.png')
  );
  $data[] = array(
    'table' => 'product',
    'data' => array('category_name' => 'Long March 2F', 'price' => '72', 'category_id' => '2', 'description' => 'Under development', 'image' => 'img/product11.png')
  );
  $data[] = array(
    'table' => 'product',
    'data' => array('category_name' => 'Long March 2G', 'price' => '47', 'category_id' => '2', 'description' => 'Under development', 'image' => 'img/product12.png')
  );
  // Creating all Kosmos rockets
  $data[] = array(
    'table' => 'product',
    'data' => array('category_name' => 'Kosmos 1', 'price' => '12', 'category_id' => '3', 'description' => 'Under development', 'image' => 'img/product13.png')
  );
  $data[] = array(
    'table' => 'product',
    'data' => array('category_name' => 'Kosmos 2I', 'price' => '2', 'category_id' => '3', 'description' => 'Under development', 'image' => 'img/product14.png')
  );
  $data[] = array(
    'table' => 'product',
    'data' => array('category_name' => 'Kosmos 3', 'price' => '7', 'category_id' => '3', 'description' => 'Under development', 'image' => 'img/product15.png')
  );
  $data[] = array(
    'table' => 'product',
    'data' => array('category_name' => 'Kosmos 3M', 'price' => '1204', 'category_id' => '3', 'description' => 'Under development', 'image' => 'img/product16.png')
  );
  // create admin users
  $password	= hash("whirlpool", "-,+*)('&%$#\""."password"."0987654321asTuVwXyZ");
  $data[] = array(
    'table' => 'user',
    'data' => array('firstname' => 'kacoulib', 'password' => $password, 'status' => 'admin')
  );
  $data[] = array(
    'table' => 'user',
    'data' => array('firstname' => 'tgauguet', 'password' => $password, 'status' => 'admin')
  );
  // create products categories
  $data[] = array(
    'table' => 'category',
    'data' => array('name' => 'Ariane', 'id' => '1', 'description' => 'Ariane is a series of a European civilian expendable launch vehicles for space launch use. The name comes from the French spelling of the mythological character Ariadne.')
  );
  $data[] = array(
    'table' => 'category',
    'data' => array('name' => 'Long March', 'id' => '2', 'description' => 'Any rocket in a family of expendable launch systems operated by the Peoples Republic of China..')
  );
  $data[] = array(
    'table' => 'category',
    'data' => array('name' => 'Kosmos', 'id' => '3', 'description' => 'The Kosmos rockets were a series of Soviet and subsequently Russian rockets, derived from the R-12 and R-14 missiles')
  );
  $data[] = array(
    'table' => 'category',
    'data' => array('name' => 'Big big Rocket', 'id' => '4', 'description' => 'List all the big rockets')
  );

  // create first products
  foreach ($data as $d) {
    insert_data($d);
  }
?>
