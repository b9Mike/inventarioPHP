<?php

    $indice = ($page>0) ? (($page*$registers) - $registers) : 0;
    $table = "";

    if(isset($search) && $search != ""){

        $queryDate = "SELECT * FROM users WHERE ( (user_id != '".$_SESSION['id']."') AND 
        (user_name LIKE '%$search%' OR user_lastname LIKE '%$search%') ) ORDER BY user_name ASC LIMIT $indice, $registers";

        $queryTotal = "SELECT COUNT(user_id) FROM users WHERE ( (user_id != '".$_SESSION['id']."') AND 
        (user_name LIKE '%$search%' OR user_lastname LIKE '%$search%') )";

    }else{
        $queryDate = "SELECT * FROM users WHERE user_id != '".$_SESSION['id']."' ORDER BY user_name ASC LIMIT $indice, $registers";

        $queryTotal = "SELECT COUNT(user_id) FROM users WHERE user_id != '".$_SESSION['id']."'";
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
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Usuario</th>
                        <th>Email</th>
                        <th colspan="2">Opciones</th>
                    </tr>
                </thead>
                <tbody>
    ';

    if($total >= 1 && $page <= $numberPages){
        $count = $indice + 1;
        $pageStart = $indice + 1;
        foreach($dates as $date){

            $table .= '
            <tr class="has-text-centered" >
                <td>'.$count.'</td>
                <td>'.$date['user_name'].'</td>
                <td>'.$date['user_lastname'].'</td>
                <td>'.$date['user_nickname'].'</td>
                <td>'.$date['user_email'].'</td>
                <td>
                    <a href="index.php?vista=user_update&user_id_up='.$date['user_id'].'" class="button is-success is-rounded is-small">Actualizar</a>
                </td>
                <td>
                    <a href="'.$url.$page.'&user_id_del='.$date['user_id'].'" class="button is-danger is-rounded is-small">Eliminar</a>
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
                    <td colspan="7">
                        <a href="'.$url.'1" class="button is-link is-rounded is-small mt-4 mb-4">
                            Haga clic acá para recargar el listado
                        </a>
                    </td>
                </tr>
            ';
        }else{
            $table .= '
            <tr class="has-text-centered" >
                <td colspan="7">
                    No hay registros en el sistema
                </td>
            </tr>
            ';
        }
    }

    
    $table .= '</tbody></table></div>';

    if($total >= 1  && $page <= $numberPages){
        $table .= '<p class="has-text-right">Mostrando usuarios <strong>'.$pageStart.'</strong> 
        al <strong>'.$pageEnd.'</strong> de un <strong>total de '.$total.'</strong></p>';
    }

    $conexion = null;
    
    echo $table;

    if($total >= 1  && $page <= $numberPages){
        echo paginationTable($page, $numberPages, $url, 3);
    }
?>