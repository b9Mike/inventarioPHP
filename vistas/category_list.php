<div class="container is-fluid mb-6">
    <h1 class="title">Categorías</h1>
    <h2 class="subtitle">Lista de categoría</h2>
</div>

<div class="container pb-6 pt-6">

<?php
    require_once('./php/main.php');

    //Eliminar usuario
    if(isset($_GET['category_id_del'])){
        require_once('./php/CategoryDelete.php');
    }

    if(!isset($_GET['page'])){
        $page = 1;
    }else{
        $page = (int) $_GET['page'];
        if($page <= 1)
            $page = 1;
    }

    $page = cleanString($page);
    $url = 'index.php?vista=category_list&page=';
    $registers = 3;
    $search = "";

    require_once('./php/CategoryList.php');
?>
    
</div>