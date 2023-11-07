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
/* SI SE ENCUENTRA  ID ME METO EN ESTE CONDICIONAL */
if (strlen($_GET['id']) > 0) {
    if (!$conn) {
        die("Error de conexión: " . mysqli_connect_error());
    } else {
        $id = $_GET['id'];
        $sql = "SELECT P.*, C.nombre AS nombre_categoria
        FROM productos P
        LEFT JOIN categorías C ON P.categoría = C.id WHERE P.id = $id;";
        $result = mysqli_query($conn, $sql);
        mysqli_close($conn);
        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_free_result($result);
        echo "Vas a eliminar el producto " . $rows[0]["nombre"]  . '<br> de la categoria: ' . $rows[0]["nombre_categoria"] . '<br> con precio: ' . $rows[0]["precio"];
        echo "<br>";
        echo "<p>Estas seguro?:</p>";
        echo  '<form action="../controllers/elimina_producto.php" method="post"><input hidden type="text" name="id" value = "' . $id . '"  ><button>Eliminar</button></form>';
    }
} else {
    if (!$conn) {
        die("Error de conexión: " . mysqli_connect_error());
    } else {
        $sql = "SELECT * FROM productos";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

            mysqli_free_result($result);

            mysqli_close($conn);

            echo '<form action="elimina_producto.php" method="get">';
            echo '<label for="id">Eliminar producto:</label>';
            echo '<select name="id" id="id">';

            foreach ($rows as $producto) {
                echo '<option value="' . $producto["id"] . '">' . $producto["nombre"] . '</option>';
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
