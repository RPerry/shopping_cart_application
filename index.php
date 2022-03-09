<?php
require_once('database.php');
// getting all products from products db and ordering the results by productid and storing them in the $products variable
$query = 'SELECT * FROM products ORDER BY productID';
$statement = $db->prepare($query);
$statement->execute();
$products = $statement->fetchAll();
$statement->closeCursor();

// creating a new cart and getting the newly created carts ID

if (!isset($cart_id)) {
    $newCartQuery = 'INSERT INTO carts VALUES ()';
    $newCartStatement = $db->prepare($newCartQuery);
    $newCartStatement->execute();
    $cart_id = $db->lastInsertId();
    $newCartStatement->closeCursor();
}


// getting all cart products and storing in the cart_products variable
$getCartItemsQuery = 'SELECT * FROM cart_products WHERE cartID = :cart_id';
$getCartItemsStatement = $db->prepare($getCartItemsQuery);
$getCartItemsStatement->bindValue(':cart_id', $cart_id);
$getCartItemsStatement->execute();
$cart_products = $getCartItemsStatement->fetchAll();
$getCartItemsStatement->closeCursor();


            
$searchQuery = 'SELECT * FROM products WHERE productName 
        LIKE CONCAT("%", :searchData, "%") OR productDescription LIKE CONCAT("%", :searchData, "%") ORDER BY productID';
$searchStatement = $db->prepare($searchQuery);
$searchStatement->bindValue(':searchData', $searchData);
$searchStatement->execute();
$testproducts = $searchStatement->fetchAll();
$searchStatement->closeCursor();

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
    <h1><a href="index.php">Beanie Baby Shop</a></h1>
    <h5 id="admin-header"><a href="admin_login_form.php">Admin</a></h5>
    <h6 id="cust_orders" style="float:right; padding-top: 5px;"><a href="all_customer_orders.php">See All Orders</a></h6>
</header>
<main>
    <section style="padding-top: 10px;">
        <form method="post" action="" id="search">
            Search: <input type="text" name="search_data"><br>
            <input type="hidden" name="cart_id" value="<?php echo $cart_id; ?>" >
                <input type="submit" value="Go" name="Go">
        </form>
        <?php
            if(isset($_POST['Go'])) {
                $searchData = filter_input(INPUT_POST, 'search_data');
                $currentCart = filter_input(INPUT_POST, 'cart_id');
                $searchQuery = 'SELECT * FROM products WHERE productName 
                        LIKE CONCAT("%", :searchData, "%") OR productDescription LIKE CONCAT("%", :searchData, "%") ORDER BY productID';
                $searchStatement = $db->prepare($searchQuery);
                $searchStatement->bindValue(':searchData', $searchData);
                $searchStatement->execute();
                $products = $searchStatement->fetchAll();
                $searchStatement->closeCursor();
                $cart_id = $currentCart;
            } 
        ?>
        
    </section>
    <center><h1>Products</h1></center>
    <?php if(count($cart_products) > 0) { ?>  
    <section style="float:right;">
        <!-- display a carts items -->
        <h2>Cart</h2>
        <table class="table">
            <?php foreach ($cart_products as $cart_product) : ?>
                <tr>
                <td>
                    <?php echo $cart_product['productName']; ?>
                </td>
                <td>
                    <?php echo $cart_product['quantity']; ?>
                </td>
                <td>
                <form action="delete_cart_product.php" method="post" id="delete_item">
                    <input type="hidden" name="cartproduct_id" value="<?php echo $cart_product["cartProductID"]; ?>">
                    <input type="hidden" name="cart_id" value="<?php echo $cart_product["cartID"]; ?>">
                    <input type="submit" value="Delete">
                </form> 
                </td>
                </tr>
            <?php endforeach; ?>
        </table>     
            <form action="order.php" method="post" id="order">
            Please Enter Your Customer ID: <input type="text" name="customer_id"><br>
                <input type="hidden" name="cart_id" value="<?php echo $cart_id; ?>">
                <input type="submit" value="Order">
            </form>
            <br>
            <br>
            <?php } ?>
            <section>
                <h3 class="gAlert" style="color:#20B2AA; float:right;"><?php echo $orderAlert ?></h3>
            </section>
    </section>
    <section class="products" style="padding-right:500px;">
        <!-- display a table of Products -->
        <table class="table">
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Quantity to Purchase</th>
                <th></th>
            </tr>

            <?php foreach ($products as $product) : ?>
            <tr>
                <td><?php echo $product['productName']; ?></td>
                <td><?php echo $product['productDescription']; ?></td>
                <td>$<?php echo $product['productPrice']; ?></td>
                <td><?php echo $product['productQuantity']; ?></td>
                <td>
                    <form action="add_product_to_cart.php" method="post" id="add_product_to_cart_form">
                        <select name="product_quantity">
                            <?php $i = 0;
                                while ($i < $product['productQuantity']) { ?>
                                <?php $i++; ?>
                                <option value="<?php echo $i;?>">
                                    <?php $i;?>
                                    <?php echo $i; ?>
                                </option>
                            <?php } ?>
                        </select><br>
                <td>
                        <input type="hidden" name="cart_id"
                            value="<?php echo $cart_id; ?>">
                        <input type="hidden" name="product_name"
                            value="<?php echo $product['productName']; ?>">
                        <input type="hidden" name="product_id"
                            value="<?php echo $product['productID']; ?>">
                        <?php if($product['productQuantity'] > 0) { ?>
                            <input type="submit" value="Add to Cart">
                        <?php } else {
                            echo "Sold Out";
                        } ?>
                    </form>
                </td>
            </tr> 
            <?php endforeach; ?>   
        </table>

    </section>
</main>

<footer>
    <p>&copy; <?php echo date("Y"); ?> Riyo Perry</p>
</footer>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>