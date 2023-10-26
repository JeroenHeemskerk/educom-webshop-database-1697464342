<?php

define('RESULT_OK', 0);
define('RESULT_WRONG_PASSWORD', -2);

function getInitialLoginFormData()
{
    return  ["page" => "login", "email" => "", "emailErr" => "", "password" => "", "passwordErr" => "", "valid" => false];
}

function getLoginData()
{
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
    require_once('database-connection.php');
    $email = $loginData['email'];
    $password = $loginData['password'];
    try {
        //user is nu een array met email, name en password OF null
        $user = findUserByEmail($email);

        if ($user == null) {
            $loginData['emailErr'] = "This email-adress is not registered";
            $loginData['valid'] = false;
            return $loginData;
        }
        require_once('user-service.php');

        $result = authenticateUser($user, $password);

        if ($result == RESULT_OK) {
            doLoginUser($user);
            $loginData['page'] = 'home';
        } else {
            $loginData['passwordErr'] = "Incorrect password";
            $loginData['valid'] = false;
        }
    } catch (Exception $e) {
        logError("authentication failed: " . $e->getMessage());
        $loginData['genericErr'] = "Inloggen is op dit moment niet mogelijk. Probeer het later nog eens.";
    }

    return $loginData;
}
