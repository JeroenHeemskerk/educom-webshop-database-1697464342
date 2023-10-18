<?php

function getRegisterData()
{
    //initiate variables
    $registerData = ["page" => "register", "name" => "", "email" => "", "password" => "", "repeatedPassword" => "", "nameErr" => "", "emailErr" => "", "passwordErr" => "", "repeatedPasswordErr" => "", "valid" => false];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $registerData = validateRegister($registerData);

        if ($registerData['valid']) {

            $email = $registerData['email'];
            $name = $registerData['name'];
            $password = $registerData['password'];

            saveUser($email, $name, $password);
            $registerData = getInitialLoginFormData();
        }
    }
    return $registerData;
}

function showRegisterForm($formData)
{
    showFormStart();
    showFormField('name', 'Name:', 'text', $formData);
    showFormField('email', 'Email:', 'email', $formData);
    showFormField('password', 'Password:', 'password', $formData);
    showFormField('repeatedPassword', 'Repeat password:', 'password', $formData);
    showFormEnd('register', 'submit');
}
