<?php
require_once('main.php');

#   almacenar datos en variables
$name               = cleanString($_POST['userName']);
$userLastname       = cleanString($_POST['userLastname']);

$userNickname       = cleanString($_POST['userNickname']);
$userEmail          = cleanString($_POST['userEmail']);

$userAge            = cleanString($_POST['userAge']);
$userPassword       = cleanString($_POST['userPassword']);
$confirmUserPassword = cleanString($_POST['confirmUserPassword']);

#   verificando campos obligatorios
if ($name == "" || $userLastname == "" || $userAge == "" || $userNickname == "" || $userEmail == "" || $userPassword == "" || $confirmUserPassword == "") {
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

if (dataValidator("[a-zA-Z0-9$@.-]{7,100}", $userPassword) || dataValidator("[a-zA-Z0-9$@.-]{7,100}", $confirmUserPassword)) {
    echo '
            <div class="notification is-danger">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                Las <strong>CONTRASEÑAS</strong> no coincide con el formato seleccionado 
            </div>
        ';
    exit();
}

#   validar correo
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

#   validar usuario

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

#   valida contraseñas

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

#   Guardando datos

$conexion = conexion();

$sql = "INSERT INTO users (user_name, user_lastname, user_nickname, user_email, user_age, user_password) VALUES (?, ?, ?, ?, ?, ?);";

$conexion = $conexion->prepare($sql);

$conexion->execute([$name, $userLastname, $userNickname, $userEmail, $userAge, $clave]);

if($conexion->rowCount() > 0){
    echo '
        <div class="notification is-info">
            <strong>¡USUARIO REGISTRADO!</strong><br>
            Se ha agregado el usuario correctamente.
        </div>
    ';
}else{
    echo '
        <div class="notification is-danger">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            Error al insertar el usuario a la base de datos.
        </div>
    ';
}
$conexion = null;