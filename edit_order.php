
<?php
require('database.php');

$update_order_cartID = (int)filter_input(INPUT_POST, 'cart_id');
$update_order_productID = (int)filter_input(INPUT_POST, 'product_id');
$update_order_quantity = (int)filter_input(INPUT_POST, 'product_quantity');
$previous_quantity = (int) filter_input(INPUT_POST, 'previous_quantity');
$update_customerID = filter_input(INPUT_POST, 'edit_form_customer_id');

// updating the quantity for the product in the order
$updateOrderQuery = 'UPDATE cart_products SET 
quantity = :update_order_quantity WHERE cartID = :update_order_cartID AND productID = :update_order_productID';
$updateOrderStatement = $db->prepare($updateOrderQuery);
$updateOrderStatement->bindValue(':update_order_quantity', $update_order_quantity);
$updateOrderStatement->bindValue(':update_order_cartID', $update_order_cartID);
$updateOrderStatement->bindValue(':update_order_productID', $update_order_productID);
$updateOrderStatement->execute();
$updateOrderStatement->closeCursor();

// updating the product

    //  getting current quantity of product

    $getCurrentQuantQuery = 'SELECT productQuantity FROM products WHERE productID = :update_order_productID';
    $getCurrentQuantStatement = $db->prepare($getCurrentQuantQuery);
    $getCurrentQuantStatement->bindValue(':update_order_productID', $update_order_productID);
    $getCurrentQuantStatement->execute();
    $quantity = $getCurrentQuantStatement->fetch();
    $getCurrentQuantStatement->closeCursor();
 
    // updating quantity of product
    $newQuantity;
    if ($previous_quantity < $update_order_quantity) {
        $updateAmount = $update_order_quantity - $previous_quantity;
        $newQuantity = (int)$quantity['productQuantity'] - $updateAmount;
    } elseif ($previous_quantity > $update_order_quantity) {
        $updateAmount = $previous_quantity - $update_order_quantity ;
        $newQuantity = (int)$quantity['productQuantity'] + $updateAmount;
    } elseif ($previous_quantity == $update_order_quantity) {
        $newQuantity = (int)$quantity['productQuantity'];
    }

    $updateProductQuery = 'UPDATE products SET 
    productQuantity = :update_product_quantity WHERE productID = :update_product_productID';
    $updateProductStatement = $db->prepare($updateProductQuery);
    $updateProductStatement->bindValue(':update_product_quantity', $newQuantity);
    $updateProductStatement->bindValue(':update_product_productID', $update_order_productID);
    $updateProductStatement->execute();
    $updateProductStatement->closeCursor();

$customer_id = $update_customerID;
$updateAlert = "Order Updated!";

// Display the product list page
include('customer_list.php');

?>



