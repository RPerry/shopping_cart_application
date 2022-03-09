<?php
require_once('database.php');

// getting order_id from form data and assigning it to a variable

$delete_order_id = (int)filter_input(INPUT_POST, 'order_id');
$delete_customer_id = filter_input(INPUT_POST, 'customer_id');

// Deleting the order from the orders table 
$deleteOrderQuery = 'DELETE FROM orders WHERE orderID = :order_id';
$deleteOrderStatement = $db->prepare($deleteOrderQuery);
$deleteOrderStatement->bindValue(':order_id', $delete_order_id);
$deleteOrderStatement->execute();
$deleteOrderStatement->closeCursor();


$customer_id = $delete_customer_id;
$updateAlert = "Order Deleted!";

// Display the Product List page
include('customer_list.php');
?>




