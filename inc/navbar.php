<nav class="navbar" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <a class="navbar-item" href="index.php?vista=home">
            <img src="./img/logo.png" alt="logo del la pagina">
        </a>

        <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
        </a>
    </div>

    <div id="navbarBasicExample" class="navbar-menu">
        <div class="navbar-start">

            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">Usuarios</a>

                <div class="navbar-dropdown">
                    <a class="navbar-item" href="index.php?vista=user_new">
                        Crear
                    </a>
                    <a class="navbar-item" href="index.php?vista=user_list">
                        Lista
                    </a>
                    <a class="navbar-item" href="index.php?vista=user_search">
                        Buscar
                    </a>
                    <hr class="navbar-divider">
                </div>
            </div>

            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">Categorias</a>

                <div class="navbar-dropdown">
                    <a class="navbar-item" href="index.php?vista=category_create">
                        Crear
                    </a>
                    <a class="navbar-item" href="index.php?vista=category_list">
                        Lista
                    </a>
                    <a class="navbar-item" href="index.php?vista=category_search">
                        Buscar
                    </a>
                    <hr class="navbar-divider">
                </div>
            </div>

            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">Productos</a>

                <div class="navbar-dropdown">
                    <a class="navbar-item">
                        Crear
                    </a>
                    <a class="navbar-item">
                        Editar
                    </a>
                    <a class="navbar-item">
                        Eliminar
                    </a>
                    <hr class="navbar-divider">
                </div>
            </div>

        </div>

        <div class="navbar-end">
            <div class="navbar-item">
                <div class="buttons">
                    <a class="button is-primary" href="index.php?vista=user_update&user_id_up=<?php echo $_SESSION['id']; ?>"> Mi Cuenta </a>
                    <a class="button is-light" href="index.php?vista=logout">
                        Salir
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>