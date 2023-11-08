<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertar Datos</title>
<style>
    *{
    margin:0;
    padding: 0;
    }

    body,html {
        height: 100%;
    }

    body {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        gap:20px;
        background-color: #ececdd;
        font-family: Verdana, Geneva, Tahoma, sans-serif
    }

    .form-container{
        background-color: white;
        display: flex;
        flex-direction: row;
        box-shadow: 10px 10px 33px -4px #000000;

    }

    .img-container{
        width: 500px;
        padding: 10px;
        display: flex;
        flex-direction: column;


    }

    a{
        text-decoration: none;
    }

    h2{
        text-align: center;
        justify-self: start;
        align-self: center;
        padding: 5px;
    }

    img{
        align-self: center;
    }

    form {
        display: flex;
        flex-direction: column;
        padding: 10px;
        gap: 5px;
    }

    label{
        cursor: pointer;
    }

    input{
        padding: 5px;
    }

    #submit{
        background-color: #c0d23e;
        color: black;
        border: none;
        transition: 0.3s ease;
        padding: 10px;
        cursor: pointer;
    }

    #submit:hover{
        background-color: #cffd89;
        
    }

    #foto {
        width: 100%;

    }
</style>
</head>
<body>
    <?php
    
    include_once 'conexiones/claseConexionBD.php';

        session_start();
         if(!isset($_SESSION['nombre'])){
              header('location:login.php');
         }

         if($_SESSION['rol'] != 'admin'){
            header('location: error.php');
         }

         
    ?>
    <a href="gestor.php">Volver al Panel de Control</a>
    <div class="form-container">
        <div class="img-container">
            <h2>Logo</h2>
            <img src="" alt="Logo" id="foto">
        </div>

        <form action="" method="post" id="form" enctype="multipart/form-data">
            <label for="nombre">Nombre de escuderia</label>
            <input type="text" name="nombre" id="nombre">
            <label for="anio">Año de creacion</label>
            <input type="number" name="anio" id="anio">
            <label for="piloto">Piloto principal</label>
            <input type="text" name="piloto" id="piloto">
            <label for="imagen1">Subir el logo</label>
            <input type="file" name="imagen1" id="imagen1" >
            <label for="imagen2">Sube el coche</label>
            <input type="file" name="imagen2" id="imagen2">
            <input type="submit" value="Insertar escuderia" name="enviar" id="submit">
        </form>

       
    </div>
    <?php
        if (isset($_REQUEST['enviar'])){
            if(!empty($_POST['nombre']) && is_numeric($_POST['anio']) && !empty($_POST['piloto']) && !empty($_FILES['imagen1']['tmp_name']) && !empty($_FILES['imagen2']['tmp_name'])){
                if ( is_uploaded_file($_FILES['imagen1']['tmp_name']) ) {  // El fichero se ha subido
                    $nombreDirectorio = "imagenes/";  // Directorio destino donde subir el archivo 
                    $nombreFichero = $_FILES['imagen1']['name'];  // Nombre del archivo
                    $tipo = $_FILES['imagen1']['type'];   // Tipo de archivo      
                      if ( is_dir($nombreDirectorio) ) {  // Es un directorio existente ==> Mover archivo
                         $nombreCompleto = $nombreDirectorio.$nombreFichero;  // Ruta archivo + nombre del archivo 
                         move_uploaded_file($_FILES['imagen1']['tmp_name'], $nombreCompleto);
                         $err = 'El archivo subido esta disponible en <a href="./img/'.
                             $nombreFichero.'">'.$nombreFichero.'</a>';
                      }
                      else 
                         $err = 'Directorio definitivo invÃ¡lido';
                    }
                  
                  else{
                    $err = "No se ha podido subir el fichero<br/>";
                  }
                if (is_uploaded_file($_FILES["imagen2"]["tmp_name"])){
                        $nombreDirectorio2 = "imagenes/";  // Directorio destino donde subir el archivo 
                        $nombreFichero2 = $_FILES['imagen2']['name'];
                        $nombreCompleto2 = $nombreDirectorio2.$nombreFichero2;  // Ruta archivo + nombre del archivo 
                        move_uploaded_file($_FILES['imagen2']['tmp_name'], $nombreCompleto2);
                        $imgblob = $nombreCompleto2;

                    }
                    $fp = fopen($imgblob, 'rb');

                    $BD = new ConectarBD();
                     $conn = $BD->getConexion();
                     $stmt = $conn->prepare('INSERT INTO escuderias (nombre_escuderia, año_creacion, imagen, imagen2, piloto_principal) ' . 'VALUES (:nombre, :anio, :imagen1, :imagen2, :piloto)');

                     try {

                        $stmt->bindParam(':nombre', $_POST['nombre']);
                        $stmt->bindParam(':anio', $_POST['anio']);
                        $stmt->bindParam(':imagen1', $nombreFichero);
                        $stmt->bindParam(':imagen2', $fp, PDO::PARAM_LOB);
                        $stmt->bindParam(':piloto', $_POST['piloto']);

                        $stmt->execute();
                        fclose($fp);
                         if ($stmt->rowCount() > 0) {
                             // Insertado exitosamente
                             echo '<p>Fila insertada correctamente!</p>';
                         }
                     } 
                     catch (PDOException $ex) {
                         print "¡Error!: " . $ex->getMessage() . "<br/>";
                         die();
                    }

                     $BD->cerrarConexion();
                echo "bien";
            }
        } 
        if(isset($_REQUEST['nombre'])|| isset($_REQUEST['anio']) || isset($_REQUEST['piloto']) || isset($_FILES['imagen1']['tmp_name'])|| isset($_FILES['imagen2']['tmp_name'])){
            if(empty($_REQUEST['nombre']) || empty($_REQUEST['anio']) || empty($_REQUEST['piloto']) || empty($_FILES['imagen1']['tmp_name'])|| empty($_FILES['imagen2']['tmp_name'])){
                echo '<p>No puedes dejar campos vacios</p>';
            }
            if(!is_numeric($_REQUEST['anio'])){
                echo '<p>El año debe ser un número.</p>';

            }
        }
        
            
        ?>
        <script>
            document.getElementById('imagen1').onchange = function() {
            var reader = new FileReader(); //instanciamos el objeto de laapiFileReader
            reader.onload = function(e) {
            //en el evento onload del FileReader, asignamos la ruta a el srcdelelemento imagen de html
            document.getElementById("foto").src = e.target.result;
            };
            // carga el contenido del fichero imagen.
            reader.readAsDataURL(this.files[0]);
            };
        </script>
</script>
</body>
</html>