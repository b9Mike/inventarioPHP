<div class="container is-fluid mb-6">
    <h1 class="title">Productos</h1>
    <h2 class="subtitle">Lista de productos por categoría</h2>
</div>

<div class="container pb-6 pt-6">

    <?php
        require_once "./php/main.php";
    ?>

    <div class="columns">

        <div class="column is-one-third">
            <h2 class="title has-text-centered">Categorías</h2>

            <?php
                $getCategories = conexion();
                $getCategories = $getCategories->query("SELECT categories_id, categories_name FROM categories");

                if($getCategories->rowCount() > 0){
                    $getCategories = $getCategories->fetchAll();
                    foreach($getCategories as $rw){
                        echo '<a href="index.php?vista=product_category&categorie_id='.$rw['categories_id'].'" class="button is-fullwidth">'.$rw['categories_name'].'</a>';
                    }
                }else{
                    echo '<p class="has-text-centered" >No hay categorías registradas</p>';
                }

                $getCategories = null;
            ?>

        </div>



        <div class="column">

            <?php
                $categorie_id = (isset($_GET['categorie_id'])) ? $_GET['categorie_id']: 0;

                $getCategory = conexion();
                $getCategory = $getCategory->query("SELECT categories_id, categories_name, categories_location FROM categories WHERE categories_id = $categorie_id");

                if($getCategory->rowCount() > 0){
                    $getCategory = $getCategory->fetch();
                    
                    echo '<h2 class="title has-text-centered">'.$getCategory["categories_name"].'</h2>
                        <p class="has-text-centered pb-6" >'.$getCategory["categories_location"].'</p>';

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

                        $page = cleanString($page);
                        $url = 'index.php?vista=product_category&categorie_id='.$categorie_id.'&page=';
                        $registers = 4;
                        $search = "";

                        require_once('./php/ProductList.php');

                }else{
                    echo ' <h2 class="has-text-centered title" >Seleccione una categoría para empezar</h2>';
                }

                $getCategory = null;
            ?>

           

        </div>

    </div>
</div>