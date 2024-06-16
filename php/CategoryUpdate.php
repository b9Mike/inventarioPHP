<?php
    require_once './main.php';

    //datos del usuario
    $id = cleanString($_POST['categoria_id']);

    $checkCategorie = conexion();
    $checkCategorie = $checkCategorie->query("SELECT * FROM categories WHERE categories_id = $id");

    if($checkCategorie->rowCount() <= 0){

        echo '
            <div class="notification is-danger">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                Error al actualizar la categoria en la base de datos.
            </div>
        ';
        $checkCategorie = null;
        exit();
        
    }else{

        $category = $checkCategorie->fetch();   
    }
    
    $checkCategorie = null;

    //datos recibidos 
    $categoryName       = cleanString($_POST['categoria_nombre']);
    $categoryLocation   = cleanString($_POST['categoria_ubicacion']);

    if ($categoryName == "") {
        echo '
                <div class="notification is-danger">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    No has llenado todos los campos requeridos
                </div>
            ';
        exit();
    }

    if (dataValidator("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{4,50}", $categoryName)) {
        echo '
                <div class="notification is-danger">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    El <strong>NOMBRE</strong> no coincide con el formato seleccionado 
                </div>
            ';
        exit();
    }
    if (dataValidator("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{5,150}", $categoryLocation)) {
        echo '
                <div class="notification is-danger">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    La <strong>UBICACIÓN</strong> no coincide con el formato seleccionado 
                </div>
            ';
        exit();
    }

    $updateData = conexion();

    $sql = "UPDATE categories SET categories_name=:categories_name, categories_location=:categories_location WHERE categories_id =:id";

    $updateData = $updateData->prepare($sql);

    $markers = [
        ":categories_name" => $categoryName, 
        ":categories_location" => $categoryLocation, 
        ":id" => $id
    ];

    if($updateData->execute($markers)){
        echo '
            <div class="notification is-info">
                <strong>Categoria ACTUALIZADO!</strong><br>
                Se ha actualizado la categoria correctamente.
            </div>
        ';
    }else{
        echo '
            <div class="notification is-danger">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                Error al actualizar la categoria a la base de datos.
            </div>
        ';
    }
    $updateData = null;


?>