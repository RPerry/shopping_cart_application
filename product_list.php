<?php
require_once('database.php');

// getting productID of selected product
if (!isset($product_id)) {
    $product_id = filter_input(INPUT_GET, 'product_id');
    $productUpdateAlert = "";
    if ($product_id == NULL || $product_id == FALSE) {
        // displaying the first product by id before admin has chosen one to view
        $firstProductQuery = 'SELECT * FROM products ORDER BY productID';
        $firstProductStatement = $db->prepare($firstProductQuery);
        $firstProductStatement->execute();
        $allProductsForFirst = $firstProductStatement->fetchAll();
        $firstProductStatement->closeCursor();
        $product_id = $allProductsForFirst[0]['productID'];
    }
}

// getting all products from products table and ordering the results by product id and storing them in the $allProducts variable
$allProductsQuery = 'SELECT * FROM products ORDER BY productID';
$allProductsStatement = $db->prepare($allProductsQuery);
$allProductsStatement->execute();
$allProducts = $allProductsStatement->fetchAll();
$allProductsStatement->closeCursor();

// Get selected product 
$productQuery= 'SELECT * FROM products WHERE productID = :product_id';
$productStatement = $db->prepare($productQuery);
$productStatement->bindValue(':product_id', $product_id);
$productStatement->execute();
$selectedProduct = $productStatement->fetch();
$productStatement->closeCursor();
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
    <h5 id="add_product_bttn"><a href="add_product_form.php" style="color:gray; float:right;">Add a Product</a></h5>
    <main>
    <section>
    <aside>
        <!-- Displaying list of all Products -->
        <h2>All Products</h2>
        <nav>
            <ul>
                <?php foreach ($allProducts as $product) : ?>
                    <li>
                        <a style="color:#00008B;" href="./product_list.php?product_id=<?php echo $product['productID']; ?>">
                            <?php echo $product['productName']; ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>
    </aside>
    </section>

    <section>
        <h2><?php echo $selectedProduct['productName']; ?></h2>
        <!-- For each product, displaying info  -->
        <table class="table">
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Quantity</th>
                <th></th>
                <th></th>
            </tr>
            <tr>
                <td><?php echo $selectedProduct['productName']; ?></td>
                <td><?php echo $selectedProduct['productDescription']; ?></td>
                <td>$<?php echo $selectedProduct['productPrice']; ?></td>
                <td><?php echo $selectedProduct['productQuantity']; ?></td>
                <td>
                    <form action="edit_product_form.php" method="post" id="edit_product_form">
                        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                        <input type="submit" value="Edit">
                    </form>       
                <td>
                <td>
                    <form action="delete_product.php" method="post" id="delete_product">
                        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                        <input type="submit" value="Delete">
                    </form>  
                </td>
            </tr> 
        </table>
    </section>
    <section>
        <h3 class="gAlert" style="color:#20B2AA;"><?php echo $productUpdateAlert ?></h3>
    </section>
    </main>
</body>

<footer>
    <p>&copy; <?php echo date("Y"); ?> Riyo Perry</p>
</footer>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>