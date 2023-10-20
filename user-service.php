<?php

function authenticateUser($user, $password)
{
    if (trim($user['password']) == $password) {
        $result = RESULT_OK;
    } else {
        $result = RESULT_WRONG_PASSWORD;
    }

    return $result;
}

function doesEmailExist($email)
{
    require_once('database-connection.php');
    $result = findUserByEmail($email);

    return $result != null;
}
