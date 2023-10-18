<?php

// Form field functions

function showFormStart()
{
    echo '<form method="POST" action="index.php">';
}


function showFormField($fieldName, $label, $type, $formData, $options = NULL)
{
    echo "<label for=$fieldName>$label</label>";

    switch ($type) {

        case "select":
            $fieldValue = $formData[$fieldName];
            echo "<select name=$fieldName id=$fieldName>";
            foreach ($options as $key => $value) {
                echo "<option value=$key ";
                if ($key == $fieldValue) echo "selected";
                echo ">" .  $value . "</option>";
            }
            echo '</select>';
            break;
        case "textarea":
            echo "<textarea name=$fieldName";
            foreach ($options as $key => $value) {
                echo " $key=$value ";
            }
            echo ">" . $formData[$fieldName] . "</textarea>";
            break;
        case "radio":
            $fieldValue = $formData[$fieldName];
            foreach ($options as $key => $value) {
                echo "<input type=$type name=$fieldName id=radio_$key ";
                if ($key == $fieldValue) echo "checked";
                echo " value=$key>";
                echo  "<label for=radio_$key >$value</label>";
            }
            break;
        default:
            echo "<input type=$type name=$fieldName id=$fieldName value=$formData[$fieldName]>";
    }

    echo '</br><span class="error">' . $formData[$fieldName . 'Err'] . '</span></br></br>';
}

function showFormEnd($page, $submitButtonText)
{
    echo '<input hidden name="page" value="' . $page . '"></input>
            <button type="submit">' . $submitButtonText . '</button>
            </form>';
}
