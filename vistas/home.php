<section class="section">
    <h1 class="title">Bienvenido</h1>
    <h2 class="subtitle">
        Al mejor <strong>Gestor de inventario</strong> para
        ti.
    </h2>
    <?php
        if(isset($_SESSION['name']))
            echo "<h3 class='subtitle'> Bienvenido <strong>".$_SESSION['name']."</strong></h3>"
    ?>
</section>