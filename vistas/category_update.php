<?php
    
    require_once('./php/main.php');

    $id = (isset($_GET['categorie_id'])) ? $_GET['categorie_id'] : 0 ;
	$id = cleanString($id);
?>

<div class="container is-fluid mb-6">
	<h1 class="title">Categorías</h1>
	<h2 class="subtitle">Actualizar categoría</h2>
</div>

<div class="container pb-6 pt-6">
    <?php 
		include './inc/btn_back.php';
		
		$checkCategory = conexion();
		$checkCategory = $checkCategory->query("SELECT * FROM categories WHERE categories_id = $id");

		if ($checkCategory->rowCount() > 0) {
			$data = $checkCategory->fetch();
	?>

	<div class="form-rest mb-6 mt-6"></div>


	<form action="./php/CategoryUpdate.php" method="POST" class="Formjax" autocomplete="off" >

		<input type="hidden" name="categoria_id" value="<?php echo $data['categories_id'] ?>" required >

		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Nombre</label>
				  	<input class="input" value="<?php echo $data['categories_name'] ?>" type="text" name="categoria_nombre" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{4,50}" maxlength="50" required >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Ubicación</label>
				  	<input class="input" type="text" value="<?php echo $data['categories_location'] ?>" name="categoria_ubicacion" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{5,150}" maxlength="150" >
				</div>
		  	</div>
		</div>
		<p class="has-text-centered">
			<button type="submit" class="button is-success is-rounded">Actualizar</button>
		</p>
	</form>


    <?php
		}else{
			include './inc/error_alert.php';
		}

		$checkCategory = null;

	?>

    
</div>