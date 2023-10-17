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

function showRegisterForm($registrationData)
{
    echo '
    <form method="POST" action="index.php">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" value="' . $registrationData['name'] . '"></br>
        <span class="error">' . $registrationData['nameErr'] . '</span>
        </br></br>

        <label for="email">Email:</label>
        <input type="text" name="email" id="email" value="' . $registrationData['email'] . '"></br>
        <span class="error">' . $registrationData['emailErr'] . '</span>
        </br></br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" value="' . $registrationData['password'] . '"></br>
        <span class="error">' . $registrationData['passwordErr'] . '</span>
        </br></br>

        <label for="repeatedPassword">Repeat password:</label>
        <input type="password" id="repeatedPassword" name="repeatedPassword" value="' . $registrationData['repeatedPassword'] . '"></br>
        <span class="error">' . $registrationData['repeatedPasswordErr'] . '</span>
        </br></br>

        <input hidden name="page" value="register"></input>

        <button type= "submit">Submit</button>
    </form>';
}
