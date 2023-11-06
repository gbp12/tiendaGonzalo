<?php
$servername = "localhost";
$username = "gonzalo";
$password = "ak471234";
$database = "tienda";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
} else {


    $sql = "SELECT * FROM Productos";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

        mysqli_free_result($result);

        mysqli_close($conn);

        echo '<table border="1">';
        echo '<tr><th>ID</th><th>Nombre</th><th>Precio</th><th>Imagen</th><th>Categoría</th></tr>';

        foreach ($rows as $producto) {
            echo '<tr>';
            echo '<td>' . $producto["id"] . '</td>';
            echo '<td>' . $producto["Nombre"] . '</td>';
            echo '<td>' . $producto["Precio"] . '</td>';
            echo '<td>' . $producto["Imagen"] . '</td>';
            echo '<td>' . $producto["Categoría"] . '</td>';
            // Agregar un botón de eliminación
            echo '<td><form action="../controllers/deleteProduct.php" method="POST">
<input type="hidden" name="eliminar" value="' . $producto["id"] . '">
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
