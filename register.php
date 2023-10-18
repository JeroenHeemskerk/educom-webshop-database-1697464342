<?php

function getRegisterData()
{
    //initiate variables
    $pageData = ["page" => "register", "name" => "", "email" => "", "password" => "", "repeatedPassword" => "", "nameErr" => "", "emailErr" => "", "passwordErr" => "", "repeatedPasswordErr" => "", "valid" => false];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        require_once('validations.php');
        $pageData = validateRegister($pageData);
    }

    return $pageData;
}

function showRegisterForm($formData)
{
    require_once('form-fields.php');
    showFormStart();
    showFormField('name', 'Name:', 'text', $formData);
    showFormField('email', 'Email:', 'email', $formData);
    showFormField('password', 'Password:', 'password', $formData);
    showFormField('repeatedPassword', 'Repeat password:', 'password', $formData);
    showFormEnd('register', 'Submit');
}
