<?php
require_once('database.php');

// getting cartproduct_id from form data and assigning it to a variable

$cartproduct_id = (int)filter_input(INPUT_POST, 'cartproduct_id');
$cart_delete_id = (int)filter_input(INPUT_POST, 'cart_id');

// Deleting the product from the cart_products table 
$deleteCartProductQuery = 'DELETE FROM cart_products WHERE cartProductID = :cartproduct_id';
$deleteCartProductStatement = $db->prepare($deleteCartProductQuery);
$deleteCartProductStatement->bindValue(':cartproduct_id', $cartproduct_id);
$deleteCartProductStatement->execute();
$deleteCartProductStatement->closeCursor();

$cart_id = $cart_delete_id;
// Display the Home page
include('index.php');
?>




