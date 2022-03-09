<?php
require_once('database.php');

$customer_id = filter_input(INPUT_POST, 'customer_id');

// Getting all orders for the customer_id
$getAllOrdersQuery = 'SELECT cartID, orderID FROM orders WHERE customerID = :customer_id';
$getAllOrdersStatement = $db->prepare($getAllOrdersQuery);
$getAllOrdersStatement->bindValue(':customer_id', $customer_id);
$getAllOrdersStatement->execute();
$allOrdersCartIDs = $getAllOrdersStatement->fetchAll();
$getAllOrdersStatement->closeCursor();

// For each order, displaying all ordered product names and quantities
foreach ($allOrdersCartIDs as $cart) {
    $cart_id = (int) $cart["cartID"];
    $getAllProductsFromOrderQuery = 'SELECT * FROM cart_products WHERE cartID = :cart_id';
    $getAllProductsFromOrderStatement = $db->prepare($getAllProductsFromOrderQuery);
    $getAllProductsFromOrderStatement->bindValue(':cart_id', $cart_id);
    $getAllProductsFromOrderStatement->execute();
    $allCartProducts = $getAllProductsFromOrderStatement->fetchAll();
    $getAllProductsFromOrderStatement->closeCursor();

    $order_id = (int) $cart["orderID"];  
    echo "
    <h3>Order #$order_id</h3>
    <table>
        <tr>
            <th>Name</th> 
            <th>Quantity</th> 
        </tr>";
        foreach ($allCartProducts as $product) {
            $productName = $product['productName'];
            $productQuantity = $product['quantity'];
            echo "
            <tr>
            <td> $productName </td>
            <td>$productQuantity</td>
            </tr>
            ";
        }
    echo "</table>";
}

include('all_customer_orders.php');
?>
   