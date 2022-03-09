<?php
require('database.php');

$order_cart_id = (int)filter_input(INPUT_POST, 'cart_id');
$order_customer_id = filter_input(INPUT_POST, 'customer_id');

// adding the order to the orders table
$orderQuery = 'INSERT INTO orders (customerID, cartID) VALUES (:customer_id, :cart_id)';
$orderStatement = $db->prepare($orderQuery);
$orderStatement->bindValue(':customer_id', $order_customer_id);
$orderStatement->bindValue(':cart_id', $order_cart_id);
$orderStatement->execute();
$orderStatement->closeCursor();

// updating the quantities of the products

    // getting products from order
$getCartProductsQuery = 'SELECT * FROM cart_products WHERE cartID = :cart_id';
$getCartProductsStatement = $db->prepare($getCartProductsQuery);
$getCartProductsStatement->bindValue(':cart_id', $order_cart_id);
$getCartProductsStatement->execute();
$order_cart_products = $getCartProductsStatement->fetchAll();
$getCartProductsStatement->closeCursor();

foreach ($order_cart_products as $order_cart_product) {
    // getting current quantity of product
    $product_id = (int) $order_cart_product['productID'];

    $getCurrentQuantQuery = 'SELECT productQuantity FROM products WHERE productID = :product_id';
    $getCurrentQuantStatement = $db->prepare($getCurrentQuantQuery);
    $getCurrentQuantStatement->bindValue(':product_id', $product_id);
    $getCurrentQuantStatement->execute();
    $quantity = $getCurrentQuantStatement->fetch();
    $getCurrentQuantStatement->closeCursor();
   

    // updating quantity of product
    $newQuantity = (int) $quantity['productQuantity'] - (int) $order_cart_product['quantity'];
    $quantityQuery = 'UPDATE products SET productQuantity=:newQuantity WHERE productID=:product_id';
    $quantityStatement = $db->prepare($quantityQuery);
    $quantityStatement->bindValue(':newQuantity', $newQuantity);
    $quantityStatement->bindValue(':product_id', $product_id);
    $quantityStatement->execute();
    $quantityStatement->closeCursor();
} 

$orderAlert = "Order Confirmed"; 

// Display the Home page
include('index.php');

?>



