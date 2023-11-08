<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesion</title>
    <link rel="stylesheet" href="form.css">
</head>
<body>
    <?php
        include_once 'conexiones/claseConexionBD.php';
    ?>
    <h2>Practica de Php</h2>
    <section class="container">
        <article class="imagen">
            <img src="https://www.infobae.com/new-resizer/OSpUHjKQ_lEWmkFbxAyh-wCxK4o=/arc-anglerfish-arc2-prod-infobae/public/ZQDAYD2LRZCSPPOHG6NDUXLFDY.jpg" 
            alt="imagen de F1"
            class="img">
        </article>
        <form action="" form="post">
            <label for="usuario">Usuarios</label>
            <input type="text" name="usuario" id="usuario">
            <label for="pwd">Contraseña</label>
            <input type="password" name="pwd" id="pwd">
            <input type="submit" value="Iniciar Sesion" id="submit" name="enviar">
            <a href="registro.php">Registrarse</a>
        </form>
    </section>
    

    <?php
        if(isset($_REQUEST['enviar'])){
            if(!empty($_REQUEST['usuario']) && !empty($_REQUEST['pwd'])){
                $nombre = $_REQUEST['usuario'];
                $pwd = sha1($_REQUEST['pwd']);
                // $rol =$_REQUEST['rol'];
                $BD = new ConectarBD();
                $conn = $BD->getConexion();
               
                $sql='SELECT * FROM usuarios where usuario= :usuario and contraseña= :pwd';

                $stmt = $conn->prepare($sql);

                $stmt->bindValue(":usuario",$nombre);
                $stmt->bindValue(":pwd",$pwd);

                $stmt->execute();
                $stmt->setFetchMode(PDO::FETCH_ASSOC);

                while ( $login = $stmt->fetch() ) {
                    $rol = $login['rol'];
                }

                $numero_registro=$stmt->rowCount();
                
                if($numero_registro > 0){
                    SESSION_START();
                    $_SESSION['nombre'] = $nombre;
                    $_SESSION['rol'] = $rol;

                    header('location:gestor.php');
                } 

                $BD->cerrarConexion();
        

            }
        }
    ?>
</body>
</html>