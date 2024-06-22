<?php

    $modulo_buscador = cleanString($_POST['modulo_buscador']);

    $modulos = ['user', 'category', 'product'];

    if(in_array($modulo_buscador, $modulos)){
        $modulos_url = [
            'user'          => 'user_search',
            'category'      => 'category_search',
            'product'      => 'product_search'
        ];

        $modulos_url = $modulos_url[$modulo_buscador];

        $modulo_buscador = 'search_'.$modulo_buscador;

        #Iniciar Busqueda
        if(isset($_POST['txt_search'])){
            $txt = cleanString($_POST['txt_search']);

            if($txt == ""){
                echo '<div class="notification is-warning">
                        <strong>¡Revisa lo siguiente!</strong><br>
                        Escribe lo que quieres buscar.
                    </div>';
            }else{
                if(dataValidator('[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}',$txt)){

                    echo '<div class="notification is-warning">
                        <strong>¡Revisa lo siguiente!</strong><br>
                        El termino de busqueda no coincide con el formato.
                    </div>';

                }else{

                    $_SESSION[$modulo_buscador] = $txt;

                    header("Location: index.php?vista=$modulos_url", true, 303);
                    exit();
                }
            }

        }

        #Eliminar busqueda
        if(isset($_POST['delete_search'])){
            unset($_SESSION[$modulo_buscador]);
            header("Location: index.php?vista=$modulos_url", true, 303);
            exit();
        }

    }else{
        echo '<div class="notification is-danger">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No podemos procesar la petición.
            </div>';
    }

?>