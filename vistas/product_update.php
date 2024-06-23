<?php
    require_once('./php/main.php');

    $id = (isset($_GET['product_id'])) ? $_GET['product_id'] : 0 ;
	$id = cleanString($id);
?>

<div class="container is-fluid mb-6">
	<h1 class="title">Productos</h1>
	<h2 class="subtitle">Actualizar producto</h2>
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
	
	<h2 class="title has-text-centered"><?php echo $data['products_name']; ?></h2>

	<form action="./php/ProductUpdate.php" method="POST" class="Formjax" autocomplete="off" >

		<input type="hidden" name="producto_id" required value="<?php echo $data['products_id']; ?>">

		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Código de barra</label>
				  	<input class="input" type="text" name="producto_codigo" pattern="[a-zA-Z0-9- ]{1,70}" maxlength="70" required value="<?php echo $data['products_code']; ?>">
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Nombre</label>
				  	<input class="input" type="text" name="producto_nombre" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,70}" maxlength="70" required value="<?php echo $data['products_name']; ?>">
				</div>
		  	</div>
		</div>
		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Precio</label>
				  	<input class="input" type="text" name="producto_precio" pattern="[0-9.]{1,25}" maxlength="25" required value="<?php echo $data['products_price']; ?>">
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Stock</label>
				  	<input class="input" type="text" name="producto_stock" pattern="[0-9]{1,25}" maxlength="25" required value="<?php echo $data['products_stock']; ?>">
				</div>
		  	</div>
              <div class="column">
				<div class="control">
					<label>Descripción</label>
					<input class="input" type="text" name="producto_descripcion" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,70}" maxlength="25" required value="<?php echo $data['products_description']; ?>">
				</div>
			</div>
		  	<div class="column">
				<label>Categoría</label><br>
		    	<div class="select is-rounded">
				  	<select name="producto_categoria" >

                        <?php
                            $getCategories = conexion();
                            $getCategories = $getCategories->query("SELECT categories_id, categories_name FROM categories");

                            if ($getCategories->rowCount() > 0) {
                                $getCategories = $getCategories->fetchAll();
                                foreach ($getCategories as $rw) {
                                    if($data['categories_id'] == $rw['categories_id']){
                                        echo '<option selected="" value="' . $rw["categories_id"] . '" >' . $rw["categories_name"] . ' (Actual)</option>';
                                    }else{
                                        echo '<option value="' . $rw["categories_id"] . '" >' . $rw["categories_name"] . '</option>';
                                    }
                                }
                            }

                            $getCategories = null;
                        ?>
				  	</select>
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

		$checkProduct = null;

	?>

</div>