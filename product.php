<?php

function getProductData()
{
    $pageData = ["page" => "product", "product" => []];
    $requestType = $_SERVER['REQUEST_METHOD'];

    if ($requestType == "POST") {
        // in productId zit nu het juiste product ID. 
        $productId = getPostVar('id');
    } else {
        $productId = getUrlVar('id');
    }

    try {
        require_once("database-connection.php");
        //hier haal ik bijbehorende data (van de id) op
        $product = findProductById($productId);

        //hier heb ik de product-data, hier opnieuw kijken of het een post is.
        // Dan logica voor 'add to cart' schrijven. 
        if ($requestType == "POST") {
            addToCart($product);
        }

        $pageData["product"] = $product;
    } catch (Exception $e) {
        logError("getting product failed: " . $e->getMessage());
        $pageData['genericErr'] = "Er is een technisch probleem. Probeer het later nog eens.";
    }

    return $pageData;
}

function showProductContent($pageData)
{
    require_once('form-fields.php');
    $product = $pageData['product'];
    echo "<img src='" . $product['image_url'] . "' alt='soap image' width='400' height='300'></br>";
    echo $product["name"] . "</br>";
    echo $product["description"] . "</br>";
    echo "&#8364;" . ($product['pricetag'] / 100) . "</br>";

    showFormStart();
    echo "<input hidden name='id' value='" . $product['id'] . "'>";
    showFormEnd('product', 'add to cart');
}


function addToCart($product)
{
}
