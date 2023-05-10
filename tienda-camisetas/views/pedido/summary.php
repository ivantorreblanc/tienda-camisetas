<?php if ($_SESSION['pedido'] = 'complete' && Utils::isLogged()): ?>

    <h1>Confirmado! Resumen del Pedido</h1>
    <p>Tu pedido ha sido guardado con exito, una vez realizada la transferencia bancaria a la cuenta 1456852648758248ADD
        con el coste total, el pedido sera procesado y enviado.</p>
    <br />
    <?php if (isset($pedido)): ?>

        <h3>Datos del pedido: </h3>
        Nro. de pedido: <?= $pedido->id ?><br />
        Total a pagar: <?= $pedido->coste ?> &euro;<br />
        Productos:
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
                    <a href="<?= base_url ?>producto/ver&id=<?= $producto->id ?>"><img
                            src="<?= base_url ?>uploads/images/<?= $producto->imagen ?>" class="img_carrito" /></a>
                <?php else: ?>
                    <a href="<?= base_url ?>producto/ver&id=<?= $producto->id ?>"><img src="<?= base_url ?>assets/img/camiseta.png"
                            class="img_carrito" /></a>
                <?php endif; ?>
            </td>
            <td><a href="<?= base_url ?>producto/ver&id=<?= $producto->id ?>"><?= $producto->nombre; ?></a></td>
            <td>
                <?= $producto->precio; ?>
            </td>
            <td>
                <?= $producto->unidades?>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

    <?php endif; ?>

<?php else: ?>
    <?php if(!Utils::isLogged()): 
        header('Location:'.base_url); 
    endif;?> 
    <h1>Ha habido un problema procesando tu pedido</h1>
    <p>Tu pedido no se ha podido almacenar, por favor verifica los pasos previos.</p>

<?php endif; ?>