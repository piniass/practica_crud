<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor</title>

    <!-- <link rel="stylesheet" href="gestor.css"> -->
    <style>
        *{
            padding:0;
            margin:0;
        }
        html,body{
            height: 100%;
        }

        body {
            font-family: Arial, sans-serif;
            text-align: center;
            display: flex;
            flex-direction:column;
            gap:20px;
            align-items: center;
            justify-content: center;
            background-color:#ececdd;
        }

        .panel-container{
            background-color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            box-shadow: 0px 10px 13px -7px #000000, 0px 9px 11px 3px rgba(0,0,0,0.42);
            border-radius: 5px;
            padding:15px;

        }

        a {
            width:400px;
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            text-decoration: none;
            background-color: #c0d23e;
            color: black;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 10px;
            transition: background-color 0.3s;
        }

        a:hover {
            background-color: #cffd89;
        }
    </style>
</head>
<body>
    <?php
        session_start();
         if(!isset($_SESSION['nombre'])){
              header('location:login.php');
         }

         echo '<h2>Bienvenido '.$_SESSION['nombre'].', tu rol es: '.$_SESSION['rol'].'</h2>';
    ?>

    <div class="panel-container">
        <h2>Panel de administracion</h2>
        <a href="insertar.php">Insertar Datos</a>
        <a href="consulta.php">Consultar Datos</a>
        <a href="cerrarsesion.php">Cerrar Sesion</a>
    </div>
   
</body>
</html>