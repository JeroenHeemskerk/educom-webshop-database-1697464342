<?php
$servername = "localhost";
$username = "laura_web_shop_user";
$password = "ditiseenwachtwoord";
$dbname = "lauras_webshop";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully!";


// $sql = "INSERT INTO users (id, email, name, password)
// VALUES ('3', 'sjaak@hotmail.com', 'sjaak', 'sjaakie123')";

$sql = "SELECT * FROM users";
// echo $sql;


$result = mysqli_query($conn, $sql);
foreach ($result as $row) {
    var_dump($row);
    // do something with each row
}




// if (mysqli_query($conn, $sql)) {
//     echo "New record created successfully!";
// } else {
//     echo "Error: " . $sql . "<br>" . mysqli_error($conn);
// }

mysqli_close($conn);
