<?php

function getWebshopData()
{
    //initiate variables
    $pageData = ['page' => 'webshop', 'products' => []];
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
    echo
    "<div>
        <a href='index.php?page=product&id=" . $product['id'] . "'>
            <img src='" . $product['image_url'] . "' alt='soap image' width='400' height='300'></br>
            <span>" . $product['name'] . "</span>
            <p> " . $product['description'] . "</p>
            <span>&#8364;" . ($product['pricetag'] / 100) . "</span>
        </a>
        </div>";
}
