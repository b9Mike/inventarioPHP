<?php

    $indice = ($page>0) ? (($page*$registers) - $registers) : 0;
    $table = "";

    $campos = "products.products_id, products.products_code, products.products_name, products.products_price, products.products_stock, products.products_image, categories.categories_name, users.user_name, users.user_lastname";

    if(isset($search) && $search != ""){

        $queryDate = "SELECT $campos FROM products 
                    INNER JOIN categories ON products.categories_id = categories.categories_id
                    INNER JOIN users ON products.user_id = users.user_id WHERE products.products_code LIKE '%$search%'
                    OR products.products_name LIKE '%$search%' ORDER BY products.products_name ASC LIMIT $indice, $registers";

        $queryTotal = "SELECT COUNT(products_id) FROM products WHERE products_code LIKE '%$search%'
                    OR products_name LIKE '%$search%'";

    }elseif($categorie_id>0){
        $queryDate = "SELECT $campos FROM products 
                    INNER JOIN categories ON products.categories_id = categories.categories_id
                    INNER JOIN users ON products.user_id = users.user_id WHERE products.categories_id = '$categorie_id'
                    ORDER BY products.products_name ASC LIMIT $indice, $registers";

        $queryTotal = "SELECT COUNT(products_id) FROM products WHERE categories_id = '$categorie_id'";

    }else{
        $queryDate = "SELECT $campos FROM products 
                    INNER JOIN categories ON products.categories_id = categories.categories_id
                    INNER JOIN users ON products.user_id = users.user_id ORDER BY products.products_name ASC LIMIT $indice, $registers";

        $queryTotal = "SELECT COUNT(products_id) FROM products";
    }

    $conexion = conexion();

    $dates = $conexion->query($queryDate);
    $dates = $dates->fetchAll();

    $total = $conexion->query($queryTotal);
    $total = (int) $total->fetchColumn();

    $numberPages = ceil($total/$registers);

    

    if($total >= 1 && $page <= $numberPages){
        $count = $indice + 1;
        $pageStart = $indice + 1;
        foreach($dates as $date){
            
            $table .= '
             <article class="media">
                <figure class="media-left">
                    <p class="image is-64x64">';

                    if(is_file("./img/producto/".$date['products_image'])){
                    
                        $table .= '<img src="./img/producto/'.$date['products_image'].'">';
                    }else{

                        $table .= '<img src="./img/box.png">';
                    }
            $table .= '</p>
                </figure>
                <div class="media-content">
                    <div class="content">
                        <p>
                            <strong>'.$count.' - '.$date['products_name'].'</strong><br>
                            <strong>CODIGO:</strong> '.$date['products_code'].', 
                            <strong>PRECIO:</strong> $'.$date['products_price'].', 
                            <strong>STOCK:</strong> '.$date['products_stock'].',
                            <strong>CATEGORIA:</strong> '.$date['categories_name'].', 
                            <strong>REGISTRADO POR:</strong> '.$date['user_name'].' '.$date['user_lastname'].'
                        </p>
                    </div>
                    <div class="has-text-right">
                        <a href="index.php?vista=product_img&product_id='.$date['products_id'].'" class="button is-link is-rounded is-small">Imagen</a>

                        <a href="index.php?vista=product_update&product_id='.$date['products_id'].'" class="button is-success is-rounded is-small">Actualizar</a>

                        <a href="'.$url.$page.'&product_id_del='.$date['products_id'].'" class="button is-danger is-rounded is-small">Eliminar</a>
                    </div>
                </div>
            </article>


            <hr>
            ';
            $count++;
        }

        $pageEnd = $count - 1;

    }else{
        if($total >= 1){
            $table .= '
            <p class="has-text-centered">
                <a href="'.$url.'1" class="button is-link is-rounded is-small mt-4 mb-4">
                    Haga clic acá para recargar el listado
                </a>
            </p>
            ';
        }else{
            $table .= '
                    <p class="has-text-centered">No hay registros en el sistema</p>
            ';
        }
    }

    

    if($total >= 1  && $page <= $numberPages){
        $table .= '<p class="has-text-right">Mostrando productos <strong>'.$pageStart.'</strong> 
        al <strong>'.$pageEnd.'</strong> de un <strong>total de '.$total.'</strong></p>';
    }

    $conexion = null;
    
    echo $table;

    if($total >= 1  && $page <= $numberPages){
        echo paginationTable($page, $numberPages, $url, 3);
    }
?>