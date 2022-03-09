<?php
require_once('database.php');

// Get the product form data
$product_name = filter_input(INPUT_POST, 'product_name');
$product_description = filter_input(INPUT_POST, 'product_description');
$product_price = (float) filter_input(INPUT_POST, 'product_price');
$product_quantity = (int) filter_input(INPUT_POST, 'product_quantity');


// Adding the product to the products table  
$addProductQuery = 'INSERT INTO products
(productName, productDescription, productPrice, productQuantity)
VALUES
(:product_name, :product_description, :product_price, :product_quantity)';
$addProductStatement = $db->prepare($addProductQuery);
$addProductStatement->bindValue(':product_name', $product_name);
$addProductStatement->bindValue(':product_description', $product_description);
$addProductStatement->bindValue(':product_price', $product_price);
$addProductStatement->bindValue(':product_quantity', $product_quantity);
$addProductStatement->execute();
$addProductStatement->closeCursor();

// Getting the newly created products id from the db
$productIDQuery = 'SELECT productID FROM products WHERE productName = :product_name';
$productIDStatement = $db->prepare($productIDQuery);
$productIDStatement->bindValue(':product_name', $product_name);
$productIDStatement->execute();
$newProductID = $productIDStatement->fetch();
$productIDStatement->closeCursor();

$product_id = (int)$newProductID;
$productUpdateAlert = "Product Added!";   

// Display the new product on Product List page
include('product_list.php');

?>

