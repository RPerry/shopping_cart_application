<?php
require('database.php');

$edit_order_order_id = (int) filter_input(INPUT_POST, 'order_id');
$edit_order_cart_id = (int) filter_input(INPUT_POST, 'cart_id');
$edit_customer_id = filter_input(INPUT_POST, 'edit_customer_id');

$editOrderQuery = 'SELECT * FROM cart_products WHERE cartID = :cart_id';
$editOrderStatement = $db->prepare($editOrderQuery);
$editOrderStatement->bindValue(':cart_id', $edit_order_cart_id);
$editOrderStatement->execute();
$allOrderProducts = $editOrderStatement->fetchAll(PDO::FETCH_ASSOC);
$editOrderStatement->closeCursor();

?>
<!DOCTYPE html>
<html>

<head>
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="styles/main.css">
</head>

<body>
    <header><h1><a href="index.php">Beanie Babie Shop</a></h1></header>
    <h5 id="admin-header"><a href="admin_home.php">Admin</a></h5>
    <h6><a href="customer_list.php">Back to Customer List</a></h6>
    <main>
        <h1>Order #<?php echo $edit_order_order_id; ?></h1>
        <?php foreach($allOrderProducts as $orderProduct) { ?>
            <?php 
            $getDBQuantityQuery = 'SELECT productQuantity FROM products WHERE productID = :product_id';
            $getDBQuantityStatement = $db->prepare($getDBQuantityQuery);
            $getDBQuantityStatement->bindValue(':product_id', $orderProduct['productID']);
            $getDBQuantityStatement->execute();
            $dbProductQuantity = $getDBQuantityStatement->fetchAll(PDO::FETCH_ASSOC);
            $getDBQuantityStatement->closeCursor();
            $totalProductQuantity = $dbProductQuantity[0]['productQuantity'] += (int) $orderProduct['quantity'];
            ?>

            <p>Name: <?php echo $orderProduct['productName']; ?></p>
            <form action="edit_order.php" method="post" id="edit_order_form">
                <label>Quantity:</label>
                <select name="product_quantity">
                                <?php $i = 0;
                                    while ($i < $totalProductQuantity) { ?>
                                    <?php $i++; ?>
                                    <option <?php if ($i == $orderProduct['quantity']) {echo 'selected';}?> value="<?php echo $i;?>">
                                        <?php $i;?>
                                        <?php echo $i; ?>
                                    </option>
                                <?php } ?>
                </select><br>
                <input type="hidden" name="previous_quantity"
                        value="<?php echo $orderProduct['quantity']; ?>">
                <input type="hidden" name="product_id"
                        value="<?php echo $orderProduct['productID']; ?>">
                <input type="hidden" name="cart_id"
                    value="<?php echo $edit_order_cart_id; ?>">
                <input type="hidden" name="edit_form_customer_id"
                    value="<?php echo $edit_customer_id; ?>">
                <input type="submit" value="Update"><br>
            </form>
       <?php } ?>
    </main>

    <footer>
    <p>&copy; <?php echo date("Y"); ?> Riyo Perry</p>
</footer>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>