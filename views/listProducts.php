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


    $sql = "SELECT P.*, C.nombre AS nombre_categoria
        FROM productos P
        LEFT JOIN categorías C ON P.categoría = C.id;";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

        mysqli_free_result($result);

        mysqli_close($conn);

        echo '<table border="1">';
        echo '<tr><th>ID</th><th>Foto</th><th>Nombre</th><th>Precio</th><th>Imagen</th><th>Categoría</th></tr>';

        foreach ($rows as $producto) {
            echo '<tr>';
            echo '<td>' . $producto["id"] . '</td>';
            echo '<td><img alt=' . $producto["imagen"] . ' style="max-width: 150px;" src="../imagenes/' . $producto["imagen"] . '" ></td>';
            echo '<td>' . $producto["nombre"] . '</td>';
            echo '<td>' . $producto["precio"] . '</td>';
            echo '<td>' . $producto["imagen"] . '</td>';
            echo '<td>' . $producto["nombre_categoria"] . '</td>';
            echo '<td><form action="elimina_producto.php" method="get">
<input type="hidden" name="id" value="' . $producto["id"] . '">
<input type="submit" value="Eliminar">
</form></td>';
            echo '<td><form action="./editProduct.php" method="get">
<input type="hidden" name="id" value="' . $producto["id"] . '">
<input type="submit" value="Editar">
</form></td>';
            echo '</tr>';
        }

        echo '</table>';
    } else {
        echo "Error en la consulta: " . mysqli_error($conn);
    }
}
