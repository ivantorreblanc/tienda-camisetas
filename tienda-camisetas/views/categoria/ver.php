<?php if (isset($categoria)): ?>
    <h1>Productos de la categoria: "
        <?= $categoria->nombre ?>"
    </h1>
    <?php if ($productos->num_rows != 0): ?>
        <?php while ($product = $productos->fetch_object()): ?>
            <div class="product">
                <a href="<?= base_url ?>producto/ver&id=<?= $product->id ?>">
                    <?php if ($product->imagen != null): ?>
                        <img src="<?= base_url ?>uploads/images/<?= $product->imagen ?>" />
                    <?php else: ?>
                        <img src="<?= base_url ?>assets/img/camiseta.png" />
                    <?php endif; ?>
                    <?php if(strlen($product->nombre)<20): ?>
                <h2><?=$product->nombre?></h2>
                    <?php else: ?>
                        <h2><?=trim(substr($product->nombre, 0, 18))?>..</h2>
                    <?php endif; ?>
                </a>
                <p><?= $product->precio ?> &euro;</p>
                <?php if($product->stock > 0): ?>
                    <a href="<?=base_url?>carrito/add&id=<?=$product->id?>" class="button">Comprar</a> 
                <?php else: ?>
                    <span class="disabled-button">Sin Stock</span> 
                <?php endif; ?>        
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <h3><i>No hay productos para mostrar... :/</i></h3>
    <?php endif; ?>
<?php else: ?>
    <h1>La categoria no existe</h1>
<?php endif; ?>