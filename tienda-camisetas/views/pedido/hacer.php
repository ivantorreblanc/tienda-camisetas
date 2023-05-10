<?php if(Utils::isLogged()):?>
    <h1>Hacer pedido</h1>
    <a href="<?=base_url?>carrito/index">Ver el carrito</a><br>
    <br>
    <h3>Datos para el envio</h3>
    <form action="<?=base_url?>pedido/add" method="POST">

        <label for="provincia">Provincia</label>
        <input type="text" name="provincia" required />

        <label for="localidad">Localidad</label>
        <input type="text" name="localidad" required />
        
        <label for="direccion">Direccion</label>
        <input type="text" name="direccion" required />

        <input type="submit" value="Confirmar pedido" />

    </form>

<?php else:?>
    <h1>Necesitas estar identificado</h1>
    <p>Necesitar estar logueado para continuar con el pedido</p>

<?php endif;?>
