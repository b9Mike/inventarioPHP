<?php

    require_once "../inc/session_start.php";
    require_once "./main.php";
    
    //almacenar datos en variables
    $producto_codigo        = cleanString($_POST['producto_codigo']);
    $producto_nombre        = cleanString($_POST['producto_nombre']);
    $producto_precio        = cleanString($_POST['producto_precio']);
    $producto_stock         = cleanString($_POST['producto_stock']);
    $producto_categoria     = cleanString($_POST['producto_categoria']);
    $producto_descripcion   = cleanString($_POST['producto_descripcion']);
    //$producto_foto          = cleanString($_POST['producto_foto']);

    #   verificando campos obligatorios
    if ($producto_codigo == "" || $producto_nombre == "" || $producto_precio == "" || $producto_stock == "" || $producto_categoria == "" ||$producto_descripcion == "") {
        echo '
                <div class="notification is-danger">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    No has llenado todos los campos requeridos
                </div>
            ';
        exit();
    }

    #   Verificando integridad de los datos
    if (dataValidator("[a-zA-Z0-9- ]{1,70}", $producto_codigo)) {
        echo '
                <div class="notification is-danger">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    El <strong>CODIGO</strong> no coincide con el formato seleccionado 
                </div>
            ';
        exit();
    }
    if (dataValidator("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,70}", $producto_nombre)) {
        echo '
                <div class="notification is-danger">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    El <strong>NOMBRE</strong> no coincide con el formato seleccionado 
                </div>
            ';
        exit();
    }
    if (dataValidator("[0-9.]{1,25}", $producto_precio)) {
        echo '
                <div class="notification is-danger">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    El <strong>PRECIO</strong> no coincide con el formato seleccionado 
                </div>
            ';
        exit();
    }
    if (dataValidator("[0-9]{1,25}", $producto_stock)) {
        echo '
                <div class="notification is-danger">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    El <strong>STOCK</strong> no coincide con el formato seleccionado 
                </div>
            ';
        exit();
    }
    if (dataValidator("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,70}", $producto_descripcion)) {
        echo '
                <div class="notification is-danger">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    La <strong>DESCRIPCIÓN</strong> no coincide con el formato seleccionado 
                </div>
            ';
        exit();
    }


    #   validar nombre del producto
    $check_name = conexion();
    $check_name = $check_name->query("SELECT products_name FROM products WHERE products_name ='$producto_nombre'");

    if ($check_name->rowCount() > 0) {

        $check_name = null;
        echo '
            <div class="notification is-danger">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El <strong>NOMBRE DEL PRODUCTO</strong> ya esta registrado en el sistema.
            </div>
        ';
        exit();
    }
    $check_name = null;
    
    #   validar codigo de barras
    $check_code = conexion();
    $check_code = $check_code->query("SELECT products_code FROM products WHERE products_code ='$producto_codigo'");

    if ($check_code->rowCount() > 0) {

        $check_code = null;
        echo '
            <div class="notification is-danger">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El <strong>CODIGO DEL PRODUCTO</strong> ya esta registrado en el sistema.
            </div>
        ';
        exit();
    }
    $check_code = null;
    
    #   validar que la categoria existe
    $check_category = conexion();
    $check_category = $check_category->query("SELECT categories_id FROM categories WHERE categories_id ='$producto_categoria'");

    if ($check_category->rowCount() <= 0) {

        $check_category = null;
        echo '
            <div class="notification is-danger">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La <strong>CATEGORIA</strong> no existe en el sistema.
            </div>
        ';
        exit();
    }
    $check_category = null;


    # Directorio de imagenes
    $imgDirectory = "../img/producto/";

    # comprobar si se madno img
    if($_FILES['producto_foto']['name'] != "" && $_FILES['producto_foto']['size'] > 0){

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

        chmod($imgDirectory, 0777);

        $nameImage = renameImages($producto_nombre);

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
    }else{
        $foto = "";
    }

    #Guardando el producto 
    #Guardar datos
    $saveData = conexion();
    $saveData = $saveData->prepare("INSERT INTO products (products_name, products_description, products_price, products_image, products_stock, products_code, user_id, categories_id)
    VALUES(:products_name, :products_description, :products_price, :products_image, :products_stock, :products_code, :user_id, :categories_id)");
    
    $markers = [
        ":products_name" => $producto_nombre, 
        ":products_description" => $producto_descripcion, 
        ":products_price" => $producto_precio,
        ":products_image" => $foto,
        ":products_stock" => $producto_stock,
        ":products_code" => $producto_codigo,
        ":user_id" => $_SESSION['id'],
        ":categories_id" => $producto_categoria
    ];

    $saveData->execute($markers);

    if($saveData->rowCount() == 0){
        echo '
            <div class="notification is-info">
                <strong>¡SE GUARDO EL PRODUCTO!</strong><br>
                El producto <strong>'.$producto_nombre.'</strong> ha sido agregado con exito. 
            </div>
        ';
    }else{

        if(is_file($imgDirectory.$foto)){
            chmod($imgDirectory.$foto, 0777);
            unlink($imgDirectory.$foto);
        }
        echo '
        <div class="notification is-danger">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No se pudo guardar el <strong>PRODUCTO</strong>. 
        </div>
    ';
    }

    $saveData = null;
?>