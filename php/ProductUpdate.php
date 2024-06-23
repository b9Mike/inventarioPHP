<?php

    require_once './main.php';

    
    $id = cleanString($_POST['producto_id']);
    
    //verificar el rpoducto
    $checkProduct = conexion();
    $checkProduct = $checkProduct->query("SELECT * FROM products WHERE products_id = $id");

    if($checkProduct->rowCount() <= 0){

        echo '
            <div class="notification is-danger">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                Error al actualizar el producto en la base de datos.
            </div>
        ';
        $checkProduct = null;
        exit();
        
    }else{

        $product = $checkProduct->fetch();   
    }
    
    $checkProduct = null;

    //almacenar datos en variables
    $producto_codigo        = cleanString($_POST['producto_codigo']);
    $producto_nombre        = cleanString($_POST['producto_nombre']);
    $producto_precio        = cleanString($_POST['producto_precio']);
    $producto_stock         = cleanString($_POST['producto_stock']);
    $producto_categoria     = cleanString($_POST['producto_categoria']);
    $producto_descripcion   = cleanString($_POST['producto_descripcion']);

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

    #   validar codigo de barras

    if($producto_codigo != $product['products_code']){
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
    }


    #   validar nombre del producto
    if($producto_nombre != $product['products_name']){

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
    }

    if($producto_categoria != $product['categories_id']){
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
    }

    #Guardando el producto 
    #Guardar datos
    $saveData = conexion();
    
    $saveData = $saveData->prepare("UPDATE products SET products_name=:products_name, products_description=:products_description, products_price=:products_price, 
    products_stock=:products_stock, products_code=:products_code, categories_id=:categories_id WHERE products_id = :id");
    
    $markers = [
        ":products_name" => $producto_nombre, 
        ":products_description" => $producto_descripcion, 
        ":products_price" => $producto_precio,
        ":products_stock" => $producto_stock,
        ":products_code" => $producto_codigo,
        ":categories_id" => $producto_categoria,
        "id" => $id
    ];

    $saveData->execute($markers);

    if($saveData->rowCount() == 1){
        echo '
            <div class="notification is-info">
                <strong>¡SE ACTUALIZO EL PRODUCTO!</strong><br>
                El producto <strong>'.$producto_nombre.'</strong> ha sido actualizado con exito. 
            </div>
        ';
    }else{
        echo '
            <div class="notification is-danger">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No se pudo actualizar el <strong>PRODUCTO</strong>. 
            </div>
        ';
    }

    $saveData = null;

?>