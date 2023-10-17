
<?php
define("SALUTATIONS", array("mr." => "Dhr.", "mrs." => "Mvr."));
define("COMM_PREFS", array("email" => "Email", "phone" => "Phone"));


// echo constant("SALUTATIONS['mr.']");


function getContactData()
{
    // initate the variables 
    $contactData = ["page" => "contact", "salutation" => " ", "name" => "", "email" => "", "phonenumber" => "", "comm_preference" => "", "message" => "", "salutationErr" => "", "nameErr" => "", "emailErr" => "", "phonenumberErr" => "", "comm_preferenceErr" => "", "messageErr" => "", "valid" => false];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $contactData = validateContact($contactData);
    }
    return $contactData;
}

function showContactContent($pageData)
{
    if (!$pageData['valid']) {
        showContactForm($pageData);
    } else {
        showContactThanks($pageData);
    }
}
//================================================================
// Ik ga functies maken om herhaling in de contactform te voorkomen
function showFormStart()
{
    echo '<form method="POST" action="index.php">';
}


function showFormField($fieldName, $label, $type, $contactData, $options = NULL)
// nog niet af: later aan verder. 
{
    echo '<label for="' . $fieldName . '">' . $label . '</label>';

    switch ($type) {
        default:
            echo '<input type="' . $type . '" name="name" id="name" value="' . $contactData['name'] . '"></br>
        <span class="error">' . $contactData[$fieldName . 'Err'] . '</span>
        <br><br>';
        case "select":
            echo "<select name='$fieldName'>";
            $fieldValue = $contactData[$fieldName];
            foreach ($options as $key => $value) {
                // echo "<option value=$key ($key == $fieldValue)? "selected": "").">$value</options>"; 
            }
            break;
        case "textarea":
            echo "<textarea name='$fieldName'>";
            foreach ($options as $key => $value) {
                echo $key . "=" . $value;
            }
            echo ">" . $contactData[$fieldName] . "</textarea>";
            break;
        case "radio":
            foreach ($options as $key => $value) {
                //
            }
            break;
    }

    // echo <span class="error">'.$contactData($fieldName.

}

function showFormEnd($page, $submitButtonText)
{
    echo '<input hidden name="page" value="' . $page . '"></input>
            <button type="submit">' . $submitButtonText . '</button>
            </form>';
}



//===============================================================================


function showContactForm($contactData)
{
    showFormStart();


    // salutation inhoud
    echo   '<select name="salutation" id="salutation">
        <option value="mr"';
    if (isset($contactData['salutation']) && $contactData['salutation'] == "mr") echo "selected";
    echo '>' . 'Dhr.</option>
        <option value="mrs"';
    if (isset($contactData['salutation']) && $contactData['salutation'] == "mrs") echo "selected";
    echo '>' . 'Mevr.</option>
    </select> </br>
    <span class="error">';
    echo $contactData['salutationErr'] . '</span></br></br>';

    // ShowFormField('salutation', NULL, 'select', $contactData, SALUTATIONS);

    ShowFormField('name', 'Name:', 'text', $contactData);
    ShowFormField('email', 'Email:', 'email', $contactData);
    ShowFormField('phonenumber', 'Phonenumber:', 'text', $contactData);
    ShowFormField('comm_preference', 'Communication preference:', 'radio', $contactData, COMM_PREFS);
    ShowFormField('message', 'Message:', 'textarea', $contactData, ['rows' => 5, 'cols' => 40]);

    //comm preference
    echo   '<label for="comm_preference">Communication preference:</label>
                
                <input type="radio" name="comm_preference" id="communication_email"';
    if (isset($contactData['comm_preference']) && $contactData['comm_preference'] == "email") echo "checked";
    echo ' value="email">
                <label for="email">Email</label>
  
                <input type="radio" name="comm_preference" id="communication_phone"';
    if (isset($contactData['comm_preference']) && $contactData['comm_preference'] == "phone") echo "checked";
    echo ' value="phone">
                <label for="phone">Phone</label></br>
                
                <span class="error">';
    echo $contactData['comm_preferenceErr'] . '</span></br></br>';


    //=========================================

    showFormEnd('contact', 'submit');
}


function showContactThanks($contactData)
{

    echo ' <p>Bedankt voor uw reactie:</p>
     
     <div>Name:' . SALUTATIONS[$contactData['salutation']] . " " . $contactData['name'] . '</div>
     <div>Email:' . $contactData['email'] . '</div>
     <div>Phonenumber:' . $contactData['phonenumber'] . '</div>
     <div>Communication preference:' . $contactData['comm_preference'] . '</div>
     <div>Your message:' . $contactData['message'] . '</div>';
}
