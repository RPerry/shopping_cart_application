<?php
require('database.php');

$update_productID = (int)filter_input(INPUT_POST, 'product_id');
$update_productName = filter_input(INPUT_POST, 'product_name');
$update_productDescription = filter_input(INPUT_POST, 'product_description');
$update_productPrice = (float) filter_input(INPUT_POST, 'product_price');
$update_productQuantity = (int) filter_input(INPUT_POST, 'product_quantity');

// updating the product
    $updateProductQuery = 'UPDATE products SET productName = :update_productName, 
    productDescription = :update_productDescription, productPrice = :update_productPrice, 
    productQuantity= :update_productQuantity WHERE productID = :update_productID';
    $updateProductStatement = $db->prepare($updateProductQuery);
    $updateProductStatement->bindValue(':update_productID', $update_productID);
    $updateProductStatement->bindValue(':update_productName', $update_productName);
    $updateProductStatement->bindValue(':update_productDescription', $update_productDescription);
    $updateProductStatement->bindValue(':update_productPrice', $update_productPrice);
    $updateProductStatement->bindValue(':update_productQuantity', $update_productQuantity);
    $updateProductStatement->execute();
    $updateProductStatement->closeCursor();

$product_id = $update_productID;
$productUpdateAlert = "Product Updated!"; 

// Display the product list page
include('product_list.php');

?>



