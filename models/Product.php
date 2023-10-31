<?php

function checkCreateProduct($name, $price)
{
    if (nameCheck($name) && isNumberCheck($price)) {
        return true;
    } else {
        return false;
    }
}

function nameCheck($name)
{
    $pattern = "/^\S*$/";

    if (preg_match($pattern, $name) == 1) {
        return true;
    } else {
        echo "Error en el nombre";
        return false;
    }
}
function isNumberCheck($num)
{
    if (is_numeric($num)) {
        return true;
    } else {
        echo "Error en el precio";
        return false;
    }
}
