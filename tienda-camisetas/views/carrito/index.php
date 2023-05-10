<h1>Carrito de compras</h1>
<?php if(isset($_SESSION['last']) && $_SESSION['last'] == true): ?>  
    <strong class="alert_red">Lo sentimos, has alcanzado la cantidad máxima disponible en stock</strong>
<?php endif;?>
<?php Utils::deleteSession('last'); ?>
<table>
    <tr>
        <th>Imagen</th>
        <th>Nombre</th>
        <th>Precio</th>
        <th>Cantidad</th>
        <th>Acciones</th>
    </tr>
    <?php
    foreach ($carrito as $indice => $elemento):
        $producto = $elemento['producto'];
        $stock = $elemento['stock'];
        
    
        ?>
        <tr>


            <td>
                <?php if ($producto->imagen != null): ?>
                    <a href="<?= base_url ?>producto/ver&id=<?= $producto->id ?>"><img src="<?= base_url ?>uploads/images/<?= $producto->imagen ?>" class="img_carrito" /></a>
                <?php else: ?>
                    <a href="<?= base_url ?>producto/ver&id=<?= $producto->id ?>"><img src="<?= base_url ?>assets/img/camiseta.png" class="img_carrito" /></a>
                <?php endif; ?>
            </td>
            <td><a href="<?= base_url ?>producto/ver&id=<?= $producto->id ?>"><?= $producto->nombre; ?></a></td>
            <td><?= $producto->precio; ?></td>
            <td>
                <?= $elemento['unidades'] ?>
                <?php if($stock == $elemento['unidades']): ?>
                    (max.)
                <?php endif; ?>
            </td>
            <td id="carrito-buttons">
                <a href="<?=base_url?>carrito/add&id=<?=$producto->id?>" class="button-add">+</a>
                <a href="<?=base_url?>carrito/subtract&id=<?=$producto->id?>" class="button-subtract">-</a>
                <a href="<?=base_url?>carrito/remove&id=<?=$producto->id?>" class="button-delete">x</a>
            </td>
        </tr>

    <?php endforeach;?>
</table>
<?php $stats = Utils::statsCarrito(); ?>
<br />
<div class="delete-carrito">
    <a href="<?=base_url?>carrito/delete_all" class="button button-delete button-red">Vaciar Carrito</a>
</div>
<div class="total-carrito">
    <h3>Precio total: <?=$stats['total']?> &euro;</h3>
    <a href="<?=base_url?>pedido/hacer" class="button button-pedido">Hacer Pedido</a>
</div>