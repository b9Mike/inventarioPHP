<?php
    require_once './main.php';

    $category_name      = cleanString($_POST['category_name']);
    $category_location  = cleanString($_POST['category_location']);

    if ($category_name == "" ) {
        echo '
                <div class="notification is-danger">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    No has llenado todos los campos requeridos
                </div>
            ';
        exit();
    }

    #   Verificando integridad de los datos
    if (dataValidator("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{4,50}", $category_name)) {
        echo '
                <div class="notification is-danger">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    El <strong>NOMBRE</strong> no coincide con el formato seleccionado 
                </div>
            ';
        exit();
    }

    if($category_location != ""){

        if (dataValidator("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{5,150}", $category_location)) {
            echo '
                    <div class="notification is-danger">
                        <strong>¡Ocurrio un error inesperado!</strong><br>
                        La <strong>UBICACIÓN</strong> no coincide con el formato seleccionado 
                    </div>
                ';
            exit();
        }

    }

    #verificar nombre de categoria
    $checkCategory = conexion();
    $checkCategory = $checkCategory->prepare("SELECT categories_name FROM categories WHERE categories_name = :category_name");
    $checkCategory->bindParam("category_name", $category_name);
    $checkCategory->execute();


    if($checkCategory->rowCount() > 0){
        echo '
            <div class="notification is-danger">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La <strong>CATEGORIA</strong> ya existe. 
            </div>
        ';

        $checkCategory = null;
        exit();
    }

    $checkCategory = null;


    #Guardar datos
    $saveData = conexion();
    $saveData = $saveData->prepare("INSERT INTO categories (categories_name, categories_location) VALUES(:categories_name, :categories_location)");
    $saveData->bindParam("categories_name", $category_name);
    $saveData->bindParam("categories_location", $category_location);
    $saveData->execute();

    if($saveData->rowCount() > 0){
        echo '
            <div class="notification is-info">
                <strong>¡SE GUARDO LA CATEGORIA!</strong><br>
                La categoria <strong>'.$category_name.'</strong> ha sido guardada. 
            </div>
        ';
    }else{
        echo '
        <div class="notification is-danger">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No se pudo guardar la <strong>CATEGORIA</strong>. 
        </div>
    ';
    }

    $saveData = null;

?>