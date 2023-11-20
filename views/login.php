<?php
session_start();

if (isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $_SESSION['usuario_id'] = $usuario_id;
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="../controllers/form.php" method="post" style="display: flex; flex-direction: column; width: 200px;">
        <label for="correo">Correo</label>
        <input name="email" type="email" required>
        <label for="contrasenia">contrasenia</label>
        <input name="password" type="password" required>
        <button type="submit">Enviar</button>
    </form>
</body>

</html>
