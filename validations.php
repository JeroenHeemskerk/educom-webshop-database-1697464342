<?php

// Hier komen alle validaties

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function validateLogin($loginData)
{
    if (empty(getPostVar("email"))) {
        $loginData['emailErr'] = "*Email is required";
    } else {
        $loginData['email'] = test_input(getPostVar("email"));
        // check if e-mail address is well-formed
        if (!filter_var($loginData['email'], FILTER_VALIDATE_EMAIL)) {
            $loginData['emailErr'] = "*Invalid email format";
        }
    }

    if (empty(getPostVar("password"))) {
        $loginData['passwordErr'] = "*Password is required";
    } else {
        $loginData['password'] = test_input(getPostVar("password"));
    }


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
    if (empty(getPostVar("name"))) {
        $registerData['nameErr'] = "*Name is required";
    } else {
        $registerData['name'] = test_input(getPostVar("name"));
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z-' ]*$/", $registerData['name'])) {
            $registerData['nameErr'] = "*Only letters and white space allowed";
        }
    }

    if (empty(getPostVar("email"))) {
        $registerData['emailErr'] = "*Email is required";
    } else {
        require_once('user-service.php');
        $registerData['email'] = test_input(getPostVar("email"));
        // check if e-mail address is well-formed
        if (!filter_var($registerData['email'], FILTER_VALIDATE_EMAIL)) {
            $registerData['emailErr'] = "*Invalid email format";
        } else if (doesEmailExist($registerData['email'])) {
            $registerData['emailErr'] = "*This emailadress is already registered";
        }
    }

    if (empty(getPostVar("password"))) {
        $registerData['passwordErr'] = "*Password is required";
    } else {
        $registerData['password'] = test_input(getPostVar("password"));
    }

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
    if (empty(getPostVar('salutation'))) {
        $contactData['salutationErr'] = "*Salutation is required";
    } else {
        $contactData['salutation'] = test_input(getPostVar("salutation"));
    }

    if (empty(getPostVar("name"))) {
        $contactData['nameErr'] = "*Name is required";
    } else {
        $contactData['name'] = test_input(getPostVar("name"));
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z-' ]*$/", $contactData['name'])) {
            $contactData['nameErr'] = "*Only letters and white space allowed";
        }
    }

    if (empty(getPostVar("email"))) {
        $contactData['emailErr'] = "*Email is required";
    } else {
        $contactData['email'] = test_input(getPostVar("email"));
        // check if e-mail address is well-formed
        if (!filter_var($contactData['email'], FILTER_VALIDATE_EMAIL)) {
            $contactData['emailErr'] = "*Invalid email format";
        }
    }

    if (empty(getPostVar("phonenumber"))) {
        $contactData['phonenumberErr'] = "*Phonenumber is required";
    } else {
        $contactData['phonenumber'] = test_input(getPostVar("phonenumber"));
    }

    if (empty(getPostVar("comm_preference"))) {
        $contactData['comm_preferenceErr'] = "*Communication preference is required";
    } else {
        $contactData['comm_preference'] = test_input(getPostVar("comm_preference"));
    }

    if (empty(getPostVar("message"))) {
        $contactData['messageErr'] = "*Message is required";
    } else {
        $contactData['message'] = test_input(getPostVar("message"));
    }

    if (empty($contactData['salutationErr']) && empty($contactData['nameErr']) && empty($contactData['emailErr']) && empty($contactData['phonenumberErr']) && empty($contactData['comm_preferenceErr']) && empty($contactData['messageErr'])) {
        $contactData['valid'] = true;
    } else {
        $contactData['valid'] = false;
    }

    return $contactData;
}
