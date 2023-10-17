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
    if (empty($_POST["email"])) {
        $loginData['emailErr'] = "*Email is required";
    } else {
        $loginData['email'] = test_input($_POST["email"]);
        // check if e-mail address is well-formed
        if (!filter_var($loginData['email'], FILTER_VALIDATE_EMAIL)) {
            $loginData['emailErr'] = "*Invalid email format";
        }
    }

    if (empty($_POST["password"])) {
        $loginData['passwordErr'] = "*Password is required";
    } else {
        $loginData['password'] = test_input($_POST["password"]);
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
    if (empty($_POST["name"])) {
        $registerData['nameErr'] = "*Name is required";
    } else {
        $registerData['name'] = test_input($_POST["name"]);
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z-' ]*$/", $registerData['name'])) {
            $registerData['nameErr'] = "*Only letters and white space allowed";
        }
    }

    if (empty($_POST["email"])) {
        $registerData['emailErr'] = "*Email is required";
    } else {
        $registerData['email'] = test_input($_POST["email"]);
        // check if e-mail address is well-formed
        if (!filter_var($registerData['email'], FILTER_VALIDATE_EMAIL)) {
            $registerData['emailErr'] = "*Invalid email format";
        } else if (doesEmailExist($registerData['email'])) {
            $registerData['emailErr'] = "*This emailadress is already registered";
        }
    }

    if (empty($_POST["password"])) {
        $registerData['passwordErr'] = "*Password is required";
    } else {
        $registerData['password'] = test_input($_POST["password"]);
    }

    if (empty($_POST["repeatedPassword"])) {
        $registerData['repeatedPasswordErr'] = "*Password is required";
    } else {
        $registerData['repeatedPassword'] = test_input($_POST["repeatedPassword"]);
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
    if (empty($_POST['salutation'])) {
        $contactData['salutationErr'] = "*Salutation is required";
    } else {
        $contactData['salutation'] = test_input($_POST["salutation"]);
    }

    if (empty($_POST["name"])) {
        $contactData['nameErr'] = "*Name is required";
    } else {
        $contactData['name'] = test_input($_POST["name"]);
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z-' ]*$/", $contactData['name'])) {
            $contactData['nameErr'] = "*Only letters and white space allowed";
        }
    }

    if (empty($_POST["email"])) {
        $contactData['emailErr'] = "*Email is required";
    } else {
        $contactData['email'] = test_input($_POST["email"]);
        // check if e-mail address is well-formed
        if (!filter_var($contactData['email'], FILTER_VALIDATE_EMAIL)) {
            $contactData['emailErr'] = "*Invalid email format";
        }
    }

    if (empty($_POST["phonenumber"])) {
        $contactData['phonenumberErr'] = "*Phonenumber is required";
    } else {
        $contactData['phonenumber'] = test_input($_POST["phonenumber"]);
    }

    if (empty($_POST["comm_preference"])) {
        $contactData['comm_preferenceErr'] = "*Communication preference is required";
    } else {
        $contactData['comm_preference'] = test_input($_POST["comm_preference"]);
    }

    if (empty($_POST["message"])) {
        $contactData['messageErr'] = "*Message is required";
    } else {
        $contactData['message'] = test_input($_POST["message"]);
    }

    if (empty($contactData['salutationErr']) && empty($contactData['nameErr']) && empty($contactData['emailErr']) && empty($contactData['phonenumberErr']) && empty($contactData['comm_preferenceErr']) && empty($contactData['messageErr'])) {
        $contactData['valid'] = true;
    } else {
        $contactData['valid'] = false;
    }

    return $contactData;
}
