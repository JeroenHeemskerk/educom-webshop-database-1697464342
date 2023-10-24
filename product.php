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
    showProduct($product);
}


function addToCart($product)
{
    // bedoeling is dat products die je aan je cart add in $_SESSION terecht komen

    // $_SESSION['cart']

    // opdracht: hoe zoek je in PHP naar een array met een bepaalde key/value

    // als er al een product bestaat in $_SESSION['cart'] met dezelfde product id
    // dan verhoog alleen de 'amount'
    // anders voeg nieuwe array toe met de product details van dit product, en 
    // ook key => value : amount => 1
}
