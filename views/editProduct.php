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
        LEFT JOIN categorías C ON P.categoría = C.id where P.id=$id;";

        $result = mysqli_query($conn, $sql);
        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

        mysqli_free_result($result);

        mysqli_close($conn);
        $sql = "";
        echo '<form action="./editProduct.php" method="post" enctype="multipart/form-data" style="display: flex; flex-direction: column; max-width: 200px;">';
        echo '<input type="hidden" name="id" id="id" value="' . $rows[0]["id"] . '">';
        echo '<label for="nombre">Nombre:</label>';
        echo '<input type="text" name="nombre" id="nombre" value="' . $rows[0]["nombre"] . '">';
        echo '<label for="precio">Precio:</label>';
        echo '<input type="text" name="precio" id="precio" value="' . $rows[0]["precio"] . '">';
        echo '<label for="imagen">Imagen:</label>';
        echo '<td><img style="max-width: 150px;" alt=' . $rows[0]["imagen"] . ' src="../imagenes/' . $rows[0]["imagen"] . '" alt="Chocolate"></td>';
        echo '<input type="file" name="imagen" id="imagen">';
        echo '<label for="categoria">Categoría:</label>';
        echo '<input type="text" name="categoria" id="categoria" value="' . $rows[0]["categoría"] .  '">';
        echo '<input type="submit" value="Editar">';
        echo '</form>';
    }
} elseif ($_POST) {
    if (!$conn) {
        die("Error de conexión: " . mysqli_connect_error());
    } else {
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $precio = $_POST['precio'];
        $categoria = $_POST['categoria'];
        $sql = "UPDATE productos SET nombre='$nombre', precio='$precio', categoría='$categoria' WHERE id='$id'";
        $result = mysqli_query($conn, $sql);

        /* EN CASO DE HABER UNA IMAGEN SE EJECUTA ESTE BLOQUE    */
        if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] === 0) {
            $file = $_FILES["imagen"];
            $file_name = $file["name"];
            $file_tmp = $file["tmp_name"];
            $file_destination = "../imagenes/";
            $archivo_a_eliminar = "../imagenes/";

            /* BUSCA Y ELIMINA LA ANTIGUA IMAGEN */
            $sql = "SELECT imagen from productos WHERE id='$id'";
            $result = mysqli_query($conn, $sql);
            $old_img =  mysqli_fetch_all($result, MYSQLI_ASSOC);
            $archivo_a_eliminar .= ($old_img[0]["imagen"]);
            if (file_exists($archivo_a_eliminar)) {
                unlink($archivo_a_eliminar);
            }

            /* GUARDA LA ANTIGUA IMAGEN EN LA CARPETA "imagenes" Y ACTUALIZA LA DB */
            $file_destination .= $file_name;
            $sql = "UPDATE productos SET  imagen='$file_name' WHERE id='$id'";
            $result = mysqli_query($conn, $sql);
            move_uploaded_file($file_tmp, $file_destination);
        }


        if ($result) {
            echo "Producto editado correctamente";
            echo "<a href='/views/listProducts.php'>Volver al listado</a>";
        } else {
            echo "Error en la consulta: " . mysqli_error($conn);
        }
    }
} else {
    /*SI NO HAY ID Y NO ES UN POST  MUESTRO LOS OBJETOS A EDITAR  EN FORMATO SELECT*/
    if (!$conn) {
        die("Error de conexión: " . mysqli_connect_error());
    } else {
        $sql = "SELECT * FROM productos";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

            mysqli_free_result($result);

            mysqli_close($conn);

            echo '<form action="editProduct.php" method="get">';
            echo '<label for="id">Editar producto:</label>';
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
