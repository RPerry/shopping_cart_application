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
<header><h1><a href="index.php">Beanie Babie Shop</a></h1></header>
<main>
    <h3>Administrator Login</h3>
    <form action="admin_login.php" method="post" id="admin_login_form">
        Username: <input type="text" name="admin_id">
        Password: <input type="text" name="admin_password">
        <input type="hidden" name="login_error" value=<?php echo $loginError; ?> >
        <input type="submit" value="Submit">
    </form>
    <?php if ($loginError == true) {echo '<h4 style="color:red; id="login_fail">Login Failed</h4>';} ?>

</main>

<footer>
    <p>&copy; <?php echo date("Y"); ?> Riyo Perry</p>
</footer>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>