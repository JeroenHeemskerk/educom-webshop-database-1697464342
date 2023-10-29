<?php

function  initializeProductData()
{
    require_once("session-manager.php");
    $userIsLoggedIn = isUserLoggedIn();
    return ["page" => "product", "product" => [], "userLoggedIn" => $userIsLoggedIn];
}

function getProductData($pageData)
{
    $requestType = $_SERVER['REQUEST_METHOD'];

    if ($requestType == "POST") {
        // in productId zit nu het juiste product ID (de value). 
        $productId = getPostVar('id');
    } else {
        $productId = getUrlVar('id');
    }

    try {
        require_once("database-connection.php");
        //hier haal ik bijbehorende data (van de id) op.
        // in $product zit nu de assoc array van het product.
        $product = findProductById($productId);
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
    $userIsLoggedIn = $pageData['userLoggedIn'];
    showProduct($product, $userIsLoggedIn);
}


function showProduct($product, $userIsLoggedIn)
{
    echo "<div class='card-body'> <img class = 'product-img' src='" . $product['image_url'] . "' alt='soap image' width='400' height='300'></br>
    <h4 class = 'card-title'>" . $product["name"] . "</h4></br>
    <p class = 'card-text'>" . $product["description"] . "</p></br>
    &#8364;" . number_format(($product['pricetag'] / 100), 2, ',') . "</br> </div>";
    //button gedeelte conditioneel gemaakt
    if ($userIsLoggedIn) {
        showActionButton('product', 'add to cart', 'addToCart', $product["id"]);
    }
    //maak een extra hidden input, geef hem als naam: action en als value 'addToCart'
}
