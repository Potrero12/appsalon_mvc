<div class="barra">
    <p>Hola: <?php echo $nombre ?? 'nombre_usuario'?></p>

    <a class="boton" href="/logout">Cerrar Sesión</a>
</div>

<?php if(isset($_SESSION['admin'])) { ?>
    <div class="barra-servicios">
    <a class="boton" href="/admin">Citas</a>
    <a class="boton" href="/servicios">Ver Servicios</a>
    <a class="boton" href="/servicios/crear">Nuevos Servicios</a>
    </div>
<?php }?>