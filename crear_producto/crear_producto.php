<!DOCTYPE html>
<form method="post" action="../controllers/createProduct.php" enctype="multipart/form-data">

    <div>
        <label for="nombre">Nombre producto:</label>
        <input type="text" name="nombre" id="nombre" placeholder="Nombre completo">
    </div>
    <div>
        <label for="precio">Precio :</label>
        <input type="number" name="precio" id="precio" placeholder="Precio en euros">
    </div>
    <div>
        <label for="imagen">Imagen producto:</label>
        <input type="file" name="imagen" id="imagen" placeholder="Enlace a imagen ">
    </div>
    <div>
        <label for="categoria">Elige la categoria:</label>


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

        $mysqli = new mysqli($dbData["servername"], $dbData["username"], $dbData["password"], $dbData["dbname"]);
        $query = "SELECT id, nombre FROM categorías";
        $result = $mysqli->query($query);

        echo '<select name="categoria">';

        while ($row = $result->fetch_assoc()) {
            $id = $row['id'];
            $nombre = $row['nombre'];

            echo '<option value="' . $id . '">' . $nombre . '</option>';
        }
        echo '</select>';

        // Close the database connection
        $mysqli->close();






        ?>

    </div>
    <input type="submit" value="Enviar">

</form>
