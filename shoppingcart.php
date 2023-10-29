<?php

function getShoppingcartData()
{
    $pageData = ["page" => "shoppingcart", "cart" => [], "total" => 0];

    // GET of POST?
    $requestType = $_SERVER['REQUEST_METHOD'];
    if ($requestType == "POST") {

        //er zijn meerdere posts, namelijk order bevestigen. Maar addtocart en removefromcart zijn ook postrequests. 
        //write order to database
        // empty shoppingcart
        require_once("product.php");

        if (getPostVar('action') == 'addToCart') {
            $id = getPostVar('id');
            incrementCartAmount($id);
        }

        if (getPostVar('action') == 'removeFromCart') {
            $id = getPostVar('id');
            removeFromCart($id);
        }

        if (getPostVar('action') == 'completeOrder') {
            //als er op de complete order button geklikt is
            $userId = getLoggedInUserId();
            try {
                completeOrder($userId);
                $pageData['genericMessage'] = "Bedankt voor je bestelling!";
            } catch (Exception $e) {
                logError("order failed: " . $e->getMessage());
                $pageData['genericErr'] = "Bestellen is op dit moment niet mogelijk. Probeer het later nog eens.";
            }
        }
    }

    //get shoppingcart items from session 
    $cart = $_SESSION['cart'];

    //bereken het totaal

    $pageData['total'] = calculateTotal($cart);

    //========================================

    $pageData['cart'] = $cart;

    return $pageData;
}


function calculateTotal($cart)
{
    $total = 0;

    foreach ($cart as $product) {
        $totalForProduct = $product['amount'] * $product['pricetag'];
        $total = $total + $totalForProduct;
    }
    return $total;
}



function showShoppingCart($pageData)
{
    $cart = $pageData['cart'];
    $total = $pageData['total'];

    //ik weet vantevoren niet hoeveel producten er in de cart zitten.
    // Dus dan moet ik een loop schrijven

    foreach ($cart as $productLine) {
        showProductLine($productLine);
    }
    echo
    "<span>Total amount: &euro;" . number_format(($total / 100), 2, ",") . "</span></br></br>";
    require_once('form-fields.php');
    showActionButton('shoppingcart', "Complete order", 'completeOrder');
    //'completeOrder' kan ik dan uit de post body halen. 
}


function showProductLine($productLine)
{
    require_once("form-fields.php");
    echo
    "<div class='card text-center card-outer-container' style='width: 50rem'>
            <a href='index.php?page=product&id=" . $productLine['id'] . "'>
                <div class='card-inner-container'>
                    <img class='shoppingcart-img' src='" . $productLine['image_url'] . "' alt='soap image'></br>
                    <div class='product-text card-body'>
                        <h8 class='card-title'>" . $productLine['name'] . "</h8></br>
                        <span>Price: &euro;" . number_format(($productLine['pricetag'] / 100), 2, ',') . "</span></br>
                        <div class='cart-quantity-wrapper'>";
    showActionButton('shoppingcart', '-', 'removeFromCart', $productLine['id']);
    echo "<span>Amount: " . $productLine['amount'] . "</span>";
    showActionButton('shoppingcart', '+', 'addToCart', $productLine['id']);
    echo "</div> <span>Total: &euro;" . number_format(($productLine['amount'] * ($productLine['pricetag'] / 100)), 2, ",") . "</span>
                    </div>
                </div>
            </a>
        </div>";
}


function completeOrder($userId)
{
    $cart = $_SESSION['cart'];
    $total = calculateTotal($cart);
    //total is hier in centen opgeslagen

    require_once('database-connection.php');
    $orderId = writeOrderToDatabase($userId, $total);
    // in orderId zit nu de Id van de order!
    $orderlineData = getOrderlineData($orderId, $cart);

    writeOrderlinesToDatabase($orderlineData);
    $_SESSION['cart'] = [];
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
