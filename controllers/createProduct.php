<!DOCTYPE html>
<?php

include "../models/Product.php";
$dbData = array(
    "servername" => "",
    "username" => "",
    "password" => "",
    "dbname" => ""
);

$res = checkCreateProduct($_POST["nombre"], $_POST["precio"], $_FILES['imagen']['name'], $_POST["categoria"]);


$defaultFile = fopen("../user_data.txt", "r");

foreach ($dbData as $index => $value) {
    $newLine = fgets($defaultFile);
    //echo"$newLine <br>";
    $dbData[$index] = trim($newLine);
}
//print_r($dbData);



if ($res) {
    $nombre = $_POST["nombre"];
    $precio = $_POST["precio"];
    $categoria = $_POST["categoria"];
    $uploads_dir = '../imagenes';
    $fileDir = savePic($fileName, $uploads_dir);

    $conn = new mysqli($dbData["servername"], $dbData["username"], $dbData["password"], $dbData["dbname"]);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO productos (id ,nombre, precio, imagen, categoría)
VALUES (NULL,'$nombre', '$precio', '$fileDir', '$categoria')";

    if ($conn->query($sql) === TRUE) {
        echo "Producto " . $nombre . " creado con exito
    <br><br>
    <a href = '../index.php'> Volver al formulario </a>
    ";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
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
        return "$uploads_dir/$fileName";
    } else {
        echo "algo ha salido mal";

        echo "<br><a href=" . "../index.php" . ">Volver al Índice</a>";
    }
}
