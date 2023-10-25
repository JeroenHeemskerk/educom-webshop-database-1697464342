<?php

// Hier komen alle validaties

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


function collectRequiredField($data, $key, $label)
{
    $data[$key] = test_input(getPostVar($key));
    if (empty($data[$key])) {
        $data[$key . 'Err'] = "*$label is required";
    }
    return $data;
}

function collectAndValidateEmail($data, $key, $label)
{
    $data = collectRequiredField($data, $key, $label);
    // check if e-mail address is well-formed 
    if (empty($data[$key . 'Err']) && !filter_var($data[$key], FILTER_VALIDATE_EMAIL)) {
        $data[$key . 'Err'] = "*Invalid email format";
    }
    return $data;
}

function collectAndValidateName($data, $key, $label)
{
    $data = collectRequiredField($data, $key, $label);

    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z-' ]*$/", $data[$key])) {
        $data[$key . 'Err'] = "*Only letters and white space allowed";
    }
    return $data;
}

//====================================================

function validateLogin($loginData)
{
    $loginData = collectAndValidateEmail($loginData, "email", "Email");
    $loginData = collectRequiredField($loginData, 'password', "Password");

    $loginData['valid'] = empty($loginData['emailErr']) && empty($loginData['passwordErr']);

    if ($loginData['valid'] == true) {
        $loginData = validateLoginAttempt($loginData);
    }

    if ($loginData['valid'] == true) {
        $loginData['page'] = 'home';
    }

    return $loginData;
}

function validateRegister($registerData)
{
    $registerData = collectAndValidateName($registerData, "name", "Name");
    $registerData = collectAndValidateEmail($registerData, "email", "Email");
    $registerData = collectRequiredField($registerData, "password", "Password");

    if (empty(getPostVar("repeatedPassword"))) {
        $registerData['repeatedPasswordErr'] = "*Password is required";
    } else {
        $registerData['repeatedPassword'] = test_input(getPostVar("repeatedPassword"));
        if ($registerData['password'] != $registerData['repeatedPassword']) {
            $registerData['passwordErr'] = $registerData['repeatedPasswordErr'] = "*Passwords do not match";
        }
    }

    $registerData['valid'] = empty($registerData['nameErr']) && empty($registerData['emailErr']) && empty($registerData['passwordErr']) && empty($registerData['repeatedPasswordErr']);

    return $registerData;
}

function validateContact($contactData)
{
    // validate for the 'POST' data

    $contactData = collectRequiredField($contactData, "salutation", "Salutation");
    $contactData = collectAndValidateName($contactData, "name", "Name");
    $contactData = collectAndValidateEmail($contactData, "email", "Email");
    $contactData = collectRequiredField($contactData, "phonenumber", "Phonenumber");
    $contactData = collectRequiredField($contactData, "comm_preference", "Communication preference");
    $contactData = collectRequiredField($contactData, "message", "Message");

    if (empty($contactData['salutationErr']) && empty($contactData['nameErr']) && empty($contactData['emailErr']) && empty($contactData['phonenumberErr']) && empty($contactData['comm_preferenceErr']) && empty($contactData['messageErr'])) {
        $contactData['valid'] = true;
    } else {
        $contactData['valid'] = false;
    }

    return $contactData;
}
