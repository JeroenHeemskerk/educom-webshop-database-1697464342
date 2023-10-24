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
                if ($key == $fieldValue) echo "checked";
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


//nieuwe functie: de html voor de productpagina staat nu hier. 
// Deze functie kan ik later (voor shoppingcart) ook nog gebruiken.
function showProduct($product)
{
    echo "<div class='card-body'> <img class = 'product-img' src='" . $product['image_url'] . "' alt='soap image' width='400' height='300'></br>
    <h4 class = 'card-title'>" . $product["name"] . "</h4></br>
    <p class = 'card-text'>" . $product["description"] . "</p></br>
    &#8364;" . ($product['pricetag'] / 100) . "</br> </div>";
    showFormStart();

    echo "<input hidden name='id' value='" . $product['id'] . "'>
            <input hidden name='action' value='addToCart'>";

    showFormEnd('product', 'add to cart');
    //maak een extra hidden input, geef hem als naam: action en als value 'addToCart'
}
