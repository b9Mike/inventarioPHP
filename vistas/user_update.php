<?php
    
    require_once('./php/main.php');

    $id = (isset($_GET['user_id_up'])) ? $_GET['user_id_up'] : 0 ;
	$id = cleanString($id);
?>

<div class="container is-fluid mb-6">
    <?php if($id == $_SESSION['id']){ ?>

        <h1 class="title">Mi cuenta</h1>
        <h2 class="subtitle">Actualizar datos</h2>

    <?php }else{?>

        <h1 class="title">Usuarios</h1>
        <h2 class="subtitle">Actualizar usuario</h2>
        
    <?php }?>
</div>

<div class="container pb-6 pt-6">

	<?php 
		include './inc/btn_back.php';
		
		$checkUser = conexion();
		$checkUser = $checkUser->query("SELECT * FROM users WHERE user_id = $id");

		if ($checkUser->rowCount() > 0) {
			$data = $checkUser->fetch();
	?>

	<div class="form-rest mb-6 mt-6"></div>

	<form action="./php/UserUpdate.php" method="POST" class="Formjax" autocomplete="off" >

		<input type="hidden" value="<?php echo $data['user_id'] ?>" name="user_id" required >
		
		<div class="columns">
			<div class="column">
				<div class="control">
					<label>Nombres</label>
					<input class="input" type="text" name="userName" value="<?php echo $data['user_name'] ?>" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" required>
				</div>
			</div>
			<div class="column">
				<div class="control">
					<label>Apellidos</label>
					<input class="input" type="text" name="userLastname" value="<?php echo $data['user_lastname'] ?>" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" required>
				</div>
			</div>
			<div class="column">
				<div class="control">
					<label>Edad</label>
					<input class="input" type="text" name="userAge" value="<?php echo $data['user_age'] ?>" pattern="(0?[0-9]?[0-9]|1[01][0-9]|12[0-7])" maxlength="3" required>
				</div>
			</div>
		</div>
		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Usuario</label>
				  	<input class="input" type="text" name="userNickname" value="<?php echo $data['user_nickname'] ?>" pattern="[a-zA-Z0-9]{4,20}" maxlength="20" required >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Email</label>
				  	<input class="input" type="email" name="userEmail" value="<?php echo $data['user_email'] ?>" maxlength="70" >
				</div>
		  	</div>
		</div>
		<br><br>
		<p class="has-text-centered">
			SI desea actualizar la clave de este usuario por favor llene los 2 campos. Si NO desea actualizar la clave deje los campos vacíos.
		</p>
		<br>
		<div class="columns">
			<div class="column">
		    	<div class="control">
					<label>Clave</label>
				  	<input class="input" type="password" name="userPassword" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Repetir clave</label>
				  	<input class="input" type="password" name="confirmUserPassword" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" >
				</div>
		  	</div>
		</div>
		<br><br><br>
		<p class="has-text-centered">
			Para poder actualizar los datos de este usuario por favor ingrese su USUARIO y CLAVE con la que ha iniciado sesión
		</p>
		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Usuario</label>
				  	<input class="input" type="text" name="userAdmin" pattern="[a-zA-Z0-9]{4,20}" maxlength="20" required >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Clave</label>
				  	<input class="input" type="password" name="passAdmin" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required >
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

		$checkUser = null;

	?>


	
</div>