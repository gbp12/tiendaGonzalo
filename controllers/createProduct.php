<!DOCTYPE html>
<?php

include "../models/Product.php";

$res = checkCreateProduct($_POST["nombre"], $_POST["precio"]);

if ($res) {
    $nombre = $_POST["nombre"];
    $precio = $_POST["precio"];
    $categoria = $_POST["categoria"];
    $uploads_dir = '../imagenes';
    $fileName = "";

    savePic($fileName, $uploads_dir);


    echo "Producto " . $fileName . " creado con exito
    <br><br>
    <a href = '../index.php'> Volver al formulario </a>
    ";
} else {
    echo " <br><br><br>
    <a href = '../crear_producto/crear_producto.php'> Volver al formulario </a>
    ";
}
function savePic(&$fileName, $uploads_dir)
{
    $isOk = $_FILES["imagen"]["error"];
    if ($isOk == 0) {
        $tmp_name = $_FILES["imagen"]["tmp_name"];
        $nameArr = explode(".", $_FILES["imagen"]["name"]);
        $counter = 1;
        if (file_exists($uploads_dir . "/" . $nameArr[0] . "." . $nameArr[1])) {
            while (file_exists($uploads_dir . "/" . $nameArr[0] . $counter . "." . $nameArr[1])) {
                $counter++;
            }
            //$highestInt = (int)filter_var(max($directory), FILTER_SANITIZE_NUMBER_INT);

            $fileName = $nameArr[0] . ($counter) . "." . $nameArr[1];
        } else {
            $fileName = $nameArr[0] . "." . $nameArr[1];
        }
        move_uploaded_file($tmp_name, "$uploads_dir/$fileName");
    } else {
        echo "algo ha salido mal";

        echo "<br><a href=" . "../index.php" . ">Volver al Índice</a>";
    }
}
