<?php

define('RESULT_USER_FOUND', 1);
define('RESULT_OK', 0);
define('RESULT_UNKNOWN_USER', -1);
define('RESULT_WRONG_PASSWORD', -2);

function getInitialLoginFormData()
{
    return  ["page" => "login", "email" => "", "emailErr" => "", "password" => "", "passwordErr" => "", "valid" => false];
}

function getLoginData()
{
    //initiate variables
    $loginData = getInitialLoginFormData();
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $loginData = validateLogin($loginData);
    }
    return $loginData;
}

function showLoginForm($loginData)
{
    echo '
    <form method="POST" action="index.php">

        <label for="email">Email:</label>
        <input type="text" name="email" id="email" value="' . $loginData['email'] . '"></br>
        <span class="error">' . $loginData['emailErr'] . '</span>
        </br></br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" value="' . $loginData['password'] . '"></br>
        <span class="error">' . $loginData['passwordErr'] . '</span>
        </br></br>

        <input hidden name="page" value="login"></input>

        <button type="submit">Login</button>
    </form>';
}

function validateLoginAttempt($loginData)
{
    $email = $loginData['email'];
    $password = $loginData['password'];

    $result = findUserByEmail($email);
    $message = $result['message'];
    $user = $result['user'];

    if ($message != RESULT_USER_FOUND) {
        $loginData['emailErr'] = "This email-adress is not registered";
        $loginData['valid'] = false;
        return $loginData;
    }

    $result = authenticateUser($user, $password);

    if ($result == RESULT_OK) {
        $name = $user[1];
        doLoginUser($name);
        $loginData['page'] = 'home';
    } else {
        $loginData['passwordErr'] = "Incorrect password";
        $loginData['valid'] = false;
    }

    return $loginData;
}
