<?php

    require_once './main.php';

    $id = cleanString($_POST['img_up_id']);

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
    $checkProduct = null;

    # Directorio de imagenes
    $imgDirectory = "../img/producto/";

    # comprobar si se madno img
    if($_FILES['producto_foto']['name'] == "" || $_FILES['producto_foto']['size'] == 0){
        
        echo '
            <div class="notification is-warning">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No ha seleccionado una imagen.
            </div>
        ';
        exit();
    }

    #verificar directorio
    if(!file_exists($imgDirectory)){
        if(!mkdir($imgDirectory,0777)){
            echo '
                <div class="notification is-danger">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    Error al crear el directorio.
                </div>
            ';
            exit();
        }
    }
    chmod($imgDirectory, 0777);

    #verificar formato de las imagenes
    if(mime_content_type($_FILES['producto_foto']['tmp_name']) != "image/jpeg" &&
        mime_content_type($_FILES['producto_foto']['tmp_name']) != "image/png"){
            echo '
                <div class="notification is-danger">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    Formato de imagen no admitido.
                </div>
            ';
            exit();
    }

    #verificar peso de la imagen
    if(($_FILES['producto_foto']['size']/1024) > 3072){
        echo '
            <div class="notification is-danger">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La imagen supera el limite permitido.
            </div>
        ';
        exit();
    }

    #extension de la imagen
    switch(mime_content_type($_FILES['producto_foto']['tmp_name'])){
        case 'image/jpeg':
                $imgExtension = '.jpg';
            break;
        case 'image/png':
                $imgExtension = '.png';
            break;
    }

    $nameImage = renameImages($product['products_name']);

    $foto = $nameImage.$imgExtension;

    #moviendo la imagen
    if(!move_uploaded_file($_FILES['producto_foto']['tmp_name'], $imgDirectory.$foto)){
        echo '
            <div class="notification is-danger">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No se pudo subir la imagen :(
            </div>
        ';
        exit();
    }

    #eliminando imagen
    if(is_file($imgDirectory.$product['products_image']) && $product['products_image'] != $foto){
        chmod($imgDirectory.$product['products_image'], 0777);
        unlink($imgDirectory.$product['products_image']);
    }

    #   Guardando el producto 
    #   Guardar datos
    $saveData = conexion();
    
    $saveData = $saveData->prepare("UPDATE products SET products_image=:products_image WHERE products_id = :id");
    
    $markers = [
        ":products_image" => $foto,
        "id" => $id
    ];

    $saveData->execute($markers);

    if($saveData->rowCount() == 1){
        echo '
            <div class="notification is-info">
                <strong>¡IMAGEN ACTUALIZADA!</strong><br>
                Se elimino la imagen del producto.
                <p class="has-text-centered pt-5 pb-5">
                    <a href="index.php?vista=product_img&product_id='.$id.'" class="button is-link is-rounded" >Aceptar</a>
                </p> 
            </div>
        ';
    }else{
         #eliminando imagen
        if(is_file($imgDirectory.$foto)){
            chmod($imgDirectory.$foto, 0777);
            unlink($imgDirectory.$foto);
        }
        echo '
            <div class="notification is-warning">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                Ocurrio unos incovenientes al actualizar la base de datos.
            </div>
        ';
    }

    $saveData = null;

?>