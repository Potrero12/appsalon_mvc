<h1 class="nombre-pagina">Olvide Password</h1>
<p class="descripcion-pagina">Reestablece tu password escribiendo tu email a continuación</p>

<?php include_once __DIR__. '/../templates/alertas.php'?>

<form class="formulario" method="POST" action="/olvide">
    <div class="campo">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" placeholder="Tu Email"/>
    </div>

    <input type="submit" value="Restablecer" class="boton">
</form>

<div class="acciones">
    <a href="/">¿Ya tienes una cuenta?, Inicia Sesión</a>
    <a href="/crear-cuenta">¿Aun no tienes cuenta?, Create una</a>
</div>