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
        <select name="categoria" id="categoria" size="1">
            <option value="comida">Comida</option>
            <option value="limpieza">Limpieza</option>
            <option value="ropa">Ropa</option>
            <option value="deporte">Deporte</option>
        </select>
    </div>
    <input type="submit" value="Enviar">

</form>