<?php
require_once('database.php');

// getting customerID of selected customer
if (!isset($customer_id)) {
    $customer_id = filter_input(INPUT_GET, 'customer_id');
    $updateAlert = "";
    if ($customer_id == NULL || $customer_id == FALSE) {
        // displaying the first customer by id before admin has chosen one to view
        $firstCustomerQuery = 'SELECT * FROM customers ORDER BY customerID';
        $firstCustomerStatement = $db->prepare($firstCustomerQuery);
        $firstCustomerStatement->execute();
        $allCustomersForFirst = $firstCustomerStatement->fetchAll();
        $firstCustomerStatement->closeCursor();
        $customer_id = $allCustomersForFirst[0]['customerID'];
    }
}

// Get selected customer name
$customerNameQuery= 'SELECT * FROM customers WHERE customerID = :customer_id';
$customerNameStatement = $db->prepare($customerNameQuery);
$customerNameStatement->bindValue(':customer_id', $customer_id);
$customerNameStatement->execute();
$customerForName = $customerNameStatement->fetch();
$customerNameStatement->closeCursor();
$customerFirstName = $customerForName['firstName'];
$customerLastName = $customerForName['lastName'];

// Getting all orders for the customer_id
$getAllOrdersQuery = 'SELECT * FROM orders WHERE customerID = :customer_id';
$getAllOrdersStatement = $db->prepare($getAllOrdersQuery);
$getAllOrdersStatement->bindValue(':customer_id', $customer_id);
$getAllOrdersStatement->execute();
$allOrdersCartIDs = $getAllOrdersStatement->fetchAll();
$getAllOrdersStatement->closeCursor();


// getting all customers from customers db and ordering the results by customer and storing them in the $allCustomers variable
$allCustomersQuery = 'SELECT * FROM customers ORDER BY customerID';
$allCustomersStatement = $db->prepare($allCustomersQuery);
$allCustomersStatement->execute();
$allCustomers = $allCustomersStatement->fetchAll();
$allCustomersStatement->closeCursor();
?>


<!DOCTYPE html>
<html>

<head>
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="styles/main.css" />
</head>

<body>
    <header><h1><a href="index.php">Beanie Babie Shop</a></h1></header>
    <h5 id="admin-header"><a href="admin_home.php">Admin</a></h5>
    <main>
    <section>
    <aside>
        <!-- Displaying list of all customers -->
        <h2>All Customers</h2>
        <nav>
            <ul>
                <?php foreach ($allCustomers as $customer) : ?>
                    <li>
                        <a href="?customer_id=<?php echo $customer['customerID']; ?>">
                            <?php echo $customer['firstName'];  echo " "; echo $customer['lastName']; ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>
    </aside>
    </section>

    <section>
        <h2><?php echo $customerFirstName; echo " "; echo $customerLastName; ?></h2>
        <!-- For each order, displaying all ordered product names and quantities -->
        <?php
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
    ?>
    <form action="delete_order.php" method="post" id="delete_order">
        <input type="hidden" name="customer_id" value="<?php echo $cart["customerID"]; ?>">
        <input type="hidden" name="order_id" value="<?php echo $cart["orderID"]; ?>">
        <input type="submit" value="Delete" type="button" class="btn btn-outline-primary">
    </form>  
    <form action="edit_order_form.php" method="post" id="edit_order_form">
        <input type="hidden" name="cart_id" value="<?php echo $cart_id; ?>">
        <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
        <input type="hidden" name="edit_customer_id" value="<?php echo $cart["customerID"]; ?>">
        <input type="submit" value="Edit" type="button" class="btn btn-outline-primary">
    </form> 
    <?php } ?>
    <?php } ?>      
    </section>
    <section>
        <h3 class="gAlert" style="color:#20B2AA;"><?php echo $updateAlert ?></h3>
    </section>
    </main>
</body>

<footer>
    <p>&copy; <?php echo date("Y"); ?> Riyo Perry</p>
</footer>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>