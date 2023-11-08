<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        *{
            padding:0;
            margin:0;
        }
        html,body{
            height: 100%;
        }
        body{
            display: flex;
            flex-direction: column;
            align-items:center;
            justify-content:center;
            background-color:#ececdd;

        }
        div{
            display: flex;
            flex-direction: column;
            padding: 10px;
            background-color: white;
            gap:10px;

        }
        h2 {
            text-align:center;
        }
        h2:first-letter {
            text-transform: uppercase;
        }
        a{
            background-color: #c0d23e;
            text-decoration:none;
            padding:10px;
            text-align:center;
            color:black;
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
    ?>
    <div>
        <h2><?php echo $_SESSION['nombre']?> </h2>
        <p>No puedes acceder a esta pantalla, tu rol es limitado.</p>
        <a href="gestor.php">Volver al panel</a>
    </div>
   
</body>
</html>