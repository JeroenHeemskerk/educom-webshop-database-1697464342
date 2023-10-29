<?php

// Form field functions

function showFormStart()
{
    echo "<form method='POST' action='index.php'>";
}


function showFormField($fieldName, $label, $type, $formData, $options = NULL)
{
    echo "<label for='$fieldName'>$label</label>";
    $fieldValue = $formData[$fieldName];

    switch ($type) {

        case "select":
            echo "<select name='$fieldName' id='$fieldName'>";
            foreach ($options as $key => $value) {
                echo "<option value='$key'";
                if ($key == $fieldValue) echo "selected";
                echo ">" .  $value . "</option>";
            }
            echo "</select>";
            break;
        case "textarea":
            echo "<textarea name='$fieldName'";
            foreach ($options as $key => $value) {
                echo " $key='$value' ";
            }
            echo ">" . $fieldValue . "</textarea>";
            break;
        case "radio":
            foreach ($options as $key => $value) {
                $radioId = "$fieldName" . "_" . "$key";
                echo "<input type='$type' name='$fieldName' id='$radioId' ";
                if ($key == $fieldValue) echo " checked ";
                echo "value='$key'>";
                echo "<label for='$radioId'>$value</label>";
            }
            break;
        default:
            echo "<input type='$type' name='$fieldName' id='$fieldName' value='$fieldValue'>";
    }

    echo "</br><span class='error'>" . $formData[$fieldName . 'Err'] . "</span></br></br>";
}

function showFormEnd($page, $submitButtonText)
{
    echo "<input hidden name='page' value='$page'></input>
            <button type='submit'class ='button btn btn-outline-secondary'>" . $submitButtonText . "</button>
            </form>";
}



function showActionButton($page, $submitButtonText, $actionType, $productId = null)
{
    // $page = 'product'
    // $submitButtonText = 'add to cart'
    // value = 'addToCart' 'removeFromCart'

    showFormStart();

    echo "<input hidden name='id' value='$productId'>
            <input hidden name='action' value='$actionType'>";

    showFormEnd($page, $submitButtonText);
}
