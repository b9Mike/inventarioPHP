<?php

    require_once './main.php';

    $id = cleanString($_POST['img_del_id']);

    //verificar el producto
    $checkProduct = conexion();
    $checkProduct = $checkProduct->query("SELECT * FROM products WHERE products_id = $id");

    if($checkProduct->rowCount() == 1){
        $product = $checkProduct->fetch();   
    }else{

        echo '
            <div class="notification is-danger">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La imagen no existe en el sistema.
            </div>
        ';
        $checkProduct = null;
        exit();
    }

    # Directorio de imagenes
    $imgDirectory = "../img/producto/";

    chmod($imgDirectory, 0777);

    if(is_file($imgDirectory.$product['products_image'])){
        chmod($imgDirectory.$product['products_image'], 0777);

        if(!unlink($imgDirectory.$product['products_image'])){
            echo '
                <div class="notification is-danger">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    La imagen no se pudo eliminar, intentar de nuevo.
                </div>
            ';
            exit();
        }
    }

    #   Guardando el producto 
    #   Guardar datos
    $saveData = conexion();
    
    $saveData = $saveData->prepare("UPDATE products SET products_image=:products_image WHERE products_id = :id");
    
    $markers = [
        ":products_image" => "",
        "id" => $id
    ];

    $saveData->execute($markers);

    if($saveData->rowCount() == 1){
        echo '
            <div class="notification is-info">
                <strong>¡IMAGEN ELIMINADA!</strong><br>
                Se elimino la imagen del producto.
                <p class="has-text-centered pt-5 pb-5">
                    <a href="index.php?vista=product_img&product_id='.$id.'" class="button is-link is-rounded" >Aceptar</a>
                </p> 
            </div>
        ';
    }else{
        echo '
            <div class="notification is-warning">
                <strong>¡IMAGEN ELIMINADA!</strong><br>
                Ocurrio unos incovenientes al actualizar la base de datos.
                
                <p class="has-text-centered pt-5 pb-5">
                    <a href="index.php?vista=product_img&product_id='.$id.'" class="button is-link is-rounded" >Aceptar</a>
                </p> 
            </div>
        ';
    }

    $saveData = null;

?>