<?php
    require_once('./php/main.php');

    $id = (isset($_GET['product_id'])) ? $_GET['product_id'] : 0 ;
	$id = cleanString($id);
?>

<div class="container is-fluid mb-6">
	<h1 class="title">Productos</h1>
	<h2 class="subtitle">Actualizar imagen de producto</h2>
</div>

<div class="container pb-6 pt-6">

    <?php 
		include './inc/btn_back.php';
		
		$checkProduct = conexion();
		$checkProduct = $checkProduct->query("SELECT * FROM products WHERE products_id = $id");

		if ($checkProduct->rowCount() > 0) {
			$data = $checkProduct->fetch();
	?>

	<div class="form-rest mb-6 mt-6"></div>

	<div class="columns">
		<div class="column is-two-fifths">

            <?php
                if(is_file("./img/producto/".$data['products_image'])){
            ?>

			<figure class="image mb-6">
                <img src="./img/producto/<?php echo $data['products_image'];?>">
			</figure>
			<form class="Formjax" action="./php/ProductImageDelete.php" method="POST" autocomplete="off" >

				<input type="hidden" name="img_del_id" value="<?php echo $id; ?>">

				<p class="has-text-centered">
					<button type="submit" class="button is-danger is-rounded">Eliminar imagen</button>
				</p>
			</form>
			
            <?php
               }else{
            ?>
            
			<figure class="image mb-6">
			  	<img src="./img/box.png">
			</figure>

            <?php
               }
            ?>
			
		</div>


		<div class="column">
			<form class="mb-6 has-text-centered Formjax" action="./php/ProductImageUp.php" method="POST" enctype="multipart/form-data" autocomplete="off" >

				<h4 class="title is-4 mb-6"><?php echo $data['products_name']; ?></h4>
				
				<label>Foto o imagen del producto</label><br>

				<input type="hidden" name="img_up_id" value="<?php echo $id; ?>">

				<div class="file has-name is-horizontal is-justify-content-center mb-6">
				  	<label class="file-label">
				    	<input class="file-input" type="file" name="producto_foto" accept=".jpg, .png, .jpeg" >
				    	<span class="file-cta">
				      		<span class="file-label">Imagen</span>
				    	</span>
				    	<span class="file-name">JPG, JPEG, PNG. (MAX 3MB)</span>
				  	</label>
				</div>
				<p class="has-text-centered">
					<button type="submit" class="button is-success is-rounded">Actualizar</button>
				</p>
			</form>
		</div>
	</div>

    <?php
		}else{
			include './inc/error_alert.php';
		}

		$checkProduct = null;

	?>

</div>