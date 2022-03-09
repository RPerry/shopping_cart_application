<?php
require_once('database.php');  
?>

<!DOCTYPE html>
<html>

<head>
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="styles/main.css" />
</head>

<body>
<header>
    <h1><a href="index.php">Beanie Babie Shop</a></h1>
    <h5 id="admin-header"><a href="admin_login_form.php">Admin</a></h5>
</header>
<main>
    <h3>View All of Your Orders</h3>
    <form action="" method="post" id="get_customer_orders">
        Please Enter Your Customer ID: <input type="text" name="customer_id">
        <input type="submit" value="Submit" name="Submit">
    </form>
    <section style="padding-top: 10px;">
    <?php
    // checking if customer submitted their id search and displaying the resulting orders
    if(isset($_POST['Submit'])){ 
        $customer_id = $_POST['customer_id']; 

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

        if (count($allCartProducts) > 0) {
        echo "
        <h3>Order #$order_id</h3>
        <table class='table'>
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
        }
        }    
    ?>
    </section>
</main>

<footer>
    <p>&copy; <?php echo date("Y"); ?> Riyo Perry</p>
</footer>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>