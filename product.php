<?php

function getProductData()
{
    $userIsLoggedIn = isUserLoggedIn();
    $pageData = ["page" => "product", "product" => [], "userLoggedIn" => $userIsLoggedIn];
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

        if (getPostVar('action') == 'addToCart') {
            addToCart($product);
            $pageData['genericMessage'] = "Added " . $product['name'] . " to your shopping cart!";
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
    $userIsLoggedIn = $pageData['userLoggedIn'];
    showProduct($product, $userIsLoggedIn);
}


function addToCart($product)
{
    //als het een post is, dan voert hij deze functie uit

    $cart = $_SESSION['cart'];
    $newProduct = $product;

    // array_search: Search an array for the value and return its key
    // The array_column() function returns the values from a 
    //single column in the input array
    $column = array_column($cart, 'id');
    $found_key = array_search($newProduct['id'], $column);

    if ($found_key !== false) {
        //als de id overeenkomt, zit het product al minstens 1 keer in cart.
        $cart[$found_key]['amount'] = $cart[$found_key]['amount'] + 1;
    } else {
        // id komt niet overeen, dus product is nieuw
        $newProduct['amount'] = 1;
        // voeg product toe aan array
        array_push($cart, $newProduct);
    }

    $_SESSION['cart'] = $cart;
}

function incrementCartAmount($id)
{
    $cart = $_SESSION['cart'];
    $column = array_column($cart, 'id');
    $found_key = array_search($id, $column);

    $cart[$found_key]['amount'] = $cart[$found_key]['amount'] + 1;

    $_SESSION['cart'] = $cart;
}

function removeFromCart($id)
{
    $cart = $_SESSION['cart'];

    $column = array_column($cart, 'id');
    //in column zit nu een array met alléén de id's.
    $found_key = array_search($id, $column);
    // array_search geeft me een index terug óf false

    if (!$cart[$found_key]) {
        return;
    }

    $currentAmount = $cart[$found_key]['amount'];

    if ($currentAmount > 1) {
        $cart[$found_key]['amount'] = $cart[$found_key]['amount'] - 1;
    } else {
        //verwijder 1 array element
        array_splice($cart, $found_key, 1);
    }

    // [
    //     0 => ['id' => 4, "name" => "marbled", "pricetag" => "200", "amount" => 1],
    //     1 => ['id' => 9, "name" => "galaxy", "pricetag" => "250", "amount" => 1],
    //     2 => ['id' => 1, "name" => "orange", "pricetag" => "300", "amount" => 2],
    // ];

    $_SESSION['cart'] = $cart;
}
