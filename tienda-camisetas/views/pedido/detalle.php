<?php if ((isset($pedido) && $pedido->usuario_id == $_SESSION['identity']->id) || isset($_SESSION['admin'])): ?>
    <h1>Detalle del pedido</h1>
    <?php if(isset($_SESSION['admin'])): ?>
        <h3>Cambiar estado del pedido</h3>
        <form action="<?=base_url?>pedido/estado" method="POST">
            <input type="hidden" value="<?=$pedido->id?>" name="pedido_id" />
            <select name="estado">
                <option value="confirm" <?=$pedido->estado == "confirm" ? "selected" : '';?>>Pendiente</option>
                <option value="preparation" <?=$pedido->estado == "preparation" ? "selected" : '';?>>En preparacion</option>
                <option value="ready" <?=$pedido->estado == "ready" ? "selected" : '';?>>Preparado para enviar</option>
                <option value="sent" <?=$pedido->estado == "sent" ? "selected" : '';?>>Enviado</option>
            </select>
            <input type="submit" value="Cambiar Estado" />
        </form>
        <br />
    
    

    <h3>Datos del comprador:</h3>
    Nombre y Apellidos: <?= $user->nombre ?> <?= $user->apellidos ?><br />
    E-mail: <?= $user->email ?><br /><br />
    <?php endif;?>

    <h3>Direccion de envio:</h3>
    Provincia: <?= $pedido->provincia ?><br />
    Localidad: <?= $pedido->localidad ?><br />
    Direccion: <?= $pedido->direccion ?><br /><br />

    <h3>Datos del pedido: </h3>
    Nro. de pedido:
    <?= $pedido->id ?><br />
    Total a pagar:
    <?= $pedido->coste ?> &euro;<br />
    Estado del pedido: <strong><?= Utils::showStatus($pedido->estado)?><br /></strong>
    Productos: <br /><br />
    <table>
        <tr>
            <th>Imagen</th>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Cantidad</th>
        </tr>
        <?php while ($producto = $productos->fetch_object()): ?>
            <tr>
                <td>
                    <?php if ($producto->imagen != null): ?>
                        <a href="<?= base_url ?>producto/ver&id=<?= $producto->id ?>"><img src="<?= base_url ?>uploads/images/<?= $producto->imagen ?>" class="img_carrito" /></a>
                    <?php else: ?>
                        <a href="<?= base_url ?>producto/ver&id=<?= $producto->id ?>"><img src="<?= base_url ?>assets/img/camiseta.png" class="img_carrito" /></a>
                    <?php endif; ?>
                </td>
                <td><a href="<?= base_url ?>producto/ver&id=<?= $producto->id ?>"><?= $producto->nombre; ?></a></td>
                <td>
                    <?= $producto->precio; ?>
                </td>
                <td>
                    <?= $producto->unidades ?>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
<?php else:?>
    <?php header('Location:'.base_url.'pedido/mis_pedidos');?>
<?php endif; ?>