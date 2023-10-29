<?php

function handleActions($pageData)
{
    require_once("session-manager.php");
    $action = getPostVar("action");
    switch ($action) {
        case "addToCart":
            $productId = getPostVar("id");
            addToCart($productId);
            $pageData['genericMessage'] = "Added item to your shopping cart!";
            break;
        case "removeFromCart":
            $productId = getPostVar("id");
            removeFromCart($productId);
            $pageData['genericMessage'] = "Removed item from your shopping cart!";
            break;
        case "completeOrder":
            require_once("database-connection.php");
            $userId = getLoggedInUserId();
            try {
                completeOrder($userId);
                $pageData['genericMessage'] = "Bedankt voor je bestelling!";
            } catch (Exception $e) {
                logError("order failed: " . $e->getMessage());
                $pageData['genericErr'] = "Bestellen is op dit moment niet mogelijk. Probeer het later nog eens.";
            }
            break;
        default:
            return $pageData;
    }

    return $pageData;
}

function completeOrder($userId)
{
    $cart = getCart();
    //total is hier in centen opgeslagen
    $total = 0;
    $productIds = array_keys($cart);
    require_once("database-connection.php");
    $products = getProductsFromDatabase($productIds);
    $orderLines = [];

    foreach ($cart as $productId => $amount) {
        // zoek naar de juiste index voor dit product
        $column = array_column($products, 'id');
        $index = array_search($productId, $column);

        $product = $products[$index];
        $total += $amount * $product['pricetag'];
        array_push($orderLines, ['id' => $product['id'], 'amount' => $amount]);
    }

    $orderId = writeOrderToDatabase($userId, $total);
    // in orderId zit nu de Id van de order!
    $orderlineData = getOrderlineData($orderId, $orderLines);

    writeOrderlinesToDatabase($orderlineData);
    initializeCart();
}

function getOrderlineData($orderId, $cart)
{
    // in orderline moet zitten: order_id, product_id, product quantity. 
    $orderlineValueArray = [];

    foreach ($cart as $productline) {
        $orderline = "($orderId, " . $productline['id'] . ", " . $productline['amount'] . " )";

        array_push($orderlineValueArray, $orderline);
    }

    $orderlineValuesString = implode(',', $orderlineValueArray);

    return $orderlineValuesString;
}
