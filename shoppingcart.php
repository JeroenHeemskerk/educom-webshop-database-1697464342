<?php

function initializeShoppingcartData()
{
    return ["page" => "shoppingcart", "cart" => [], "total" => 0];
}

function getShoppingcartData($pageData)
{

    try {
        $cart = getCart();
        $productIds = array_keys($cart);
        require_once("database-connection.php");
        $products = getProductsFromDatabase($productIds);

        foreach ($cart as $productId => $amount) {
            // zoek naar de juiste index voor dit product
            $column = array_column($products, 'id');
            $index = array_search($productId, $column);

            $product = $products[$index];
            $subTotal = $amount * $product['pricetag'];
            $pageData['total'] += $subTotal;
            array_push($pageData['cart'], ['id' => $product['id'], 'name' => $product['name'], 'amount' => $amount, 'subTotal' => $subTotal, 'pricetag' => $product['pricetag'], 'image_url' => $product['image_url']]);
        }
    } catch (Exception $e) {
        logError("getting products failed: " . $e->getMessage());
        $pageData['genericErr'] = "Er is een technisch probleem. Probeer het later nog eens.";
    }

    return $pageData;
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
    echo "</div> <span>Total: &euro;" . number_format((($productLine['subTotal'] / 100)), 2, ",") . "</span>
                    </div>
                </div>
            </a>
        </div>";
}
