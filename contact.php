
<?php
define("SALUTATIONS", array("mr." => "Dhr.", "mrs." => "Mvr."));
define("COMM_PREFS", array("email" => "Email", "phone" => "Phone"));

function getContactData()
{
    // initate the variables 
    $contactData = ["page" => "contact", "salutation" => " ", "name" => "", "email" => "", "phonenumber" => "", "comm_preference" => "", "message" => "", "salutationErr" => "", "nameErr" => "", "emailErr" => "", "phonenumberErr" => "", "comm_preferenceErr" => "", "messageErr" => "", "valid" => false];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        require_once('validations.php');
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


function showContactForm($formData)
{
    require_once('form-fields.php');
    showFormStart();
    showFormField('salutation', NULL, 'select', $formData, SALUTATIONS);
    showFormField('name', 'Name:', 'text', $formData);
    showFormField('email', 'Email:', 'email', $formData);
    showFormField('phonenumber', 'Phonenumber:', 'text', $formData);
    showFormField('comm_preference', 'Communication preference:', 'radio', $formData, COMM_PREFS);
    showFormField('message', 'Message:', 'textarea', $formData, ['rows' => 5, 'cols' => 40]);
    showFormEnd('contact', 'submit');
}


function showContactThanks($contactData)
{
    echo ' <p>Bedankt voor uw reactie:</p>
     <div>Name:' . SALUTATIONS[$contactData['salutation']] . " " . $contactData['name'] . '</div>
     <div>Email:' . $contactData['email'] . '</div>
     <div>Phonenumber:' . $contactData['phonenumber'] . '</div>
     <div>Communication preference:' . COMM_PREFS[$contactData['comm_preference']] . '</div>
     <div>Your message:' . $contactData['message'] . '</div>';
}
