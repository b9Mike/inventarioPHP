<?php

    require_once '../inc/session_start.php';
    require_once './main.php';

    //datos del usuario
    $id = cleanString($_POST['user_id']);

    $checkUser = conexion();
    $checkUser = $checkUser->query("SELECT * FROM users WHERE user_id = $id");

    if($checkUser->rowCount() > 0){

        $user = $checkUser->fetch();

    }else{
        echo '
            <div class="notification is-danger">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                Error al actualizar el usuario en la base de datos.
            </div>
        ';
        $checkUser = null;
        exit();
    }
    

    //datos del admin
    $checkUser = null;

    $userAdmin = cleanString($_POST['userAdmin']);
    $passAdmin = cleanString($_POST['passAdmin']);

    if ($userAdmin == "" || $passAdmin == "" ) {
        echo '
                <div class="notification is-danger">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    No has llenado todos los campos requeridos
                </div>
            ';
        exit();
    }

    if (dataValidator("[a-zA-Z0-9]{4,20}", $userAdmin)) {
        echo '
                <div class="notification is-danger">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    El <strong>NOMBRE</strong> no coincide con el formato seleccionado 
                </div>
            ';
        exit();
    }

    if (dataValidator("[a-zA-Z0-9$@.-]{7,100}", $passAdmin)) {
        echo '
                <div class="notification is-danger">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    La <strong>CONTRASEÑA</strong> no coincide con el formato seleccionado 
                </div>
            ';
        exit();
    }

    $checkAdmin = conexion();
    $checkAdmin = $checkAdmin->query("SELECT user_nickname, user_password FROM users WHERE user_nickname = '$userAdmin' AND user_id = '".$_SESSION['id']."'");
    
    
    if ($checkAdmin->rowCount() > 0) {

        $admin = $checkAdmin->fetch();
        
        if(!password_verify($passAdmin, $admin['user_password'])){
            echo '
                <div class="notification is-danger">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    Error con las credenciales del usuario administrador.
                </div>
            ';
            $checkAdmin = null;
            exit();
        }

    }else{
        echo '
            <div class="notification is-danger">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No se encontro el usuario administrador con ese usuario.
            </div>
        ';
        $checkAdmin = null;
        exit();
    }

    $checkAdmin = null;


    //dtos del usuario
    #   almacenar datos en variables
    $name               = cleanString($_POST['userName']);
    $userLastname       = cleanString($_POST['userLastname']);

    $userNickname       = cleanString($_POST['userNickname']);
    $userEmail          = cleanString($_POST['userEmail']);

    $userAge            = cleanString($_POST['userAge']);
    $userPassword       = cleanString($_POST['userPassword']);
    $confirmUserPassword = cleanString($_POST['confirmUserPassword']);

    if ($name == "" || $userLastname == "" || $userAge == "" || $userNickname == "") {
        echo '
                <div class="notification is-danger">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    No has llenado todos los campos requeridos
                </div>
            ';
        exit();
    }

    #   Verificando integridad de los datos
    if (dataValidator("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $name)) {
        echo '
                <div class="notification is-danger">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    El <strong>NOMBRE</strong> no coincide con el formato seleccionado 
                </div>
            ';
        exit();
    }
    
    if (dataValidator("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $userLastname)) {
        echo '
                <div class="notification is-danger">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    El <strong>APELLIDO</strong> no coincide con el formato seleccionado 
                </div>
            ';
        exit();
    }
    
    if (dataValidator("(0?[0-9]?[0-9]|1[01][0-9]|12[0-7])", $userAge)) {
        echo '
                <div class="notification is-danger">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    La <strong>EDAD</strong> no coincide con el formato seleccionado 
                </div>
            ';
        exit();
    }
    
    if (dataValidator("[a-zA-Z0-9]{4,20}", $userNickname)) {
        echo '
                <div class="notification is-danger">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    El <strong>USUARIO</strong> no coincide con el formato seleccionado 
                </div>
            ';
        exit();
    }

    if ($userEmail != "" && $userEmail != $user['user_email']) {
        # code...
        if (filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
    
            $check_email = conexion();
            $check_email = $check_email->query("SELECT user_email FROM users WHERE user_email ='$userEmail'");
            if ($check_email->rowCount() > 0) {
                $check_email = null;
                echo '
                    <div class="notification is-danger">
                        <strong>¡Ocurrio un error inesperado!</strong><br>
                        El <strong>CORREO</strong> ya esta registrado en el sistema.
                    </div>
                ';
                exit();
            }
            $check_email = null;
        } else {
            echo '
                <div class="notification is-danger">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    El <strong>CORREO</strong> no coincide con el formato seleccionado.
                </div>
            ';
            exit();
        }
    }

    #   validar usuario
    if($userNickname != $user['user_nickname']){

        $check_user = conexion();
        $check_user = $check_user->query("SELECT user_nickname FROM users WHERE user_nickname ='$userNickname'");
        if ($check_user->rowCount() > 0) {
            $check_user = null;
            echo '
                <div class="notification is-danger">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    El <strong>NOMBRE DE USUARIO</strong> ya esta registrado en el sistema.
                </div>
            ';
            $check_user = null;
            exit();
        }
        $check_user = null;

    }

    #validar contraseñas
    if($userPassword != "" || $confirmUserPassword != ""){

        if (dataValidator("[a-zA-Z0-9$@.-]{7,100}", $userPassword) || dataValidator("[a-zA-Z0-9$@.-]{7,100}", $confirmUserPassword)) {
            echo '
                    <div class="notification is-danger">
                        <strong>¡Ocurrio un error inesperado!</strong><br>
                        Las <strong>CONTRASEÑAS</strong> no coincide con el formato seleccionado 
                    </div>
                ';
            exit();
        }

        if ($userPassword != $confirmUserPassword) {
            echo '
                <div class="notification is-danger">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    Las <strong>CONTRASEÑAS</strong> no coinciden.
                </div>
            ';
            exit();
        }else{
            $clave = password_hash($userPassword, PASSWORD_BCRYPT, ["cost" => 10]);
        }

    }else{
        $clave = $user['user_password'];
    }

    $updateData = conexion();

    $sql = "UPDATE users SET user_name=:user_name, user_lastname=:user_lastname, user_nickname=:user_nickname, user_email=:user_email, user_age=:user_age,user_password=:user_password WHERE user_id =:id";

    $updateData = $updateData->prepare($sql);

    $markers = [
        ":user_name" => $name, 
        ":user_lastname" => $userLastname, 
        ":user_nickname" => $userNickname, 
        ":user_email" => $userEmail, 
        ":user_age" =>$userAge, 
        ":user_password" =>$clave,
        ":id" => $id
    ];

    

    if($updateData->execute($markers)){
        echo '
            <div class="notification is-info">
                <strong>¡USUARIO ACTUALIZADO!</strong><br>
                Se ha actualizado el usuario correctamente.
            </div>
        ';
    }else{
        echo '
            <div class="notification is-danger">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                Error al actualizar el usuario a la base de datos.
            </div>
        ';
    }
    $conexupdateDataion = null;

?>