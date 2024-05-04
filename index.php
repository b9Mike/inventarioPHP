<?php require "./inc/session_start.php"?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.0/css/bulma.min.css">
    <link rel="stylesheet" href="./css/styles.css">
</head>
<body>
    <?php 

        if(!isset($_GET['vista']) || $_GET['vista'] == ""){
            $_GET['vista'] = 'login';
        }

        if(is_file("./vistas/".$_GET['vista'].".php") && $_GET['vista'] != "login" && $_GET['vista'] != "404"){

            if((!isset($_SESSION['id']) || $_SESSION['id'] == "") ){
                include ("./vistas/logout.php");
                exit();
            }

            include "./inc/navbar.php";

            include "./vistas/".$_GET['vista'].".php";

            include "./inc/script.php";
        }else{
            if($_GET['vista'] == "login"){
                include "./vistas/login.php";
            }else{
                include "./vistas/404.php";
            }
        }
    ?>
    
</body>
</html>