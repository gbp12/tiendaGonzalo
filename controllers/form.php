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
fclose($defaultFile);

$conn = mysqli_connect($dbData["servername"], $dbData["username"], $dbData["password"], $dbData["dbname"]);

if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}

if (isset($_POST['email']) && isset($_POST['password'])) {
    session_start();
    $consulta = "SELECT * FROM usuarios2 WHERE correo_electronico = '" . $_POST['email'] . "'";
    $resultado = mysqli_query($conn, $consulta);

    if (!$resultado) {
        die("Error en la consulta: " . mysqli_error($conn));
    } else if (mysqli_num_rows($resultado) == 0) {
        echo "No hay registros";
    } else {
        $fila = mysqli_fetch_assoc($resultado);
        $auth = password_verify($_POST['password'], $fila['contrasena_hash']);

        if ($auth) {
            echo '<h2>Usuario conectado exitosamente</h2>';
            $_SESSION['usuario_id'] = $fila["id"]; // Asigna el ID del usuario a la sesión
            header("Location: ../index.php"); // Redirige al usuario a la página principal
            exit();
        } else {
            echo '<h2>Contraseña incorrecta</h2><br>';
            echo '<a href="../views/login.php">Volver a intentar</a>';
        }
    }
} else {
    echo "No hay datos recibidos";
}

mysqli_close($conn);
