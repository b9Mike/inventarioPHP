<?php

    $userIdDel = cleanString($_GET['user_id_del']);

    //valida usuario

    $checkUser = conexion();
    $checkUser = $checkUser->query("SELECT user_id FROM users WHERE user_id = $userIdDel");

    if($checkUser->rowCount() == 1){
        //
        $checkProducts = conexion();
        $checkProducts = $checkProducts->query("SELECT user_id FROM products WHERE user_id = $userIdDel LIMIT 1");

        if($checkProducts->rowCount()  <= 0){

            $deleteUser = conexion();
            $deleteUser = $deleteUser->prepare("DELETE FROM users WHERE user_id = :id");

            $deleteUser->execute([":id" => $userIdDel]);

            if($deleteUser->rowCount() == 1){
                echo '
                    <div class="notification is-info">
                        <strong>¡Ocurrio un error inesperado!</strong><br>
                        El usuario se elimino correctamente.
                    </div>
                ';
            }else{
                echo '
                    <div class="notification is-danger">
                        <strong>¡Ocurrio un error inesperado!</strong><br>
                        El usuario no se pudo eliminar,intente nuevamente.
                    </div>
                ';
            }

            $deleteUser = null;

        }else{
            echo '
                <div class="notification is-danger">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    No podemos eliminar al usuario porque tiene productos asociados.
                </div>
            ';
        }

        $checkProducts = null;
    }else{
        echo '
            <div class="notification is-danger">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No se ha encontrado el usuario.
            </div>
        ';
    }

    $checkUser = null


?>