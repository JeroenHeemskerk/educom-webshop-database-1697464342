<?php

// Maak een pagina 'shoppingcart' aan die een overzicht geeft van de in de sessie 
//bewaarde items (inclusief sub-totaal en een klein plaatje) en een berekening van 
//de totale prijs.
//Als je op de regel klikt dan ga je naar de 'detail' pagina van dit product. 
//(Optioneel) kan je nog toevoegen dat je in de shoppingcart pagina het aantal bestelde 
//producten kan verhogen of verlagen.

// tweede variabele met $amount

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
            //
        }
    }


    //get shoppingcart items from session 
    $cart = $_SESSION['cart'];

    //bereken het totaal
    $total = 0;

    foreach ($cart as $product) {
        $totalForProduct = $product['amount'] * $product['pricetag'];
        $total = $total + $totalForProduct;
    }

    $pageData['total'] = $total;

    //========================================

    $pageData['cart'] = $cart;

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
    "<span>Total amount: &euro;" . number_format(($total / 100), 2, ",") . "</span>";
}


function showProductLine($productLine)
{
    require_once("form-fields.php");
    echo
    "<div class='card text-center card-outer-container' style='width: 50rem'>
            <a href='index.php?page=product&id=" . $productLine['id'] . "'>
                <div class='card-inner-container'>
                    <img class='shoppingcart-img' src='" . $productLine['image_url'] . "' alt='soap image'></br>
                    <div class ='product-text card-body'>
                        <h8 class = 'card-title'>" . $productLine['name'] . "</h8></br>
                        <span>Price: &euro;" . number_format(($productLine['pricetag'] / 100), 2, ',') . "</span></br>";
    showActionButton('shoppingcart', '-', 'removeFromCart', $productLine['id']);
    echo "<span>Amount: " . $productLine['amount'] . "</span></br>";
    showActionButton('shoppingcart', '+', 'addToCart', $productLine['id']);
    echo "<span>Total: &euro;" . number_format(($productLine['amount'] * ($productLine['pricetag'] / 100)), 2, ",") . "</span>
                    </div>
                </div>
            </a>
        </div>";
}


//eerst record in order wegschrijven
// dan id opvragen en dat gebruiken