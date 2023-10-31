<!DOCTYPE html>
<?php

include "../models/Product.php";

$res = checkCreateProduct($_POST["nombre"], $_POST["precio"]);

if ($res) {
    echo "muy bien champin";
} else {
    echo " <br><br><br>
    <a href = '../crear_producto/crear_producto.php'> Volver al formulario </a>
    ";
}
