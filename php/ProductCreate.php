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
    $producto_foto          = cleanString($_POST['producto_foto']);

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
    
    #   validar codigo de barras
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


?>