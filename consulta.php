<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta</title>
    <style>
        *{
            padding:0;
            margin:0;
        }
        html,body{
            height:100%;
        }
        body {
            display: flex;
            flex-direction:column;
            align-items: center;
            justify-content: center;
            margin: 10px; 
            overflow: hidden; 
            background-color: #ececdd;
        }

        .card-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            column-gap: 2.5em;
            row-gap: 2.5em;
            max-width: 100%; 
            max-height: 80%; 
            overflow: auto;
            padding: 25px;
        }


        .card {
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 10px;
            max-width: 300px;
            text-align: center;
            box-shadow: 0px 10px 13px -7px #000000, 0px 9px 11px 3px rgba(0,0,0,0.42);
            background-color:#fff;

        }

        .card img {
            width: 300px;
            height:200px;
            border-radius: 5px;
            object-fit: cover;
        }

        .card h3 {
            margin: 10px 0;
        }

        .card a {
            display: block;
            text-decoration: none;
            background-color: #09f;
            color:#fff;
            padding:15px;
            transition: 1s ease;
        }

        .card a:hover {
            display: block;
            text-decoration: none;
            background-color: #09f8;
            color:black;
            padding:15px;
        }

        #volver{
            border:none;
            text-decoration:none;
            background-color: green;
            color:white;
            cursor: pointer;
            transition: 0.5s ease;

            margin-top: 10px;
            padding: 15px;
        }

        #volver:hover{
            background-color:lightgreen;
            color:black;
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

    $BD = new ConectarBD();
    $conn = $BD->getConexion(); 
    $stmt = $conn->prepare('SELECT * FROM escuderias');
    $stmt->execute();

    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    ?>
        <h2>Escuderias</h2>
        <div class="card-container">
            <?php
            while ($escuderia = $stmt->fetch()) {
                echo "<div class='card'>";
                echo "<img src='imagenes/{$escuderia['imagen']}' alt='Logo de la Escudería'>";
                 //Aqui imprimo la ruta de la imagen almacenada como varchar
                echo "<h3>{$escuderia['nombre_escuderia']}</h3>";
                echo "<a href='escuderia/" . $escuderia["codigo_escuderia"] . "'>Ver más detalles</a>"; ?>
                <!-- Aqui uso una ruta amigable y le paso por parámetro el código de escuderia -->
                <?php echo "</div>";
            }
            ?>
        </div>
        <a href="gestor.php" id="volver">Volver al Panel de Control</a>
</body>
</html>
