<?php

function initializeWebshopData()
{
    return ['page' => 'webshop', 'products' => []];
}

function getWebshopData($pageData)
{
    require_once('database-connection.php');
    try {

        $productsData = getProductsFromDatabase();

        //$pageData is nu een array met 2 keys (page, products). In de key products zit 
        //een array (als value) met de producten. Die producten array bestaat zelf ook weer
        //uit 5 arrays. 
        $pageData['products'] = $productsData;
    } catch (Exception $e) {
        logError("getting products failed: " . $e->getMessage());
        $pageData['genericErr'] = "Er is een technisch probleem. Probeer het later nog eens.";
    }

    return $pageData;
}


function showWebshopContent($pageData)
{

    $productsArray = $pageData['products'];

    foreach ($productsArray as $product) {
        showProductCard($product);
    }
}


function showProductCard($product)
{
    require_once('session-manager.php');
    require_once('form-fields.php');
    $userIsLoggedIn = isUserLoggedIn();

    echo
    "<div class='card text-center card-outer-container' style='width: 50rem'>
        <a href='index.php?page=product&id=" . $product['id'] . "'>
            <div class='card-inner-container'>
                <img class='card-img' src='" . $product['image_url'] . "' alt='soap image'></br>
                <div class ='product-text card-body'>
                    <h4 class = 'card-title'>" . $product['name'] . "</h4>
                    <p class = 'card-text'> " . $product['description'] . "</p>
                    <span>&euro;" . number_format(($product['pricetag'] / 100), 2, ',') . "</span>";
    if ($userIsLoggedIn) {
        showActionButton('webshop', 'add to cart', 'addToCart', $product["id"]);
    }
    echo "
                </div>
            </div>
        </a>
    </div>";
}
