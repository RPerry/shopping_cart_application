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
    <h6 id="cust_orders" style="float:right; padding-top: 5px;"><a href="all_customer_orders.php">See All Orders</a></h6>
</header>
    <main>
        <h1>Database Error</h1>
        <p>There was an error connecting to the database.</p>
        <p>Error message: <?php echo $error_message; ?></p>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Riyo Perry</p>
    </footer>
</body>
</html>