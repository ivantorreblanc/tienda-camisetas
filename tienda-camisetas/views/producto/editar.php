    <h1>Editar producto "<?= $pro->nombre ?>"</h1>

    <div class="form_container">
        <form action="<?= base_url; ?>producto/save&id=<?= $pro->id ?>" method="POST" enctype="multipart/form-data">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" value="<?= $pro->nombre; ?>" />

            <label for="descripcion">Descripcion</label>
            <textarea name="descripcion"><?= $pro->descripcion ?></textarea>

            <label for="precio">Precio</label>
            <input type="text" name="precio" value="<?= $pro->precio; ?>" />

            <label for="stock">Stock</label>
            <input type="number" name="stock" value="<?= $pro->stock; ?>" />

            <label for="categoria_id">Categoria</label>
            <?php $categorias = Utils::showCategorias(); ?>
            <select name="categoria_id">
                <?php while ($cat = $categorias->fetch_object()): ?>
                    <option value="<?= $cat->id ?>" <?=$cat->id==$pro->categoria_id ? 'selected' : '';?>>
                        <?= $cat->nombre; ?>
                    </option>
                <?php endwhile; ?>

            </select>

            <label for="imagen">Imagen</label>
            <?php if(!empty($pro->imagen)): ?>
                <img src="<?=base_url?>uploads/images/<?=$pro->imagen?>" class="thumb" />
            <?php endif;?>
            <input type="file" name="imagen" />

            <input type="submit" value="Guardar" />

        </form>
    </div>