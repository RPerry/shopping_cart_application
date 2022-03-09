<?php 
require_once('database.php');

$format = filter_input(INPUT_GET, 'format');
$action = filter_input(INPUT_GET, 'action');

$product_name = filter_input(INPUT_GET, 'name');
$product_min = (float)filter_input(INPUT_GET, 'min');
$product_max = (float)filter_input(INPUT_GET, 'max');

if ($action == "products") {
    // getting all products from products db and ordering the results by productid and storing them in the $products variable
    $productQuery = 'SELECT * FROM products ORDER BY productID';
    $productStatement = $db->prepare($productQuery);
    $productStatement ->execute();
    $allProducts = $productStatement ->fetchAll(PDO::FETCH_ASSOC);
    $productStatement ->closeCursor();
} elseif ($action == "productName") {
    $productNameQuery = 'SELECT * FROM products WHERE productName = :product_name ORDER BY productID';
    $productNameStatement = $db->prepare($productNameQuery);
    $productNameStatement->bindValue(':product_name', $product_name);
    $productNameStatement->execute();
    $productByName = $productNameStatement->fetchAll(PDO::FETCH_ASSOC);
    $productNameStatement->closeCursor();
} elseif ($action == "productPrice") {
    $productPriceQuery = 'SELECT * FROM products WHERE productPrice >= :product_min AND productPrice <= :product_max
    ORDER BY productID';
    $productPriceStatement = $db->prepare($productPriceQuery);
    $productPriceStatement->bindValue(':product_min', $product_min);
    $productPriceStatement->bindValue(':product_max', $product_max);
    $productPriceStatement->execute();
    $productsByPrice = $productPriceStatement->fetchAll(PDO::FETCH_ASSOC);
    $productPriceStatement->closeCursor();
}

function xmlDataFormatting($productData, $xmlDoc) {
    $xml_products = $xmlDoc->createElement("products");

        foreach ($productData as $product) {
            $xml_product = $xmlDoc->createElement("product");
            
            $xml_product_id = $xmlDoc->createElement("productID", $product["productID"]);
            $xml_product->appendChild( $xml_product_id );
            $xml_product_name = $xmlDoc->createElement("productName", $product["productName"]);
            $xml_product->appendChild( $xml_product_name );
            $xml_product_description = $xmlDoc->createElement("productDescription", $product["productDescription"]);
            $xml_product->appendChild( $xml_product_description );
            $xml_product_price = $xmlDoc->createElement("productPrice", $product["productPrice"]);
            $xml_product->appendChild( $xml_product_price );
            $xml_product_quantity = $xmlDoc->createElement("productQuantity", $product["productQuantity"]);
            $xml_product->appendChild( $xml_product_quantity );

            $xml_products->appendChild( $xml_product );
        }
        $xmlDoc->appendChild( $xml_products );
        return $xmlDoc->saveXML();
}

if ($format == "json") {
    header( "content-type: application/json; charset=ISO-8859-15" );
    if ($action == "products") {
        echo json_encode($allProducts, JSON_PRETTY_PRINT);
    } elseif ($action == "productName") {
        echo json_encode($productByName, JSON_PRETTY_PRINT);
    } elseif ($action == "productPrice") {
        echo json_encode($productsByPrice, JSON_PRETTY_PRINT);
    }
} elseif ($format == "xml") {
    header( "content-type: application/xml; charset=ISO-8859-15" );

    $xmlDoc = new DOMDocument( "1.0", "ISO-8859-15" );
    $xmlDoc->preserveWhiteSpace = false;
    $xmlDoc->formatOutput = true;

    if ($action == "products") {
        echo xmlDataFormatting($allProducts, $xmlDoc);
    } elseif ($action == "productName") {
        echo xmlDataFormatting($productByName, $xmlDoc);
    } elseif ($action == "productPrice") {
        echo xmlDataFormatting($productsByPrice, $xmlDoc);
    }
}
?>