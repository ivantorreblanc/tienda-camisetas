<h1>Algunos de nuestros productos</h1>
<?php while ($product = $productos->fetch_object()): ?>
    <div class="product">
        <a href="<?=base_url?>producto/ver&id=<?=$product->id?>">
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

            <a href="<?=base_url?>carrito/add&id=<?=$product->id?>" class="button">Comprar</a>
    </div>
<?php endwhile; ?>