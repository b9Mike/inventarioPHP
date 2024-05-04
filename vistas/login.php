<div class="main_container">
    <form class="box login" action="" method="POST">
        <h5 class="title is-5 has-text-centered is-uppercase">Sistema de inventario</h5>
        <div class="field">
            <label class="label">usuario</label>
            <div class="control">
                <input class="input" type="text" name="user" placeholder="Juan12" />
            </div>
        </div>

        <div class="field">
            <label class="label">Contraseña</label>
            <div class="control">
                <input class="input" type="password" name="password" placeholder="********" />
            </div>
        </div>

        <p class="has-text-centered mb-4 mt-3">
			<button type="submit" class="button is-info is-dark is-rounded">Iniciar sesion</button>
		</p>

        <?php
            if(isset($_POST['user']) && isset($_POST['password'])){
                require_once("./php/main.php");
                require_once("./php/Session_star.php");

            }
        ?>

    </form>
</div>