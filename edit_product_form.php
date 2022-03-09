<?php
require('database.php');


$edit_product_id = (int) filter_input(INPUT_POST, 'product_id');

$editProductQuery = 'SELECT * FROM products WHERE productID = :product_id';
$editProductStatement = $db->prepare($editProductQuery);
$editProductStatement->bindValue(':product_id', $edit_product_id);
$editProductStatement->execute();
$productForEdit = $editProductStatement->fetchAll(PDO::FETCH_ASSOC);
$editProductStatement->closeCursor();

?>
<!DOCTYPE html>
<html>

<head>
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="styles/main.css">
</head>

<body>
    <header><h1>Beanie</h1></header>

    <main>
        <h1>Edit <?php echo $productForEdit[0]['productName']; ?></h1>
        <form action="edit_product.php" method="post"
              id="edit_product_form">

            <label>Name:</label>
            <input type="text" name="product_name" value="<?php echo $productForEdit[0]["productName"]; ?>"><br>

            <label>Description:</label>
            <input type="text" name="product_description" value="<?php echo $productForEdit[0]['productDescription']; ?>"><br>

            <label>Price:</label>
            <input type="text" name="product_price" value="<?php echo $productForEdit[0]['productPrice']; ?>"><br>

            <label>Quantity:</label>
            <select name="product_quantity">
                            <?php $i = 0;
                                while ($i < 50) { ?>
                                <?php $i++; ?>
                                <option <?php if ($i == $productForEdit[0]['productQuantity']) {echo 'selected';}?> value="<?php echo $i;?>">
                                    <?php $i;?>
                                    <?php echo $i; ?>
                                </option>
                            <?php } ?>
            </select><br>
            <input type="hidden" name="product_id"
                    value="<?php echo $productForEdit[0]['productID']; ?>">
            <input type="submit" value="Update"><br>
        </form>
    </main>

    <footer>
    <p>&copy; <?php echo date("Y"); ?> Riyo Perry</p>
</footer>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>