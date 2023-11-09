<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de la Escuderia</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 20px;
            background-color: #f8f8f8;
        }

        .escuderia-details {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
            margin-top:1.5rem;
        }


        .escuderia-details p {
            margin-bottom: 10px;
            font-size: 18px;
        }

        #logo{
            width:300px;
            heigth:300px;
            border-radius:15px;
        }

        #volver{
            border:none;
            text-decoration:none;
            background-color: green;
            color:white;
            cursor: pointer;
            transition: 0.5s ease;

            margin-top: 30px;
            padding: 15px;
        }

        #volver:hover{
            background-color:lightgreen;
            color:black;
        }

        #coche{
            width:500px;
            height:200px;
            object-fit:cover;
            margin-bottom:15px;
        }

        #descarga{
            text-decoration:none;
            padding:10px;
            background-color:#09f;
            color:white;
            cursor: pointer;
            transition: 0.5s ease;
        }
        #descarga:hover{
            background-color:#09f8;
            color:black;
        }
    </style>
</head>
<body>
    <?php  
        include_once 'conexiones/claseConexionBD.php';
        $id = $_GET["id"]; //Aqui creo la variable para pasarla por parámtro

        SESSION_START();

        if(!isset($_SESSION['nombre'])){
            header('location: login.php');
        }

        $BD = new ConectarBD();
        $conn = $BD->getConexion(); 
        $stmt = $conn->prepare('SELECT * FROM escuderias where codigo_escuderia = :codigo');
        $stmt->bindParam(':codigo', $id);
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        while ( $escuderia = $stmt->fetch() ) {
    ?>
        <a href="../consulta.php" id="volver">Volver</a>

        <div class="escuderia-details">
            <img src="../imagenes/<?php echo $escuderia['imagen'] ?>" alt='Logo de la Escudería' id="logo"> 
            <!-- Esta linea es importante porque al estar en la ruta escuderia tengo que ir hacia atras para poder imprimir la imagen almacenada enla carpeta imagenes -->
            <p>Código de Escudería: <?php echo $escuderia['codigo_escuderia'] ?></p>
            <p>Piloto Principal: <?php echo $escuderia['piloto_principal'] ?></p>
            <p>Nombre de Escudería: <?php echo $escuderia['nombre_escuderia'] ?></p>
            <p>Año de Creación: <?php echo $escuderia['año_creacion'] ?></p>
            <p>Piloto Principal: <?php echo $escuderia['piloto_principal'] ?></p>
            <img src="data:image/jpeg;base64,<?php echo base64_encode($escuderia['imagen2']) ?>" height="50px" id="coche">
            <!-- Aqui estoy imprimiendo la imagen binaria, para ello la descodifico -->
            <br>
            <a href="../imagenes/<?php echo $escuderia['imagen'] ?>" download="<?php echo $escuderia['imagen'] ?>" id="descarga">Descargar logo de la escuderia</a>
        </div>
    <?php
        }
    ?>

</body>
</html>
