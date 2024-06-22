<?php

    $indice = ($page>0) ? (($page*$registers) - $registers) : 0;
    $table = "";

    if(isset($search) && $search != ""){

        $queryDate = "SELECT * FROM categories WHERE categories_name LIKE
        '%$search%' OR categories_location LIKE '%$search%' ORDER BY categories_name ASC LIMIT $indice, $registers";

        $queryTotal = "SELECT COUNT(categories_id) FROM categories WHERE categories_name LIKE
        '%$search%' OR categories_location LIKE '%$search%'";

    }else{
        $queryDate = "SELECT * FROM categories ORDER BY categories_name ASC LIMIT $indice, $registers";

        $queryTotal = "SELECT COUNT(categories_id) FROM categories";
    }

    $conexion = conexion();

    $dates = $conexion->query($queryDate);
    $dates = $dates->fetchAll();

    $total = $conexion->query($queryTotal);
    $total = (int) $total->fetchColumn();

    $numberPages = ceil($total/$registers);

    $table .= '
        <div class="table-container">
            <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                <thead>
                    <tr class="has-text-centered">
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Ubicación</th>
                        <th>Productos</th>
                        <th colspan="2">Opciones</th>
                    </tr>
                </thead>
                <tbody>
    ';

    if($total >= 1 && $page <= $numberPages){
        $count = $indice + 1;
        $pageStart = $indice + 1;
        foreach($dates as $date){
            $str = substr($date['categories_location'],0,25);
            $location = ($str == "") ? "No hay información" : $str;
            $table .= '
            <tr class="has-text-centered" >
                <td>'.$count.'</td>
                <td>'.$date['categories_name'].'</td>
                <td>'.$location.'</td>
                <td>
                    <a href="index.php?vista=product_category&categorie_id='.$date['categories_id'].'" class="button is-link is-rounded is-small">Ver productos</a>
                </td>
                <td>
                    <a href="index.php?vista=category_update&categorie_id='.$date['categories_id'].'" class="button is-success is-rounded is-small">Actualizar</a>
                </td>
                <td>
                    <a href="'.$url.$page.'&category_id_del='.$date['categories_id'].'" class="button is-danger is-rounded is-small">Eliminar</a>
                </td>
            </tr>
            ';
            $count++;
        }

        $pageEnd = $count - 1;

    }else{
        if($total >= 1){
            $table .= '
                <tr class="has-text-centered" >
                    <td colspan="6">
                        <a href="'.$url.'1" class="button is-link is-rounded is-small mt-4 mb-4">
                            Haga clic acá para recargar el listado
                        </a>
                    </td>
                </tr>
            ';
        }else{
            $table .= '
            <tr class="has-text-centered" >
                <td colspan="6">
                    No hay registros en el sistema
                </td>
            </tr>
            ';
        }
    }

    
    $table .= '</tbody></table></div>';

    if($total >= 1  && $page <= $numberPages){
        $table .= '<p class="has-text-right">Mostrando categorias <strong>'.$pageStart.'</strong> 
        al <strong>'.$pageEnd.'</strong> de un <strong>total de '.$total.'</strong></p>';
    }

    $conexion = null;
    
    echo $table;

    if($total >= 1  && $page <= $numberPages){
        echo paginationTable($page, $numberPages, $url, 3);
    }
?>