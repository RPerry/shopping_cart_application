
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
        <h1>Add Product</h1>
        <form action="add_product.php" method="post"
              id="add_product">

            <label>Name:</label>
            <input type="text" name="product_name" ><br>

            <label>Description:</label>
            <input type="text" name="product_description"><br>

            <label>Price:</label>
            <input type="text" name="product_price"><br>

            <label>Quantity:</label>
            <input type="text" name="product_quantity"><br>

            <input type="submit" value="Add Product"><br>
        </form>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Riyo Perry</p>
    </footer>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>
</html>

