<?php
require_once('database.php');

// getting product_id from form data and assigning it to a variable

$delete_product_id = (int)filter_input(INPUT_POST, 'product_id');

// First deleting cart_products that have that product id so there is no foreign constraint issue

$deleteCartProductsQuery = 'DELETE FROM cart_products WHERE productID = :product_id';
$deleteCartProductStatement = $db->prepare($deleteCartProductsQuery);
$deleteCartProductStatement->bindValue(':product_id', $delete_product_id);
$deleteCartProductStatement->execute();
$deleteCartProductStatement->closeCursor();

// Then deleting the product from the products table 
$deleteProductQuery = 'DELETE FROM products WHERE productID = :product_id';
$deleteProductStatement = $db->prepare($deleteProductQuery);
$deleteProductStatement->bindValue(':product_id', $delete_product_id);
$deleteProductStatement->execute();
$deleteProductStatement->closeCursor();


// Getting the id of the product with the lowest id number
$firstProductQuery = 'SELECT MIN(productID) as productID FROM products';
$firstProductStatement = $db->prepare($firstProductQuery);
$firstProductStatement->execute();
$firstProductID = $firstProductStatement->fetch();
$firstProductStatement->closeCursor();

$product_id = (int)$firstProductID;
$productUpdateAlert = "Product Deleted!";

// Display the Product List page   
include('product_list.php');
?>




