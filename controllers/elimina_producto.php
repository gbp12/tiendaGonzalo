<?php
$dbData = array(
    "servername" => "",
    "username" => "",
    "password" => "",
    "dbname" => ""
);
$defaultFile = fopen("../user_data.txt", "r");

foreach ($dbData as $index => $value) {
    $newLine = fgets($defaultFile);
    $dbData[$index] = trim($newLine);
}

$conn = mysqli_connect($dbData["servername"], $dbData["username"], $dbData["password"], $dbData["dbname"]);

if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
} else {
    $id = $_POST['id'];
    $sql = "DELETE FROM productos WHERE id='$id';";
    $result = mysqli_query($conn, $sql);
    mysqli_close($conn);
    if ($result) {
        echo "Producto eliminado";
    } else {
        echo "Error en la consulta: " . mysqli_error($conn);
    }
}
