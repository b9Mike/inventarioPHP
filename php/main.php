<?php

    #conexión a la base de datos
    function conexion(){
        $dsn = 'mysql:host=localhost;dbname=inventario_bd';
        $username = 'root';
        $password = '';

        try{

            $pdo = new PDO($dsn, $username, $password);

            return $pdo;
        }catch(PDOException $e){
            echo "La conexión presenta el siguiente error: ". $e->getMessage();
        }
    }

    #validar formularios
    function dataValidator($filter, $string){
        if(preg_match("/^".$filter."$/",$string))
            return false;
        else
            return true;
    }

    #validar insercción de datos
    function cleanString($cadena){
        $cadena=trim($cadena);
		$cadena=stripslashes($cadena);
		$cadena=str_ireplace("<script>", "", $cadena);
		$cadena=str_ireplace("</script>", "", $cadena);
		$cadena=str_ireplace("<script src", "", $cadena);
		$cadena=str_ireplace("<script type=", "", $cadena);
		$cadena=str_ireplace("SELECT * FROM", "", $cadena);
		$cadena=str_ireplace("DELETE FROM", "", $cadena);
		$cadena=str_ireplace("INSERT INTO", "", $cadena);
		$cadena=str_ireplace("DROP TABLE", "", $cadena);
		$cadena=str_ireplace("DROP DATABASE", "", $cadena);
		$cadena=str_ireplace("TRUNCATE TABLE", "", $cadena);
		$cadena=str_ireplace("SHOW TABLES;", "", $cadena);
		$cadena=str_ireplace("SHOW DATABASES;", "", $cadena);
		$cadena=str_ireplace("<?php", "", $cadena);
		$cadena=str_ireplace("?>", "", $cadena);
		$cadena=str_ireplace("--", "", $cadena);
		$cadena=str_ireplace("^", "", $cadena);
		$cadena=str_ireplace("<", "", $cadena);
		$cadena=str_ireplace("[", "", $cadena);
		$cadena=str_ireplace("]", "", $cadena);
		$cadena=str_ireplace("==", "", $cadena);
		$cadena=str_ireplace(";", "", $cadena);
		$cadena=str_ireplace("::", "", $cadena);
		$cadena=trim($cadena);
		$cadena=stripslashes($cadena);
		return $cadena;
    }

	#renombrar nombre de imagenes
	function renameImages($nameImage){
		$nameImage = str_ireplace(" ", "_", $nameImage);
		$nameImage = str_ireplace("/", "_", $nameImage);
		$nameImage = str_ireplace("#", "_", $nameImage);
		$nameImage = str_ireplace("-", "_", $nameImage);
		$nameImage = str_ireplace("$", "_", $nameImage);
		$nameImage = str_ireplace(".", "_", $nameImage);
		$nameImage = str_ireplace(",", "_", $nameImage);
		$nameImage = str_ireplace("<", "_", $nameImage);
		$nameImage = str_ireplace(">", "_", $nameImage);
		$nameImage .= "_".rand(1,100);

		return $nameImage;
	}

	# Función para paginación :D
	function paginationTable($page, $numberPage, $url, $buttons){
		$table = '<nav class="pagination is-centered is-rounded" role="navigation" aria-label="pagination">';

		#inicio de la tabla
		if($page <= 1){
			$table .= '
				<a class="pagination-previous is-disabled" disabled>Anterior</a>
				<ul class="pagination-list">
				';
		}else{
			$table .= '	
				<a class="pagination-previous" href="'.$url.($page - 1).'">Anterior</a>
				<ul class="pagination-list">
					<li><a class="pagination-link" href="'.$url.'1">1</a></li>
					<li><span class="pagination-ellipsis">&hellip;</span></li>
				';
		}

		#enmedio de la tabla

		$count = 0;
		for($i = $page; $i <= $numberPage; $i++){

			if($count >= $buttons)
				break;

			if($page == $i){
				$table .= '<li><a class="pagination-link is-current" href="'.$url.$i.'">'.$i.'</a></li>';
			}else{
				$table .= '<li><a class="pagination-link" href="'.$url.$i.'">'.$i.'</a></li>';
			}

			$count++;
		}

		#final de la tabla
		if($page == $numberPage){
			$table .= '
				</ul>
				<a class="pagination-next is-disabled" disabled>Siguiente</a>
				';
		}else{
			$table .= '	
					<li><span class="pagination-ellipsis">&hellip;</span></li>
					<li><a class="pagination-link" href="'.$url.$numberPage.'">'.$numberPage.'</a></li>
				</ul>
				<a class="pagination-next" href="'.$url.($page + 1).'">Siguiente</a>
				';
		}

		$table .= '</nav>';
		
		return $table;
	}

?>