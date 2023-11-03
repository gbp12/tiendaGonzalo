<?php

function checkCreateProduct($name, $price, $imagen)
{
    if (nameCheck($name) && isNumberCheck($price) && imageCheck($imagen)) {
        return true;
    } else {
        return false;
    }
}

function imageCheck($imagen){
    if($imagen == "") {
echo"La imagen no puede estar vacia";
return false;
        }else{
            return true;
        }
}

function nameCheck($name)
{

    if($name == ""){
        echo"El nombre esta vacio";
        return false;
    }
    $pattern = "/^\S*$/";

    if (preg_match($pattern, $name) == 1) {
        return true;
    } else {
        echo "Error en el nombre, no puede contener espacios";
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


//select

//delete

//modify