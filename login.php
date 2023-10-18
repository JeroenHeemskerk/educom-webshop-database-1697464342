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


function showLoginForm($formData)
{
    showFormStart();
    showFormField('email', 'Email:', 'email', $formData);
    showFormField('password', 'Password:', 'password', $formData);
    showFormEnd('login', 'submit');
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
        $name = $user['name'];
        doLoginUser($name);
        $loginData['page'] = 'home';
    } else {
        $loginData['passwordErr'] = "Incorrect password";
        $loginData['valid'] = false;
    }

    return $loginData;
}
