<?php

function connectToDatabase()
{
    // Create connection
    $server = 'localhost';
    $username = 'laura_web_shop_user';
    $password = 'ditiseenwachtwoord';
    $dbname = 'lauras_webshop';

    $conn = mysqli_connect($server, $username, $password, $dbname);

    if (!$conn) {
        throw new Exception("database not found");
    }

    return $conn;
}


function findUserByEmail($email)
{
    //maak een connectie
    $conn = connectToDatabase();

    try {
        $email = mysqli_real_escape_string($conn, $email);
        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = mysqli_query($conn, $sql);

        //als de query niet goed is gegaan
        if (!$result) {
            throw new Exception("select user failed, sql:$sql, error:" . mysqli_error($conn));
        }

        $response = mysqli_fetch_assoc($result);
    } finally {
        //close connection
        mysqli_close($conn);
    }

    return $response;
}


function saveUser($email, $name, $password)
{
    // Create connection
    $conn = connectToDatabase();

    $email = mysqli_real_escape_string($conn, $email);
    $name = mysqli_real_escape_string($conn, $name);
    $password = mysqli_real_escape_string($conn, $password);

    $sql = "INSERT INTO users (email, name, password)
    VALUES ('$email', '$name', '$password')";

    try {
        $result = mysqli_query($conn, $sql);

        if (!$result) {
            throw new Exception("saving user failed, sql:$sql, error" . mysqli_error($conn));
        }
    } finally {
        mysqli_close($conn);
    }
}


function getProductsFromDatabase($productIds = [])
{
    //een exception moet ín het try-blok
    //IN een try blok kan iets mis gaan
    $conn = connectToDatabase();

    $sql = 'SELECT * FROM products';

    if (!empty($productIds)) {
        $productIdsAsString = implode(",", $productIds);
        $sql = $sql . ' WHERE id IN (' . $productIdsAsString . ')';
    }

    try {
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            throw new Exception("getting products failed, sql:$sql, error" . mysqli_error($conn));
        }
        $productsData = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } finally {
        mysqli_close($conn);
    }

    //ik krijg nu een assoc array terug met 5 elementen (0 t/m 4) waarin weer 5 arrays zitten 
    // met de product-data erin. 

    return $productsData;
}


function findProductById($id)
{
    //maak een connectie
    $conn = connectToDatabase();

    try {

        $id = mysqli_real_escape_string($conn, $id);
        $sql = "SELECT * FROM products WHERE id=$id";
        $result = mysqli_query($conn, $sql);

        if (!$result) {
            throw new Exception("select product failed, sql:$sql, error:" . mysqli_error($conn));
        }

        $response = mysqli_fetch_assoc($result);
    } finally {
        //close connection
        mysqli_close($conn);
    }

    // in $response zit de assoc array van het betreffende product
    return $response;
}


function writeOrderToDatabase($userId, $total)
{
    // Create connection
    $conn = connectToDatabase();

    $sql = "INSERT INTO orders (user_id, total_amount)
    VALUES ('$userId', '$total')";


    try {
        $result = mysqli_query($conn, $sql);
        // returns id from the last query
        $orderId = mysqli_insert_id($conn);

        if (!$result) {
            throw new Exception("saving order failed, sql:$sql, error" . mysqli_error($conn));
        }
    } finally {
        mysqli_close($conn);
    }
    return $orderId;
}



function writeOrderlinesToDatabase($orderlineValuesString)
{
    // Create connection
    $conn = connectToDatabase();

    $sql = "INSERT INTO orderlines (order_id, product_id, product_quantity) 
        VALUES $orderlineValuesString";

    try {
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            throw new Exception("saving order failed, sql:$sql, error" . mysqli_error($conn));
        }
    } finally {
        mysqli_close($conn);
    }
}
