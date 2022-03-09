    
<?php
require_once('database.php');

// getting cart_product data from form and assigning it to variables

$cart_product_cart_id = (int)filter_input(INPUT_POST, 'cart_id');
$cart_product_product_name = filter_input(INPUT_POST, 'product_name');
$cart_product_quantity = (int)filter_input(INPUT_POST, 'product_quantity');
$cart_product_product_id = (int)filter_input(INPUT_POST, 'product_id');

// Add the cart_product to the cart_products table

$query = 'INSERT INTO cart_products (cartID, productName, quantity, productID) VALUES (:cart_id, :product_name, :product_quantity, :product_id)';
$statement = $db->prepare($query);
$statement->bindValue(':cart_id', $cart_product_cart_id);
$statement->bindValue(':product_name', $cart_product_product_name);
$statement->bindValue(':product_quantity', $cart_product_quantity);
$statement->bindValue(':product_id', $cart_product_product_id);
$statement->execute();
$statement->closeCursor();

$cart_id = $cart_product_cart_id;


// Display the Home page
include('index.php');

?>



