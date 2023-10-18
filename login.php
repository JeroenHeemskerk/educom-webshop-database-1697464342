<?php

define('RESULT_OK', 0);
define('RESULT_WRONG_PASSWORD', -2);

function getInitialLoginFormData()
{
    return  ["page" => "login", "email" => "", "emailErr" => "", "password" => "", "passwordErr" => "", "valid" => false];
}

function getLoginData()
{
    require_once('file-repository.php');
    $loginData = getInitialLoginFormData();
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        require_once('validations.php');
        $loginData = validateLogin($loginData);
    }
    return $loginData;
}


function showLoginForm($formData)
{
    require_once('form-fields.php');
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
    require_once('user-service.php');
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
