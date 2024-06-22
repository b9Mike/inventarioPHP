<div class="container is-fluid mb-6">
    <h1 class="title">Productos</h1>
    <h2 class="subtitle">Lista de productos</h2>
</div>

<div class="container pb-6 pt-6">

    <?php
        require_once('./php/main.php');

        //Eliminar producto
        if(isset($_GET['product_id_del'])){
            require_once('./php/ProductDelete.php');
        }

        if(!isset($_GET['page'])){
            $page = 1;
        }else{
            $page = (int) $_GET['page'];
            if($page <= 1)
                $page = 1;
        }

        $categorie_id = (isset($_GET['categorie_id'])) ? $_GET['categorie_id']: 0;

        $page = cleanString($page);
        $url = 'index.php?vista=product_list&page=';
        $registers = 4;
        $search = "";

        require_once('./php/ProductList.php');
    ?>

</div>