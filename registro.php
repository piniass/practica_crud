<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Usuario</title>
    <link rel="stylesheet" href="registro.css">
</head>
<body>
    <?php
        include_once 'conexiones/claseConexionBD.php';
    ?>
    <form action="" method="post">
        <h2>Crear Usuario</h2>
        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" id="nombre">
        <label for="pwd">Contraseña</label>
        <input type="password" name="pwd" id="pwd">
        <label for="rol">Rol</label>
        <select name="rol" id="rol">
            <option value="admin">Administrador</option>
            <option value="limitado">Limitado</option>
        </select>
        <input type="submit" value="Crear Usuario" name="submit" id="submit">
        <a href="login.php">Volver</a>
    </form>

    <?php
        if(isset($_REQUEST['submit'])){
            if(!empty($_REQUEST['nombre']) && !empty($_REQUEST['pwd'])){
                $nombre = $_REQUEST['nombre'];
                $pwd = sha1($_REQUEST['pwd']);
                $rol =$_REQUEST['rol'];
                $BD = new ConectarBD();
                $conn = $BD->getConexion();
                $stmt = $conn->prepare('INSERT INTO usuarios
                        (usuario, contraseña,rol) ' . 'VALUES (:usuario, :contrasena, :rol)');
        
                try {
                    $stmt->execute( array( 
                    ':usuario' => $nombre,
                    ':contrasena' => $pwd,
                    ':rol' => $rol
                    ));
                    SESSION_START();
                    $_SESSION['nombre'] = $nombre;
                    $_SESSION['rol'] = $rol;
                    header('location:gestor.php');
                    if ($stmt->rowCount() > 0) // Se ha realizado el borrado
                        return '<p class="insertada">Insertadas ' . $stmt->rowCount() . ' filas</p>';
                    }
                catch (PDOException $ex) {
                    print "¡Error!: " . $ex->getMessage() . "<br/>";
                    die();
                }
        
                $BD->cerrarConexion();
        
            } 
        }
    ?>
</body>
</html>