<?php

    $categoryIdDel = cleanString($_GET['category_id_del']);

    //valida categoria

    $checkCategory = conexion();
    $checkCategory = $checkCategory->query("SELECT categories_id FROM categories WHERE categories_id = $categoryIdDel");

    if($checkCategory->rowCount() == 1){
        //valida si tiene productos
        $checkProducts = conexion();
        $checkProducts = $checkProducts->query("SELECT categories_id FROM products WHERE categories_id = $categoryIdDel LIMIT 1");

        if($checkProducts->rowCount()  <= 0){

            $deleteCategory = conexion();
            $deleteCategory = $deleteCategory->prepare("DELETE FROM categories WHERE categories_id = :id");

            $deleteCategory->execute([":id" => $categoryIdDel]);

            if($deleteCategory->rowCount() == 1){
                echo '
                    <div class="notification is-info">
                        <strong>¡Elimininación exitosa!</strong><br>
                        La categoria se elimino correctamente.
                    </div>
                ';
            }else{
                echo '
                    <div class="notification is-danger">
                        <strong>¡Ocurrio un error inesperado!</strong><br>
                        La categoria no se pudo eliminar, intente nuevamente.
                    </div>
                ';
            }

            $deleteCategory = null;

        }else{
            echo '
                <div class="notification is-danger">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    No podemos eliminar esta categoria porque tiene productos asociados.
                </div>
            ';
        }

        $checkProducts = null;
    }else{
        echo '
            <div class="notification is-danger">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No se ha encontrado la categoria.
            </div>
        ';
    }

    $checkCategory = null


?>