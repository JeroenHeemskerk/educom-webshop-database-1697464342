<?php
define("SERVER_NAME", "localhost");
define("USER_NAME", "laura_web_shop_user");
define("PASSWORD", "ditiseenwachtwoord");
define("DB_NAME", "lauras_webshop");

define('RESULT_UNKNOWN_USER', -1);
define('RESULT_USER_FOUND', 1);


function findUserByEmail($email)
{
    // Create connection
    $conn = mysqli_connect(SERVER_NAME, USER_NAME, PASSWORD, DB_NAME);

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM users WHERE email='$email'";

    $result = mysqli_query($conn, $sql);

    // in $user zit nu een associative array met de juiste user
    // (met id, naam, email en password), of NULL
    $user = mysqli_fetch_assoc($result);

    // creeer een default response
    $response = ["message" => RESULT_UNKNOWN_USER, "user" => []];

    if ($user != null) {
        $response["message"] = RESULT_USER_FOUND;
        $response["user"] = $user;
    }

    mysqli_close($conn);

    return $response;
}





// $sql = "INSERT INTO users (id, email, name, password)
// VALUES ('3', 'sjaak@hotmail.com', 'sjaak', 'sjaakie123')";

// if (mysqli_query($conn, $sql)) {
//     echo "New record created successfully!";
// } else {
//     echo "Error: " . $sql . "<br>" . mysqli_error($conn);
// }
