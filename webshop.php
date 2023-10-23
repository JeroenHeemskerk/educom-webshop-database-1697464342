<?php

function getWebshopData()
{
    //initiate variables
    $pageData = ['page' => 'webshop'];

    $productsData = getProductsFromDatabase();

    //$pageData is nu een array met 2 keys (page, products). In de key products zit 
    //een array (als value) met de producten. Die producten array bestaat zelf ook weer
    //uit 5 arrays. 
    $pageData['products'] = $productsData;

    return $pageData;
}


function getProductsFromDatabase()
{
    require_once('database-connection.php');
    $conn = connectToDatabase();
    $sql = "SELECT * FROM products";
    $result = mysqli_query($conn, $sql);
    $productsData = mysqli_fetch_all($result, MYSQLI_ASSOC);
    //ik krijg nu een assoc array terug met 5 elementen (0 t/m 4) waarin weer 5 arrays zitten 
    // met de product-data erin. 

    return $productsData;
}


//functie (id, productnaam, prijs, plaatje) moet allemaal variable 
// die functie moet ik daarna in een for each stoppen
// for each pagedata products as product.

function showWebshopContent($pageData)
{
    echo 'webshop pagina!';

    $productsArray = $pageData['products'];

    foreach ($productsArray as $product) {
        showProductCard($product);
    }
}


function showProductCard($product)
{
    echo
    '<a href="index.php?page=product&id=' . $product['id'] . '">
        <img src="' . $product['product image file'] . '" alt="soap image" width="500" height="600">
    </a>';

    var_dump($product);
    // Ik heb nu een array met daarin alle product arrays.
}
