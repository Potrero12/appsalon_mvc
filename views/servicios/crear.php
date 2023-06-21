<h1 class="nombre-pagina">Crear Servicios</h1>
<p class="descripcion-pagina">Llena todos los campos para crear una nuevo servicio</p>

<?php
    // include_once __DIR__ . '/../templates/barra.php';
    include_once __DIR__ . '/../templates/alertas.php';
?>

<form class="formulario" action="/servicios/crear" method="POST">
    <?php 
        include_once __DIR__.'/formulario.php';
    ?>

    <input type="submit" value="Guardar Servicio" class="boton">
</form>