<?php

#   almacenar datos en variables
$userNickname   = cleanString($_POST['user']);
$userPassword   = cleanString($_POST['password']);

#   verificando campos obligatorios
if ($userNickname == "" || $userPassword == "" ){
    echo '
        <div class="notification is-danger">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No has llenado todos los campos requeridos
        </div>
    ';
    exit();
}

#   Verificando integridad de los datos
if (dataValidator("[a-zA-Z0-9]{4,20}", $userNickname)) {
    echo '
            <div class="notification is-danger">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El <strong>USUARIO</strong> no coincide con el formato seleccionado 
            </div>
        ';
    exit();
}

if (dataValidator("[a-zA-Z0-9$@.-]{7,100}", $userPassword)) {
    echo '
        <div class="notification is-danger">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            Las <strong>CONTRASEÑAS</strong> no coincide con el formato seleccionado 
        </div>
    ';
    exit();
}

$check_user = conexion();
$check_user = $check_user->query("SELECT * FROM users WHERE user_nickname = '$userNickname'");

if($check_user->rowCount() == 1){
    
    $check_user = $check_user->fetch();

    if($check_user['user_nickname'] == $userNickname && password_verify($userPassword, $check_user['user_password'])){

        $_SESSION['id'] = $check_user['user_id'];
        $_SESSION['name'] = $check_user['user_name'];
        $_SESSION['lastname'] = $check_user['user_lastname'];
        $_SESSION['user'] = $check_user['user_nickname'];

        if(headers_sent()){
            echo "<script> windows.location.href='index.php?vista=home' </script>";
        }else{
            header('Location: index.php?vista=home');
        }

    }
    else{
        echo '
            <div class="notification is-danger">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                Usuario ó contraseña incorrectas
            </div>
        ';
        
    }
}else{
    echo '
        <div class="notification is-danger">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            Usuario ó contraseña incorrectas
        </div>
    ';
}

$check_user = null;

?>