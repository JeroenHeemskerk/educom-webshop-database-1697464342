<?php
define('RESULT_UNKNOWN_USER', -1);
define('RESULT_USER_FOUND', 1);

function findUserByEmail($email)
{
    $usersfile = fopen("users/users.txt", "r") or die("Unable to open file!");
    $result = ["message" => RESULT_UNKNOWN_USER, "user" => []];
    fgets($usersfile); // Ik pak hier de eerste 'line' en sla hem niet op, zodat hij hierna bij line 2 begint. 

    // Hieronder staat: Zolang je niet aan het einde van het document bent, lees en output steeds 1 line.
    while (!feof($usersfile)) {
        $line = fgets($usersfile);

        $parts = explode("|", $line, 3); // Elke losse regel is nu een array met 3 elementen (element 0 = email)

        if ($parts[0] == $email) {
            $result["message"] = RESULT_USER_FOUND;
            $result["user"] = ['email' => $parts[0], 'name' => $parts[1], 'password' => $parts[2]];
            break;
        }
    }

    fclose($usersfile);
    return $result;
}

function saveUser($email, $name, $password)
{
    $usersfile = fopen("<users/users.txt", "a") or die("Unable to open file!");
    $user = PHP_EOL . "$email|$name|$password";
    fwrite($usersfile, $user);
    fclose($usersfile);
}
