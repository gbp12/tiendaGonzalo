<?php
$servername = "localhost";
$username = "gonzalo";
$password = "ak471234";
$database = "tienda";

$conn = mysqli_connect($servername, $username, $password, $database);

if (strlen($_GET['id']) > 0) {

    if (!$conn) {
        die("Error de conexión: " . mysqli_connect_error());
    } else {
        $id = $_GET['id'];
        $sql = "SELECT * FROM Productos WHERE id='$id'";
        $result = mysqli_query($conn, $sql);
        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

        mysqli_free_result($result);

        mysqli_close($conn);
        $sql = "";
        echo '<form action="../controllers/editProduct.php" method="post" style="display: flex; flex-direction: column; max-width: 200px;">';
        echo '<label for="nombre">Nombre:</label>';
        echo '<input type="text" name="nombre" id="nombre" value="' . $rows[0]["Nombre"] . '">';
        echo '<label for="precio">Precio:</label>';
        echo '<input type="text" name="precio" id="precio" value="' . $rows[0]["Precio"] . '">';
        echo '<label for="imagen">Imagen:</label>';
        echo '<input type="text" name="imagen" id="imagen" value="' . $rows[0]["Imagen"] . '">';
        echo '<label for="categoria">Categoría:</label>';
        echo '<input type="text" name="categoria" id="categoria" value="' . $rows[0]["Categoría"] . '">';
        echo '<input type="submit" value="Editar">';
        echo '</form>';
        echo '' . $rows[0][''] . '';
    }
} else {

    if (!$conn) {
        die("Error de conexión: " . mysqli_connect_error());
    } else {
        $sql = "SELECT * FROM Productos";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

            mysqli_free_result($result);

            mysqli_close($conn);

            echo '<form action="editProduct.php" method="get">';
            echo '<label for="id">Editar producto:</label>';
            echo '<select name="id" id="id">';

            foreach ($rows as $producto) {
                echo '<option value="' . $producto["id"] . '">' . $producto["Nombre"] . '</option>';
            }

            echo '</select>';
            echo '<input type="submit" value="Editar">';
            echo '</form>';

            echo '</table>';
        } else {
            echo "Error en la consulta: " . mysqli_error($conn);
        }
    }
}
