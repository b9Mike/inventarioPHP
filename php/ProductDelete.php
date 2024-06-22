<?php

    $productIdDel = cleanString($_GET['product_id_del']);

    #verificar existencia del producto
    $checkProduct = conexion();
    $checkProduct = $checkProduct->query("SELECT products_id, products_image FROM products WHERE products_id = $productIdDel");

    if($checkProduct->rowCount() == 1){
        $data = $checkProduct->fetch();

        $deleteProduct = conexion();
        $deleteProduct = $deleteProduct->prepare("DELETE FROM products WHERE products_id = :id");

        $deleteProduct->execute([":id" => $productIdDel]);

        if($deleteProduct->rowCount() == 1){

            if(is_file("./img/producto/".$data['products_image'])){
                chmod("./img/producto/".$data['products_image'], 0777);
                unlink("./img/producto/".$data['products_image']);
            }

            echo '
                <div class="notification is-info">
                    <strong>¡Elimininación exitosa!</strong><br>
                    El producto se elimino correctamente.
                </div>
            ';
        }else{
            echo '
                <div class="notification is-danger">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    El producto no se pudo eliminar, intente nuevamente.
                </div>
            ';
        }

        $deleteProduct = null;

    }else{
        echo '
            <div class="notification is-danger">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No se ha encontrado el producto.
            </div>
        ';
    }

    $checkProduct = null

?>