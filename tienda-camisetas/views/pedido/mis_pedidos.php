<?php if (Utils::isLogged()): ?>
    <?php if ($pedidos->num_rows > 0): ?>
        <?php if(isset($gestion) && $gestion):?>
            <h1>Gestionar Pedidos</h1>
        <?php else: ?>
                <h1>Mis pedidos</h1>
        <?php endif; ?>
        <table>
            <tr>
                <th>Nro. Pedido</th>
                <th>Costo Pedido</th>
                <th>Fecha pedido</th>
                <th>Estado</th>
            </tr>
            <?php while($ped = $pedidos->fetch_object()): ?>
                <tr>
                    <td>
                        <a href="<?=base_url?>pedido/detalle&id=<?=$ped->id?>"><?=$ped->id?></a>
                    </td>
                    <td>
                        <?=$ped->coste; ?> &euro;
                    </td>
                    <td>
                        <?= $ped->fecha; ?>
                    </td>
                    <td>
                    <a href="<?=base_url?>pedido/detalle&id=<?=$ped->id?>"><?= Utils::showStatus($ped->estado); ?></a>
                    </td>
                </tr>

            <?php endwhile; ?>
        </table>
    <?php else:?>
        <h1>No se encontraron pedidos registrados</h1>
            <p>En este segmento se muestran los pedidos del usuario.</p>
    <?php endif;?>


<?php else: ?>
    <?php header('Location:' . base_url); ?>
<?php endif; ?>