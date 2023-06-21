<h1 class="nombre-pagina">Recuperar Password</h1>
<p class="descripcion-pagina">Coloca tu nuevo Password a continuacion</p>

<?php include_once __DIR__. '/../templates/alertas.php'?>

<?php if($error) return null;?>

<form class="formulario" method="POST">

    <div class="campo">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" placeholder="Tu Nueva Password"/>
    </div>

    <input type="submit" value="Guardar Nuevo Password" class="boton"/>

</form>


<div class="acciones">
    <a href="/">¿Ya tienes una cuenta?, Inicia Sesión</a>
    <a href="/crear-cuenta">¿No tienes una cuenta?, Registrate</a>
</div>